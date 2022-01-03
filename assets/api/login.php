<?php
include("conexao.php");

if(isset($_POST['email']) || isset($_POST['password'])) {

    if(strlen($_POST['email']) == 0) {
        echo "Preencha seu email.";
    } else if(strlen($_POST['password']) == 0) {
        echo "Preencha sua senha.";
    } else {

        $email = $conn->real_escape_string($_POST['email']);
        $senha = $conn->real_escape_string($_POST['password']);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $sql_query = $conn->query($sql_code) or die("Falha na execução do código SQL:" . $conn->error);
        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {

            $usuario = $sql_query->fetch_assoc();

            if(password_verify($senha, $usuario['senha'])) {

                if(!isset($_SESSION)) {
                    session_start();

                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['nome'] = $usuario['nome'];
                    $_SESSION['email'] = $usuario['email'];
                    $_SESSION['senha'] = $senha;

                    if (empty($_SESSION['senha'])) {
                        echo "Falha ao guardar senha. Tente novamente!";
                    } else {
                        header("Location: prova.php");
                        die();
                    }
                }
                
            } else {
                echo "Falha ao logar: Senha incorreta!";
            }
                
        } else {
            echo "Falha ao logar: E-mail ou senha incorretos.";
        }
    }
}