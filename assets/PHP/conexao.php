<?php
$host = "us-cdbr-east-05.cleardb.net";
$user = "bf4c372c116293";
$psw= "5f723eef";
$db = "heroku_881b99d9942f4db";

// Create connection
$conn = mysqli_connect($host, $user, $psw, $db);

// Check connection
if($conn->error) {
    die("Houve uma falha ao conectar ao banco de dados: " . $conn->error);
}
?>