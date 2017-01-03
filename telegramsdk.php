<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    include_once 'mysql.php';
    
    $message = $argv[1];
    $fromName = $argv[2];
    $fromNumber = $argv[3];
    
    /*$message = "QuizLotyv1 user create";
    $message = "QuizLotyv1 pregunta1 A";
    $message3 = "QuizLotyv1 pregunta10 ABCD";
    $fromName = "Lotykun";
    $fromNumber = "34629976242";*/
    
    $porciones = explode(" ", $message);
    $error = FALSE;
    $errorMsg = "";
    $okMsg = "";
    
    if (count($porciones)<2){
        $error = TRUE;
        $errorMsg = "ERROR - MENSAJE ENVIADO MAL FORMADO";
    } else {
        switch ($porciones[1]){
            case "user":
                if ($porciones[2]=="create"){
                    if (!userExist($fromNumber)){
                        $answer = createUser($fromName,$fromNumber);
                        if (!$answer){
                            $error = TRUE;
                            $errorMsg = "ERROR - USUARIO CREADO INCORRECTAMENTE";
                        } else {
                            $okMsg = "OK - USUARIO $fromName CON NUMERO $fromNumber CREADO CORRECTAMENTE";
                        }
                    } else {
                        $error = TRUE;
                        $errorMsg = "ERROR - USUARIO CON NUMERO $fromNumber YA EXISTE";
                    }
                }
            break;
            default :
                $question_id = $porciones[2];
                $user = getuserBYphone($fromNumber);
                if (!$user){
                    $error = TRUE;
                    $errorMsg = "ERROR - EL USUARIO CON NUMERO $fromNumber NO EXISTE, CREA PRIMERO EL USUARIO CON 'QuizLotyv1 user create'";
                } else {
                    $respuesta = getRespuestaBYLetra($question_id, strtoupper ($porciones[3]));
                    if (!$respuesta){
                        $error = TRUE;
                        $errorMsg = "ERROR - LA RESPUESTA PROPORCIONADA NO EXISTE PARA ESTA PREGUNTA";
                    } else {
                        if (!resultadoExist($user[0]['ID'],$question_id,$respuesta[0]['ID'])){
                            if (createResultado($user[0]['ID'], $question_id, $respuesta[0]['ID'])){
                                $okMsg = "OK - RESPUESTA ALMACENADA CORRECTAMENTE";
                            } else {
                                $error = TRUE;
                                $errorMsg = "ERROR - EN EL ALMACENAMIENTO DE LA RESPUESTA";
                            }
                        } else {
                            $error = TRUE;
                            $errorMsg = "ERROR - YA HAS RESPONDIDO PARA ESTA PREGUNTA";
                        }
                    }
                }
            break;
        }
    }
    if ($error){
        echo $errorMsg;
    } else {
        echo $okMsg;
    }
    

?>

