<?php

require_once("select.php");		

try {

    $alias=$_GET['alias'];
    	
	$db = new select();		
	$rs = $db->conEstudianteBusqueda($alias);			
	
	if(!empty($rs)) {
		$rsArray = array();
		$i = 1;
		foreach($rs as $rsCliente) {
			$rsArray[$i] = $rsCliente;
            $i++;	
		}		
		$rs = null;
		$db = null;
		echo json_encode($rsArray);
			
	}
	else{
		echo "0";
	}
} 
catch (PDOException $e) {		
	$rs = null;
	$db = null;
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	exit;
}
?>