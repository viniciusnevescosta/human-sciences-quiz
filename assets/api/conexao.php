<?php
$host = "localhost";
$user = "root";
$psw= "";
$db = "forms";

// Create connection
$conn = mysqli_connect($host, $user, $psw, $db);

// Check connection
if($conn->error) {
    die("Falha ao conectar ao banco de dados: " . $conn->error);
}
?>