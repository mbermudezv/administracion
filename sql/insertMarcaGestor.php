<?php
/**
* Mauricio Bermudez Vargas 23/06/2018 9:27 p.m.
*/

require_once 'insertMarca.php';
	
try {

	$intId=$_POST['id'];	
	$intSeleccion=$_POST['seleccion'];

 	$db = new ClassInsertMarca(); 	
 	$db-> insertMarca($intId, $intSeleccion);
 	$db = null;

} 
catch (Exception $e) {		
	console.log("Error de la aplicación: " + $e->getMessage());
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	$db = null;
	exit;
}

?>