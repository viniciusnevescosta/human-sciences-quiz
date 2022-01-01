<?php

if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['nome'])){
    die("Você não pode acessar essa página porque não está logado. <p><a href=\"../../index.html\">ENTRAR</a> </p>");
}

?>