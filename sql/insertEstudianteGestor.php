<?php
/**
* Mauricio Bermudez Vargas 28/12/2019 11:19 p.m.
*/
require_once 'insertEstudiante.php';
	
try {
         
    $estudiante_Cedula = $_POST['estudiante_Cedula'];
    $estudiante_Nombre = $_POST['estudiante_Nombre'];
    $estudiante_PrimerApellido = $_POST['estudiante_PrimerApellido'];
    $estudiante_SegundoApellido = $_POST['estudiante_SegundoApellido'];
    $estudiante_Seccion = $_POST['estudiante_Seccion'];
		 
	$db = new insertEstudiante();
    $db-> insertEstudiante($estudiante_Cedula, $estudiante_Nombre, 
                      $estudiante_PrimerApellido, $estudiante_SegundoApellido, $estudiante_Seccion);
	$db = null;	
} 
catch (Exception $e) {		
	console.log("Error de la aplicación: " + $e->getMessage());
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	$db = null;
	exit;
}

?>