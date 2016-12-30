<?php
    include_once 'mysql.php';

    $result =  getUsers();
    if (!isset($_GET["question"])){
        exit("NO PARAMETER QUESTION IN THE URL");
    }else{
        if (!isset($_GET["true"])){
            $showTrue = FALSE;
        } else {
            $showTrue = TRUE;
        }
        $question_id = $_GET["question"];
        $nextPage = intval($question_id)+1;
        $previosPage = intval($question_id)-1;
        $question = getQuestionbyQuestID($question_id);
        $respuestas = getRespuestasbyQuestID($question_id);
        $correctRespuesta = getRespuestaCorrectabyQuestID($question_id);
        $resultadosTOTALES = getResultadosTOT();
        $resultadosQUESTION = getResultadosbyQuestID($question_id);
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>quizLotyv1</title>
<link rel="stylesheet" type="text/css" href="assets/css/main.css" title="main" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/main.js"></script>
</head>
<body>
    <header>
        <h1><?php echo strtoupper($question[0]["nombre"]) ?></h1>
    </header>
    <div id="navigation">
        <?php if($previosPage>0): ?>
            <div id="leftArrow">
                <a href="?question=<?php echo $previosPage?>"><</a>
            </div>
        <?php endif; ?>
        <?php if($nextPage<16): ?>
            <div id="rightArrow">
                <a href="?question=<?php echo $nextPage?>">></a>
            </div>
        <?php endif; ?>
    </div>
    <section>
        <?php
            if($showTrue){
                $style ='style="display: block"';
            } else {
                $style = "";
            }
        ?>
        <article class="question" <?php echo $style ?>>
            <p><?php echo $question[0]["pregunta"] ?></p>
        </article>
        <?php $i=1;foreach($respuestas as $key=>$value):?>
            <?php 
                if($showTrue){
                    if($value["correcto"]){
                        $class = "responseTRUE";
                        
                    } else {
                        $class = "response";
                    }
                    $style ='style="display: block"';
                } else {
                    $class = "response";
                    $style = "";
                }
            ?>
        <article id="response<?php echo $i ?>" class="<?php echo $class ?>" <?php echo $style ?>>
                <p><?php echo $value["letra"] ?>: <?php echo $value["respuesta"] ?></p>
            </article>
        <?php $i++;endforeach; ?>
        
    </section>
    <aside>
        <?php
        if(!$showTrue){
            $style ='style="display: none"';
        }
        ?>
        <div id="questresult" <?php echo $style?>>
            <h1>Resultados de <?php echo strtoupper($question[0]["nombre"]) ?></h1>
            <button type="button">Click Me!</button>
        </div>
        <div id="totresult">
            <h1>Resultados TOTALES</h1>
            <button type="button">Click Me!</button>
        </div>
        <div id="action">
            <button type="button">Action</button>
        </div>
    </aside>
    <div id="totalresults" class="popUP">
        <div>
            <button class="closePOPUP" type="button">Close Window!</button>
        </div>
        <header>
            <h1>RESULTADOS TOTALES</h1>
            <h1>Despues de <?php echo $question[0]["ID"] ?> preguntas</h1>
        </header>
        <section>
            <article class="firstROW">
                <div>
                    <p>PUESTO</p>
                </div>
                <div>
                    <p>USUARIO</p>
                </div>
                <div>
                    <p>PUNTOS</p>
                </div>
            </article>
            <?php $i=1;foreach($resultadosTOTALES as $key=>$value):?>
                <article class="ROW">
                    <div>
                        <p><?php echo $i ?>º</p>
                    </div>
                    <div>
                        <p><?php echo $value["username"] ?></p>
                    </div>
                    <div>
                        <p><?php echo $value["puntos"] ?></p>
                    </div>
                </article>
            <?php $i++;endforeach; ?>
        </section>
    </div>
    <div id="questionresults" class="popUP">
        <div>
            <button class="closePOPUP" type="button">Close Window!</button>
        </div>
        <header>
            <h1>RESULTADOS <?php echo strtoupper($question[0]["nombre"]) ?></h1>
            <?php if($correctRespuesta != "not_calculada") : ?>
                <h1>Respuesta Correcta: <?php echo $correctRespuesta[0]["letra"]?></h1>
            <?php endif; ?>
        </header>
        <section>
            <article class="firstROW">
                <div>
                    <p>USUARIO</p>
                </div>
                <div>
                    <p>RESPUESTA</p>
                </div>
            </article>
            <?php foreach($resultadosQUESTION as $key=>$value):?>
                <?php 
                if($value["correcto"]){
                    $class = "correct";
                } else {
                    $class = "false";
                }
                ?>
                <article class="<?php echo $class ?>">
                    <div>
                        <p><?php echo $value["username"] ?></p>
                    </div>
                    <div>
                        <p><?php echo $value["letra"] ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </div>
</body>
</html>