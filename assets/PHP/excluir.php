<?php
include("conexao.php");

if(!isset($_SESSION)) {
    session_start();

    $id = $_SESSION['id'];

    $sql = "DELETE FROM usuarios WHERE id='$id'";
    if($conn->query($sql) === true) {
        header("Location: logout.php");
    } else {
        echo "Falha ao excluir: $sql. ". $conn->error;
    }
    
    $conn->close();
}
?>