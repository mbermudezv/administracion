<?php
/**
* Mauricio Bermudez Vargas 03/06/2019 2:28 p.m.
*/

require_once 'updatePendiente.php';
	
try {

	$pendiente=$_POST['pendiente'];
	$cuenta=$_POST['cuenta'];

 	$db = new UpdatePendiente();
 	$db-> updatePendiente($pendiente, $cuenta);
 	$db = null;

} 
catch (Exception $e) {		
	console.log("Error de la aplicación: " + $e->getMessage());
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	$db = null;
	exit;
}

?>