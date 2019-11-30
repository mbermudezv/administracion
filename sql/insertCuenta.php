<?php
/**
* Mauricio Bermudez Vargas 13/02/2018 9:30 p.m.
*/

require_once 'conexion.php';

class Insert
{
	private $pdo;
	
	function __construct()
	{
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		$this->pdo = $pdo;
	}

	public function insertCuenta($cliente, $monto){
								
		date_default_timezone_set('America/Costa_Rica');
		//$fecha = date_create('now')->format('Y-m-d H:i:s');
		$fecha = date_create('now')->format('Y-m-d');	 
		$sql = 'INSERT INTO Cuenta (Cliente_Id, Monto, Fecha) VALUES (:Cliente_Id, :Monto, :Fecha)';
									
		try {
		
		$stmt = $this->pdo->prepare($sql);
		
		$stmt->execute([
        ':Cliente_Id' => $cliente,
        ':Monto' => $monto,
        ':Fecha' => $fecha
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