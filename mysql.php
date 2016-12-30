<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define("SERVERNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "913004560");
define("DBNAME", "quizLotyv1");

function selectData($sql){
    // Create connection
    $conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $resultado[] = $row;
        }
    } else {
        $resultado = 0;
    }

    mysqli_close($conn);
    return $resultado;
}
function insertData($sql){
    // Create connection
    $conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $result = mysqli_query($conn, $sql);
    $last_id = mysqli_insert_id($conn);

    mysqli_close($conn);
    return $result;
}

function getUsers(){
    $sql = "SELECT * FROM usuarios";
    $result = selectData($sql);
    return $result;
}
function getQuestionbyQuestID($question_id){
    $sql = "SELECT * FROM preguntas where ID=".$question_id;
    $result = selectData($sql);
    return $result;
}
function getRespuestasbyQuestID($question_id){
    $sql = "SELECT * FROM respuestas where id_pregunta=".$question_id;
    $result = selectData($sql);
    return $result;
}
function getResultadosTOT(){
    $sql = "SELECT * FROM usuarios order by puntos desc";
    $result = selectData($sql);
    return $result;
}
function getRespuestaCorrectabyQuestID($question_id){
    $sql = "SELECT * FROM respuestas where correcto=1 and id_pregunta=".$question_id;
    $result = selectData($sql);
    if ($result==0){
        $result = "not_calculada";
    }
    return $result;
}
function getResultadosbyQuestID($question_id){
    $sql = "SELECT usuarios.username,respuestas.letra,respuestas.correcto "
            . "FROM usuarios_respuestas,respuestas,usuarios "
            . "WHERE usuarios_respuestas.pregunta_id=".$question_id." "
            . "AND usuarios_respuestas.respuesta_id=respuestas.ID "
            . "AND usuarios_respuestas.user_id=usuarios.ID;";
    $result = selectData($sql);
    return $result;
}
function createUser($fromName,$fromNumber){    
    $sql = "INSERT INTO quizLotyv1.usuarios (username, telefono, puntos) VALUES ('".$fromName."', '".$fromNumber."', 0)";
    $result = insertData($sql);
    return $result;
}
function createResultado ($user_id,$pregunta_id,$respuesta_id){
    $sql = "INSERT INTO quizLotyv1.usuarios_respuestas (user_id, pregunta_id, respuesta_id) VALUES (".$user_id.", ".$pregunta_id.", ".$respuesta_id.");";
    $result = insertData($sql);
    return $result;
}
function userExist($fromNumber){
    $resultado = FALSE;
    $sql = "SELECT * FROM usuarios where telefono='".$fromNumber."'";
    $result = selectData($sql);
    
    if ($result!=0){
        $resultado = TRUE;
    }
    
    return $resultado;
}
function resultadoExist($user_id,$pregunta_id){
    $resultado = FALSE;
    $sql = "SELECT * FROM usuarios_respuestas where user_id=".$user_id." and pregunta_id=".$pregunta_id;
    $result = selectData($sql);
    
    if ($result!=0){
        $resultado = TRUE;
    }
    
    return $resultado;
    
}
function getuserBYphone($fromNumber){
    $sql = "SELECT * FROM usuarios where telefono='".$fromNumber."'";
    $result = selectData($sql);
    return $result;
}
function getRespuestaBYLetra($question_id,$letra){
    $sql = "SELECT * FROM respuestas where id_pregunta=".$question_id." and letra='".$letra."'";
    $result = selectData($sql);
    return $result;
}
function checkResponseProvided ($user_id,$question_id){
    $resultado = FALSE;
    $sql = "SELECT * FROM usuarios_respuestas where user_id=".$user_id." and pregunta_id=".$question_id;
    $result = selectData($sql);
    if ($result!=0){
        $respuesta_id = $result[0]["respuesta_id"];
        $sql = "SELECT * FROM respuestas where ID=".$respuesta_id;
        $result = selectData($sql);
        if ($result!=0){
            if ($result[0]["correcto"]){
                $resultado = TRUE;
            }
        }
    }
    return $resultado;
}
function insertPoint ($user_id){
    
    $sql = "UPDATE usuarios SET puntos = puntos + 1 WHERE ID=".$user_id;
    $result = insertData($sql);
    return $result;
}
function getResponsesBYQuestion($question_id){
    $sql = "SELECT * FROM usuarios_respuestas where pregunta_id='".$question_id."'";
    $result = selectData($sql);
    return $result;
}
function checkifCorrectoSet ($question_id){    
    $resultado = FALSE;
    $sql = "SELECT * FROM respuestas where id_pregunta=".$question_id;
    $result = selectData($sql);
    foreach ($result as $value) {
        if ($value['correcto']){
            $resultado = TRUE;
            break;
        }
    }
    
    return $resultado;
}
function setCorrectBymayoria($question_id){
    $sql = "SELECT respuesta_id FROM usuarios_respuestas "
            . "WHERE pregunta_id=".$question_id." GROUP by respuesta_id ORDER by count(respuesta_id) DESC limit 1";
    $result = selectData($sql);
    if ($result!=0){
        $respuesta_id = $result[0]["respuesta_id"];
        $sql = "UPDATE respuestas SET correcto = '1' WHERE ID =".$respuesta_id;
        $result = insertData($sql);
    }
    
    return $result;
}
?>

