<?php
/**
* Mauricio Bermudez Vargas 9/07/2018 4:32 p.m.
*/
require_once 'conexion.php';

class UpdateMenu
{
	private $pdo;
	
	function __construct()
	{
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
				
		$this->pdo = $pdo;
		
	}

	public function updateMenu($descripcion, $id){						
		
		$sql = 'UPDATE Menu SET Menu_Descripcion = :Menu_Descripcion WHERE Menu_Id = :Menu_Id';
					
		try {
		
		$stmt = $this->pdo->prepare($sql);
				
		$stmt->execute([
		':Menu_Descripcion' => $descripcion,            
        ':Menu_Id' => $id
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