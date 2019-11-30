<?php

require_once("../sql/select.php");		

try {

	$intTipo=$_GET['tipoRegistro'];
	$intId=$_GET['id'];

	$db = new Select();		
	$rs = $db->marcaRegistrada($intId,$intTipo);			

	if(!empty($rs)) {
		echo "1";
	} else {
		echo "0";
	}
	$rs = null;
	$db = null;
} 
catch (PDOException $e) {		
	$rs = null;
	$db = null;
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	exit;
}
?>