<?php
/**
* Mauricio Bermudez Vargas 24/03/2018 11:38 p.m.
*/

require_once 'conexion.php';

class deleteExcel
{
	private $pdo;
	
	function __construct()
	{
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		$this->pdo = $pdo;
	}

	public function deleteExcel(){
						
		$sql = 'DELETE FROM Estudiante_Excel';
		 				
		try {

		$stmt = $this->pdo->prepare($sql);
				
		$stmt->execute();

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