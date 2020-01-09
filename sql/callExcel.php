<?php
/**
* Mauricio Bermudez Vargas 28/12/2019 11:17 p.m.
*/
require_once 'conexion.php';

class callExcel
{
	private $pdo;
	
	function __construct()
	{
        $pdo = new \PDO(DB_Str, DB_USER, DB_PASS);		
		$this->pdo = $pdo;
	}
    
    public function callExcel(){
        		
    $sql = 'CALL estudianteExcel();';
									
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