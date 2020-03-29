<?php

    $asunto = "Estado de cuenta Comedor"; 
    $destinatario = urldecode($_POST['email']);
    $cuerpo = urldecode($_POST['body']);
    //para el envío en formato HTML 
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

    //dirección del remitente 
    $headers .= "From: Comedor <comedor@wappcom.net>\r\n";
    
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
 
    mail($destinatario,$asunto,$cuerpo,$headers) 
   
	
?>