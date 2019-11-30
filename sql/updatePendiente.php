<?php
/**
* Mauricio Bermudez Vargas 3/06/2019 2:52 p.m.
*/

require_once 'conexion.php';

class UpdatePendiente
{
	private $pdo;
	
	function __construct()
	{
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		$this->pdo = $pdo;
	}

	public function updatePendiente($pendiente, $cuenta){
						
		
		$sql = 'UPDATE Cuenta SET Pendiente = :Pendiente WHERE Cuenta_id = :Cuenta_id';
			
		
		try {
		
		$stmt = $this->pdo->prepare($sql);
				
		$stmt->execute([
		':Cuenta_id' => $cuenta,            
        ':Pendiente' => $pendiente
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