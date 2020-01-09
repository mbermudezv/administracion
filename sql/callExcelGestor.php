<?php
/**
* Mauricio Bermudez Vargas 4/01/2020 10:31 p.m.
*/

require_once 'callExcel.php';

try {
    
    $db = new callExcel();
    $db-> callExcel();
    $db = null;	

} 
catch (Exception $e) {		
	console.log("Error de la aplicación: " + $e->getMessage());
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	$db = null;
	exit;
}

?>