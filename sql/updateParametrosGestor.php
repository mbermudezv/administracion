<?php
/**
* Mauricio Bermudez Vargas 01/06/2019 6:35 p.m.
*/

require_once 'updateParametros.php';
	
try {

    $parametros_Id = $_POST['parametros_Id'];   
    $institucion_Nombre = $_POST['institucion_Nombre'];
	$director_Institucional = $_POST['director_Institucional'];
    $coordinador_Comite = $_POST['coordinador_Comite'];
    $comite_Nutricion = $_POST['comite_Nutricion'];      
    
 	$db = new updateParametros();
    $db-> updateParametros($parametros_Id, $institucion_Nombre, $director_Institucional, 
                            $coordinador_Comite, $comite_Nutricion);
    $db = null;   

} 
catch (Exception $e) {		
	console.log("Error de la aplicación: " + $e->getMessage());
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	$db = null;
	exit;
}

?>