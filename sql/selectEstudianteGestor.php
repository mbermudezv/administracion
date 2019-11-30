<?php

require_once("../sql/select.php");		

try {

	$cedula=$_GET['cedula'];

	$db = new Select();		
	$rs = $db->conEstudianteNombre($cedula);			
	
	if(!empty($rs)) {
		foreach($rs as $rsEstudiante) {
			echo json_encode(array("Id" => $rsEstudiante["Estudiante_Id"], 
								   "Nombre" => $rsEstudiante["Estudiante_Nombre"],
	    						   "Apellido1" => $rsEstudiante["Estudiante_Apellido1"],
								   "Apellido2" => $rsEstudiante["Estudiante_Apellido2"]));
		}
		$rs = null;
		$db = null;
	}

} 
catch (PDOException $e) {		
	$rs = null;
	$db = null;
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	exit;
}
?>
