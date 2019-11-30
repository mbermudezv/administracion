<?php

require_once("../sql/select.php");		

try {

	$intTipo=$_GET['tipoRegistro'];

	$db = new Select();		
	$rs = $db->totalRegistros($intTipo);			

	if(!empty($rs)) {
		foreach($rs as $rsTotal) {			
			echo $rsTotal["Total"];
		} 
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