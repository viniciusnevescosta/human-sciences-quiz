<?php
include("conexao.php");
    
if(!isset($_SESSION)) {
    session_start();

    if(isset($_POST['enviar'])) {
        $resposta1 = $_POST["question1"];
        $resposta2 = $_POST["question2"];
        $resposta3 = $_POST["question3"];
        $resposta4 = $_POST["question4"];
        $resposta5 = $_POST["question5"];
        $resposta6 = $_POST["question6"];
        $resposta7 = $_POST["question7"];
        $resposta8 = $_POST["question8"];
        $resposta9 = $_POST["question9"];
        $resposta10 = $_POST["question10"];

        $data = date('d/m/Y H:i');

        $nota = 0;
        if($resposta1 == "A") {
            echo "Questão 1 correta! <br />";
            $nota++;
        } else {
            echo "Questão 1 errada, resposta certa: A. <br />";
        }

        if($resposta2 == "C") {
            echo "Questão 2 correta! <br />";
            $nota++;
        } else {
            echo "Questão 2 errada, resposta certa: C. <br />";
        }

        if($resposta3 == "D") {
            echo "Questão 3 correta! <br />";
            $nota++;
        } else {
            echo "Questão 3 errada, resposta certa: D. <br />";
        }

        if($resposta4 == "A") {
            echo "Questão 4 correta! <br />";
            $nota++;
        } else {
            echo "Questão 4 errada, resposta certa: A. <br />";
        }

        if($resposta5 == "B") {
            echo "Questão 5 correta! <br />";
            $nota++;
        } else {
            echo "Questão 5 errada, resposta certa: B. <br />";
        }

        if($resposta6 == "A") {
            echo "Questão 6 correta! <br />";
            $nota++;
        } else {
            echo "Questão 6 errada, resposta certa: A. <br />";
        }

        if($resposta7 == "C") {
            echo "Questão 7 correta! <br />";
            $nota++;
        } else {
            echo "Questão 7 errada, resposta certa: C. <br />";
        }

        if($resposta8 == "D") {
            echo "Questão 8 correta! <br />";
            $nota++;
        } else {
            echo "Questão 8 errada, resposta certa: D. <br />";
        }

        if($resposta9 == "D") {
            echo "Questão 9 correta! <br />";
            $nota++;
        } else {
            echo "Questão 9 errada, resposta certa: D. <br />";
        }

        if($resposta10 == "A") {
            echo "Questão 10 correta! <br />";
            $nota++;
        } else {
            echo "Questão 10 errada, resposta certa: A. <br />";
        }

        $_SESSION['nota'] = $nota;
        $_SESSION['data'] = $data;

        if($_SESSION['nota'] >= 0) {
            $_SESSION['status'] = "(Prova concluída!)";
        } else {
            $_SESSION['status'] = "(Realizar prova)";
        }

        echo "Nota final: ". $nota ." <p><a href=\"conta.php\">HOME</a> </p>";
    }
}
?>

