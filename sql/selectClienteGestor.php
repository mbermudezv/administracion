<?php

require_once("../sql/select.php");		

$id=$_GET['id'];

try {

	$db = new Select();		
	$rs = $db->conClienteNombre($id);			
	
	if(!empty($rs)) {
		foreach($rs as $rsCliente) {
		
			echo json_encode(array("Id" => $rsCliente["Cliente_id"], 
								   "Nombre" => $rsCliente["Cliente_Nombre"],
	    						   "Apellido1" => $rsCliente["Cliente_Apellido1"],
								   "Apellido2" => $rsCliente["Cliente_Apellido2"],
								   "Email" => $rsCliente["Cliente_Email"]));					   
		
										  
		}
			
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
