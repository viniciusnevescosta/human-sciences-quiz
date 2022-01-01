<?php
    include('protect.php');
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#a29bfe"/>
    <meta name="description" 
    content="Prova online de ciências humanas.">

    <!-- -------- FAVICON -------- -->
    <link rel="shortcut icon" href="../IMGS/favicon.ico" type="image/x-icon">

    <!-- -------- CSS -------- -->
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css" media="screen" />
        
    <title>Prova online</title>
</head>

<body>
    <div class="container-prova">

        <!-- -------- HEADER -------- -->
        <header>
            <div class="navbar">
                <nav>
                    <ul>
                        <li><a href="logout.php">Sair</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- -------- MAIN -------- -->
        <main class="main-prova">
            <form class="painel-prova" method="POST" action="respostas.php">
                <div class="questoes-prova">
                    <p>1. Que ano começou a revolução francesa?</p>
                        <input class="radio__input" type="radio" value="A" name="question1" id="1">
                        <label class="radio__label" for="1">A) 05/05/1789.</label>

                        <input class="radio__input" type="radio" value="B" name="question1" id="2">
                        <label class="radio__label" for="2">B) 02/04/1800.</label>

                        <input class="radio__input" type="radio" value="C" name="question1" id="3">
                        <label class="radio__label" for="3">C) 13/01/1790.</label>

                        <input class="radio__input" type="radio" value="D" name="question1" id="4">
                        <label class="radio__label" for="4">D) 04/02/1800. </label>
                </div>

                <div class="questoes-prova">
                    <p>2. Que ano terminou a revolução francesa?</p>
                        <input class="radio__input" type="radio" value="A" name="question2" id="5">
                        <label class="radio__label" for="5">A) 08/05/1815.</label>

                        <input class="radio__input" type="radio" value="B" name="question2" id="6">
                        <label class="radio__label" for="6">B) 02/04/1820.</label>

                        <input class="radio__input" type="radio" value="C" name="question2" id="7">
                        <label class="radio__label" for="7">C) 09/11/1799.</label>

                        <input class="radio__input" type="radio" value="D" name="question2" id="7">
                        <label class="radio__label" for="7">D) 04/02/1800. </label>
                </div>

                <div class="questoes-prova">
                    <p>3. Quanto países existem na américa do sul?</p>
                        <input class="radio__input" type="radio" value="A" name="question3" id="8">
                        <label class="radio__label" for="8">A) 11.</label>

                        <input class="radio__input" type="radio" value="B" name="question3" id="9">
                        <label class="radio__label" for="9">B) 9.</label>

                        <input class="radio__input" type="radio" value="C" name="question3" id="10">
                        <label class="radio__label" for="10">C) 6.</label>

                        <input class="radio__input" type="radio" value="D" name="question3" id="11">
                        <label class="radio__label" for="11">D) 13.</label>
                </div>

                <div class="questoes-prova">
                    <p>4. A américa do sul fica no:</p>
                        <input class="radio__input" type="radio" value="A" name="question4" id="12">
                        <label class="radio__label" for="12">A) Hemisfério sul ocidental.</label>

                        <input class="radio__input" type="radio" value="B" name="question4" id="13">
                        <label class="radio__label" for="13">B) Hemisfério norte oriental.</label>

                        <input class="radio__input" type="radio" value="C" name="question4" id="14">
                        <label class="radio__label" for="14">C) Hemisfério sul oriental.</label>

                        <input class="radio__input" type="radio" value="D" name="question4" id="15">
                        <label class="radio__label" for="15">D) Hemisfério norte orientel.</label>
                </div>

                <div class="questoes-prova">
                    <p>5. O que a Sociologia estuda?</p>
                        <input class="radio__input" type="radio" value="A" name="question5" id="16">
                        <label class="radio__label" for="16">A) Como se socializar.</label>

                        <input class="radio__input" type="radio" value="B" name="question5" id="17">
                        <label class="radio__label" for="17">B) Relações sociais.</label>

                        <input class="radio__input" type="radio" value="C" name="question5" id="18">
                        <label class="radio__label" for="18">C) A usar roupas sociais.</label>

                        <input class="radio__input" type="radio" value="D" name="question5" id="19">
                        <label class="radio__label" for="19">D) A comer Clube Social.</label>
                </div>

                <div class="questoes-prova">
                    <p>6. A sociedade é:</p>
                        <input class="radio__input" type="radio" value="A" name="question6" id="20">
                        <label class="radio__label" for="20">A) Um grupo de indivíduos.</label>

                        <input class="radio__input" type="radio" value="B" name="question6" id="21">
                        <label class="radio__label" for="21">B) Um grupo de leitura.</label>

                        <input class="radio__input" type="radio" value="C" name="question6" id="22">
                        <label class="radio__label" for="22">C) Um aglomerado de rochas.</label>

                        <input class="radio__input" type="radio" value="D" name="question6" id="23">
                        <label class="radio__label" for="23">D) Um aglomerado de estrelas.</label>
                </div>

                <div class="questoes-prova">
                    <p>7. Como é feita a filosofia?</p>
                        <input class="radio__input" type="radio" value="A" name="question7" id="24">
                        <label class="radio__label" for="24">A) Jogando bola.</label>

                        <input class="radio__input" type="radio" value="B" name="question7" id="25">
                        <label class="radio__label" for="25">B) Tomando sorvete.</label>

                        <input class="radio__input" type="radio" value="C" name="question7" id="26">
                        <label class="radio__label" for="26">C) Pensamentos organizados.</label>

                        <input class="radio__input" type="radio" value="D" name="question7" id="27">
                        <label class="radio__label" for="27">D) Jogando bola.</label>
                </div>

                <div class="questoes-prova">
                    <p>8. Para que serve a filosofia?</p>
                        <input class="radio__input" type="radio" value="A" name="question8" id="28">
                        <label class="radio__label" for="28">A) Entender o filme Matrix.</label>

                        <input class="radio__input" type="radio" value="B" name="question8" id="29">
                        <label class="radio__label" for="29">B) Usar em frases de auto-ajuda.</label>

                        <input class="radio__input" type="radio" value="C" name="question8" id="30">
                        <label class="radio__label" for="30">C) Para ditar regras.</label>

                        <input class="radio__input" type="radio" value="D" name="question8" id="31">
                        <label class="radio__label" for="31">D) Estudar a existência humana.</label>
                </div>

                <div class="questoes-prova">
                    <p>9. O que estuda a linguística?</p>
                        <input class="radio__input" type="radio" value="A" name="question9" id="32">
                        <label class="radio__label" for="32">A) A língua (músculo).</label>

                        <input class="radio__input" type="radio" value="B" name="question9" id="33">
                        <label class="radio__label" for="33">B) O alfabeto.</label>

                        <input class="radio__input" type="radio" value="C" name="question9" id="34">
                        <label class="radio__label" for="34">C) Como falar.</label>

                        <input class="radio__input" type="radio" value="D" name="question9" id="35">
                        <label class="radio__label" for="35">D) A linguagem verbal humana.</label>
                </div>

                <div class="questoes-prova">
                    <p>10. Exemplo de variação linguística:</p>
                        <input class="radio__input" type="radio" value="A" name="question10" id="36">
                        <label class="radio__label" for="36">A) Sotaques.</label>

                        <input class="radio__input" type="radio" value="B" name="question10" id="37">
                        <label class="radio__label" for="37">B) Atividades.</label>

                        <input class="radio__input" type="radio" value="C" name="question10" id="38">
                        <label class="radio__label" for="38">C) Religiões.</label>

                        <input class="radio__input" type="radio" value="D" name="question10" id="39">
                        <label class="radio__label" for="39">D) História da região.</label>
                </div>

                <div class="enviar-prova">
                    <input class="abrir" name="enviar" type="submit" value="Enviar">
                </div>

            </form>

        </main>

        <!-- -------- FOOTER -------- -->
        <footer class="footer-prova">
            <nav>
                <ul>
                    <li><a href="https://github.com/Jolonte" target="_blank">©Vinícius Neves Costa</a></li>
                </ul>
            </nav>
        </footer>
    </div>

</body>
</html>