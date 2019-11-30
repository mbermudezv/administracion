<?php
/**
* Mauricio Bermudez Vargas 26/03/2018 2:48 p.m.
*/

require_once 'updateMenu.php';
	
try {

	$strDescripcion=$_POST['descripcion'];
	$intId=$_POST['id'];

 	$db = new UpdateMenu();
 	$db-> updateMenu($strDescripcion, $intId);
 	$db = null;

} 
catch (Exception $e) {		
	console.log("Error de la aplicación: " + $e->getMessage());
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	$db = null;
	exit;
}

?>