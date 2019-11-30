<?php
/**
* Mauricio Bermudez Vargas 13/02/2018 9:30 p.m.
*/

require_once 'insertCuenta.php';
	
try {

	$cliente=$_POST['cliente'];
	$monto=$_POST['monto'];

 	$db = new Insert();
 	$db-> insertCuenta($cliente, $monto);
 	$db = null;

} 
catch (Exception $e) {		
	console.log("Error de la aplicación: " + $e->getMessage());
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	$db = null;
	exit;
}

?>