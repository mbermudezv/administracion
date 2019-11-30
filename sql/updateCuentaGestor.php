<?php
/**
* Mauricio Bermudez Vargas 26/03/2018 2:48 p.m.
*/

require_once 'updateCuenta.php';
	
try {

	$monto=$_POST['monto'];
	$cuenta=$_POST['cuenta'];

 	$db = new Update();
 	$db-> updateCuenta($monto, $cuenta);
 	$db = null;

} 
catch (Exception $e) {		
	console.log("Error de la aplicación: " + $e->getMessage());
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	$db = null;
	exit;
}

?>