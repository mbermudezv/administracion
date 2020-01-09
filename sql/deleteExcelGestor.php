<?php
/**
* Mauricio Bermudez Vargas 24/03/2018 11:35 p.m.
*/

require_once 'deleteExcel.php';
	
try {
		
 	$db = new deleteExcel();
 	$db-> deleteExcel();
 	$db = null;

} 
catch (Exception $e) {		
	console.log("Error de la aplicación: " + $e->getMessage());
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	$db = null;
	exit;
}

?>