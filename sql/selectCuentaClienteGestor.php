<?php

require_once("select.php");		

$getCliente=$_GET['id'];
$getfecDesde=$_GET['fechaDesde'];
$getfecHasta=$_GET['fechaHasta'];


try {

    $db = new Select();
	$rs = $db->conReporteCuentaCliente($getCliente,$getfecDesde,$getfecHasta);
	
	if(!empty($rs)) {
		echo json_encode($rs);										  			
		$rs = null;
		$db = null;
	}
	

} catch (PDOException $e) {		
	$rs = null;
	$db = null;
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	exit;
}
?>
