<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    include_once 'mysql.php';
    
    $error = FALSE;
    $errorMsg = "";
    $okMsg = "OK - PROCESO COMPLETADO";
    $question_id = $_POST["question_id"];
    if (!checkifCorrectoSet($question_id)){
        setCorrectBymayoria($question_id);
    }
    $responses = getResponsesBYQuestion($question_id);
    foreach ($responses as $value) {
        $correct = checkResponseProvided($value['user_id'], $question_id);
        if ($correct){
            $result = insertPoint($value['user_id']);
            if (!$result){
                $error = TRUE;
                $errorMsg = "ERROR - INSERCION DE PUNTOS";
            }
        }
    }
    
    if ($error){
        echo json_encode($errorMsg);
    } else {
        echo json_encode($okMsg);
    }
?>


