<?php
/**
* Mauricio Bermudez Vargas 24/03/2018 11:38 p.m.
*/

require_once 'conexion.php';

class Delete
{
	private $pdo;
	
	function __construct()
	{
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		$this->pdo = $pdo;
	}

	public function deleteCuenta($cuentaID){
						
		$sql = 'DELETE FROM Cuenta WHERE Cuenta_id = :Cuenta_id';
		 				
		try {

		$stmt = $this->pdo->prepare($sql);
				
		$stmt->execute([':Cuenta_id' => $cuentaID]);

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