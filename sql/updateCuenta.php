<?php
/**
* Mauricio Bermudez Vargas 26/03/2018 2:52 p.m.
*/
require_once 'conexion.php';

class Update
{
	private $pdo;
	
	function __construct()
	{
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		$this->pdo = $pdo;
	}

	public function updateCuenta($monto, $cuenta){
						
		
		$sql = 'UPDATE Cuenta SET Monto = :Monto WHERE Cuenta_id = :Cuenta_id';
			
		
		try {
		
		$stmt = $this->pdo->prepare($sql);
				
		$stmt->execute([
		':Cuenta_id' => $cuenta,            
        ':Monto' => $monto
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