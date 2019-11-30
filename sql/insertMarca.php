<?php
/**
* Mauricio Bermudez Vargas 23/06/2018 9:46 p.m.
*/

require_once 'conexion.php';

class ClassInsertMarca
{
	private $pdo;
	
	function __construct()
	{
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		$this->pdo = $pdo;
	}

	public function insertMarca($intEstudianteId, $intSeleccion){
		
		date_default_timezone_set('America/Costa_Rica');
		//$fecha = date_create('now')->format('Y-m-d H:i:s');
		$fecha = date_create('now')->format('Y-m-d');		
		
		$sql = 'INSERT INTO Marca (Estudiante_Id, Marca_Tipo, Marca_Fecha) VALUES (:Estudiante_Id, :Marca_Tipo, :Marca_Fecha)';

		try {
		
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->execute([
        ':Estudiante_Id' => $intEstudianteId,
        ':Marca_Tipo' => $intSeleccion,
        ':Marca_Fecha' => $fecha
    	]);
  			
        $stmt = null;
        $this->pdo = null;

        return 0;

        } catch (Exception $e) {
		echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
		exit;				
	}	
	}
}

?>