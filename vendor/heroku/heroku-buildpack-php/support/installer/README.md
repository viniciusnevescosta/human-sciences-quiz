# Composer Platform Installer for PHP Buildpack

PHP applications or their dependencies usually require a particular minimum runtime version, and certain binary extensions (e.g. for connecting to MongoDB, Redis, or Postgres). Unlike other language's package managers, Composer cannot build and install these binary extensions during dependency installation. They must be present and loaded by the PHP engine via the `php.ini` config file when `composer install` is run, otherwise this operation will not succeed due to unsatisfied "platform" dependencies.

For this reason, we pre-build not only PHP, but also all the extensions (for each PHP version series), as well as web servers and other programs, and host them in an S3 bucket for installation by the buildpack. Collectively, these packages are called "platform" packages.

The buildpack uses a project's `composer.lock` dependency graph to determine what platform packages to install, by converting that lock file into a new "platform" `composer.json` (**we will call this "`platform.json`" in this document, but the file name on disk is `composer.json`, inside `.heroku/php/`**).

It then installs a minimal PHP runtime and Composer for bootstrapping. It invokes Composer to install the dependencies listed in the generated "`platform.json`", which, using this custom Composer Installer Plugin, will cause the installation of our builds of PHP, extensions, and programs such as the web servers - all pulled from our "platform" repository, hosted on S3. Even Composer (the right version the user's app needs) is installed a second time by this step, as well as any shared libraries that e.g. an extension needs (such as `librdkafka` for `ext-rdkafka`).

In a nutshell: we treat PHP, each external extension, web servers, even Composer itself, as regular Composer packages (we call them "platform packages"), and let Composer use our installer plugin to install them for us in a single operation.

This Composer Installer Plugin knows how to unpack Heroku's platform packages, and contains special logic that will activate installed or bundled extensions, and write `.profile.d/` scripts for packages and PHP INI files for extensions into their destinations in the order of their installation.

The benefit of this approach is that the subsequent installation of userland dependencies (the "regular" `composer install`) will always succeed, because we use the same dependency structure, and Composer's own dependency resolution mechanism, to install anything an application needs.

Otherwise, we'd have to re-implement Composer's dependency resolution rules ourselves, and also track any changes Composer makes in their SAT solver over time.

Consider e.g. a case where an app and its dependencies require PHP, as well as the Redis extension. If it requires `php:*` and `ext-redis:*`, that should give the latest PHP for which an `ext-redis` is available, and the corresponding latest version of `ext-redis`. But if it requires `php:*` and `ext-redis:3.*`, that will install PHP 7.2, since `ext-redis` v3 is not compatible with PHP 7.3 or later.

Then there are `conflict` rules (certain packages may not be installable together), `replace`s (a PHP build bundles a lot of built-in extensions that users may specify as an explicit dependency), dependencies between packages (`ext-blackfire` needs the `blackfire` program)... a ton of complexity that Composer has already implemented.

The full list of dependencies, as a graph with guaranteed integrity, is available from a project's `composer.lock`, conveniently flattened to a list of packages, so it can (relatively) easily be transformed into our own "`platform.json`" for the installation of "platform packages" (this is done by `bin/util/platform.php`).

As Composer will even order package installs in such a way that their requirements are satisfied, this means that e.g. requiring `ext-pq` in a project will also install `ext-raphf` (used by `ext-pq`), and correctly load `ext-raphf` before `ext-pq` at runtime, since it is installed first, and thus its `etc/php/conf.d/` INI file will be called e.g. `140-raphf.ini`, while `ext-pq`'s will be `150-pq.ini`.

And if a dependency can't be satisfied by our environment (e.g. an app requires an extension that isn't supported, or not available for the given runtime version, or requires a runtime version that's not available), the user gets a meaningful, familiar dependency resolution failure message generated by Composer.

## Platform `composer.json` ("`platform.json`") Generator

The `bin/util/platform.php` program reads a project's `composer.lock`, extracts all packages with platform dependencies (`php`, `ext-foobar`, etc), and translates that into "`platform.json`" where the dependencies are named `heroku-sys/php`, `heroku-sys/ext-foobar`, and so forth.

It utilizes the following environment variables:

- `$COMPOSER` and `$COMPOSER_LOCK` for the project `composer.json` and `composer.lock` file names
- `$HEROKU_PHP_DEFAULT_RUNTIME_VERSION` with the default version selection string for PHP runtimes (differs by stack)
- `$HEROKU_PHP_INSTALL_DEV` (which is an empty string when installing on Heroku CI)
- `$STACK` for the name of the current stack ("heroku-20" etc).

First, it generates a list of all repositories that should be used. Packagist gets disabled as a repository (we do not want to install public packages here), then a `path` type repository (forcing copying vs symlinking, due to different filesystems at build time and runtime) points Composer to our installer plugin (given to the program as the first argument).

Next, it lists all `composer` type repositories - that's usually the default platform repository, plus any other custom repositories given by the user, which are all passed as additional arguments to the program.

For each package listed as a dependency in the project's `composer.lock`, it then writes a metapackage of the same name and version to a list of `path` `repositories` in "`platform.json`". For each platform package dependency listed in the original package's `require` section, it rewrites that entry to have a prefix of "`heroku-sys/`"  (e.g. if a package requires "`ext-mbstring`", it writes "`heroku-sys/ext-mbstring`" into the metapackage's `require` section instead).

To this same list, it also writes a metapackage named `composer.json/composer.lock` (this makes for nice output in the case of package resolution failures) containing all of the project's direct platform package `require`s from `composer.json`. That package is added to the `require` section of "`platform.json`" along with all the userland dependency metapackages from the paragraph above, as well as a few default platform package dependencies, for example `heroku-sys/composer` (along with a require for the lock file's `composer-plugin-api` version, which will automatically ensure the correct installation of Composer 1 or Composer 2), or `heroku-sys/apache` and `heroku-sys/nginx`.

Any `minimum-stability` and `prefer-stable` settings from `composer.lock` are carried over, and special logic is applied to stability flags from a project's root platform package `require`s - as these requires are "collected" in the `composer.json/composer.lock` metapackage, an additional "dummy" entry for platform requirements with a stability flag (e.g. `"ext-redis":"^5.0@RC"`) must also be written to the root `require` section of "`platform.json`".

If no requirement for `php` was present in neither the project's `composer.json` nor any of its userland dependencies, a default require (from the `$HEROKU_PHP_DEFAULT_RUNTIME_VERSION` env var) is generated for `heroku-sys/php`.

It will also `provide` a virtual package for the stack version (for repositories that contain multiple variants of the same package name/version, targeting different stack versions), and generate `replace` entries for any programs it knows about that preceding buildpacks may have installed and e.g. extensions can depend on (right now, that's only done for `heroku-sys/blackfire`, representing the Blackfire Agent CLI installed by the Blackfire buildpack).

Example generated "`platform.json`" from a simple project's `composer.lock`:

```json
{
    "config": {
        "cache-files-ttl": 0,
        "discard-changes": true
    },
    "minimum-stability": "RC",
    "prefer-stable": true,
    "provide": {
        "heroku-sys\/heroku": "20.2021.08.05"
    },
    "replace": {},
    "require": {
        "composer.json\/composer.lock": "dev-c2b9dcae256d1b255b7265eef089f6c3",
        "symfony\/polyfill-php80": "v1.23.1",
        "symfony\/process": "v5.1.0-RC1",
        "heroku-sys\/composer": "*",
        "heroku-sys\/composer-plugin-api": "^2",
        "heroku-sys\/apache": "^2.4.10",
        "heroku-sys\/nginx": "^1.8.0"
    },
    "require-dev": {
        "composer.json\/composer.lock-require-dev": "dev-c2b9dcae256d1b255b7265eef089f6c3",
        "kahlan\/kahlan": "5.1.3"
    },
    "repositories": [
        {
            "packagist": false
        },
        {
            "type": "path",
            "url": "..\/..\/..\/..\/..\/support\/installer",
            "options": {
                "symlink": false
            }
        },
        {
            "type": "composer",
            "url": "https:\/\/lang-php.s3.amazonaws.com\/dist-heroku-20-stable\/packages.json"
        },
        {
            "type": "package",
            "package": [
                {
                    "type": "metapackage",
                    "name": "symfony\/polyfill-php80",
                    "version": "v1.23.1",
                    "require": {
                        "heroku-sys\/php": ">=7.1"
                    },
                    "replace": {},
                    "provide": {},
                    "conflict": {}
                },
                {
                    "type": "metapackage",
                    "name": "symfony\/process",
                    "version": "v5.1.0-RC1",
                    "require": {
                        "heroku-sys\/php": "^7.2.5"
                    },
                    "replace": {},
                    "provide": {},
                    "conflict": {}
                },
                {
                    "type": "metapackage",
                    "name": "composer.json\/composer.lock",
                    "version": "dev-c2b9dcae256d1b255b7265eef089f6c3",
                    "require": {
                        "heroku-sys\/ext-gmp": "*",
                        "heroku-sys\/ext-intl": "*",
                        "heroku-sys\/ext-mbstring": "*",
                        "heroku-sys\/ext-redis": "*",
                        "heroku-sys\/ext-sqlite3": "*",
                        "heroku-sys\/ext-ldap": "*",
                        "heroku-sys\/ext-imap": "*",
                        "heroku-sys\/ext-blackfire": "*"
                    },
                    "replace": {},
                    "provide": {},
                    "conflict": {}
                },
                {
                    "type": "metapackage",
                    "name": "kahlan\/kahlan",
                    "version": "5.1.3",
                    "require": {
                        "heroku-sys\/php": ">=7.1"
                    },
                    "replace": {},
                    "provide": {},
                    "conflict": {}
                },
                {
                    "type": "metapackage",
                    "name": "composer.json\/composer.lock-require-dev",
                    "version": "dev-c2b9dcae256d1b255b7265eef089f6c3",
                    "require": {
                        "heroku-sys\/ext-pcov": "*"
                    },
                    "replace": {},
                    "provide": {},
                    "conflict": {}
                }
            ]
        }
    ]
}
```

As you can see in that example, the original project's `composer.json` required a bunch of extensions, but no PHP runtime version, as well as `symfony/process`. In `require-dev`, it had `kahlan/kahlan` and `ext-pcov`, and because this was a Heroku CI install (as indicated by the `$HEROKU_PHP_INSTALL_DEV` env var), it generated metapackages for those as well.

The effective PHP runtime version that will be chosen for this install will be at least 7.2.5 (but not PHP 8), up to the maximum possible version that has all the required extensions available either bundled or as separate packages, since that's what the solver will conclude from the `symfony/process` package's requirements.

## Platform Repositories

See [`support/build/README.md`](../build/README.md) for details.

## Composer Platform Installer Plugin

The Installer Plugin is responsible for treating the `heroku-sys/` packages correctly during the platform `composer install` using "`platform.json`" (i.e. `.heroku/php/composer.json`).

These packages contain binary builds of PHP, extensions, web servers and so forth. They're all extracted to the same directory (`.heroku/php/`), and their archives contain the directory structure expected directly underneath that location - `sbin/`, `bin/`, `lib/` and so forth.

A "regular" Composer package is always installed into its own isolated directory inside `vendor/`, but in our case, we want to "merge" a package into the existing structure during installation, so that `.heroku/php/bin/` contains binaries `php`, `composer`, and so forth; `.heroku/php/sbin/` contains `nginx`, `httpd`, `php-fpm` etc; `lib/` contains shared libraries, PHP extensions, and so on. Very similar to how programs are co-located inside `/usr`, `/opt`, and so on on a regular system.

This is implemented using a custom `Composer\Installer\LibraryInstaller`, which basically only ensures the destination for a package install is always the same `.heroku/php/`, and a custom `Composer\Downloader\ArchiveDownloader`, which untars directly into the destination directory (as opposed to Composer's default behavior, which is to extract to a temporary directory that is then moved, which would overwrite anything that already exists in our case).

The real heavy lifting happens inside our `ComposerInstallerPlugin`. It hooks into Composer's `onPostPackageInstall` event and performs several tasks after the installation of each of our platform packages.

First, it finds all platform requirements from all packages that are getting installed (these are all the "meta-packages" that we generated into "`platform.json`" earlier), and remembers them in a list. This is important, because one of the requirements might be an extension that is built into PHP, and no separate install event is generated for that inside Composer (just for PHP itself, because it already satisfies that other requirement). We need to enable that extension using configuration later, however.

Second, if the package is a PHP extension, it writes a PHP INI configuration file (into PHP's INI scan dir) that enables the extension (or, if the package metadata provided its own config file for more complex cases, it copies that). It continuously increments a numeric prefix for each file, to ensure that PHP reads them in the order they were installed in during startup. This is important, because some extensions require other extensions to be already loaded (e.g. `ext-pq` relies on `ext-raphf`).

Third, it looks at which other platform packages the package currently being installed as declared in its `replace` section, and, if any of these `replace`d packages are in the list from the first step, it enables them by writing out an INI file (if it's a "shared" extension that's not statically compiled in) using the same logic as the second step. This mainly applies to the PHP platform package, as it bundles a lot of PHP's built-in extensions. If, for example, the project needs `ext-bcmath`, it gets enabled in this step.

Fourth, if the package declares a `.profile.d/` script, it writes that - again using a continuously incremented numeric prefix, so that the shell sources them in the right order during dyno startup. These scripts are used by many packages to modify the environment - usually to add their binary location to `$PATH`. Other programs may use them to launch a program (e.g. the `ext-newrelic` background proxy daemon), or perform other more complex operations (the PHP package, for example, determines a memory limit suitable for the current dyno type and writes it to `php-cli.ini`; the Composer package puts its `vendor/bin` directory onto `$PATH`).

Fifth, the same is done for the `export` script, which gets sourced by the build system before executing the next buildpack if an app is using multiple buildpacks. This allows another buildpack to e.g. invoke `php`. The tasks performed there are often similar to the ones for `profile.d/` scripts, but account for differences in file system locations, or are skipped altogether (e.g. APM background daemons likely don't even need starting).

To reduce complexity, this `export` script is also immediately `source`d by the PHP buildpack's own `bin/compile`, so that it can actually invoke `php` with all the right extensions enabled, `composer`, and so forth.

Once all of this is done, and has been repeated for each package to be installed, the result is a fully functional environment inside `.heroku/php`, with everything needed on `$PATH` at runtime, all the PHP extensions the user's app requires installed and enabled, and so forth.

The temporary PHP and Composer binaries used for bootstrapping are then removed, and `bin/compile` can now finally run `composer install` to install the app's dependencies - likely successfully, as we're running exactly the PHP version the app needs, with all the required extensions loaded.