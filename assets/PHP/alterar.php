<?php
include("conexao.php");

if(!isset($_SESSION)) {
    session_start();

    $id = $_SESSION['id'];
    $nome = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $senha = $conn->real_escape_string(password_hash($_POST['password'], PASSWORD_DEFAULT));

    $sql = "UPDATE usuarios SET nome='$nome', email='$email', senha='$senha' WHERE id='$id'";
    
    if($conn->query($sql) === true) {
        header("Location: logout.php");
    } else {
        echo "Falha ao alterar: $sql. ". $conn->error;
    }
    $conn->close();
}
?>