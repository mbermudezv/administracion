<?php
/**
* Mauricio Bermudez Vargas 01/06/2019 6:39 p.m.
*/
require_once 'conexion.php';

class updateParametros
{
	private $pdo;
	
	function __construct()
	{
        $pdo = new \PDO(DB_Str, DB_USER, DB_PASS);	
		$this->pdo = $pdo;
	}

    public function updateParametros($parametros_Id, $institucion_Nombre, $director_Institucional, 
                                    $coordinador_Comite, $comite_Nutricion){ 
                        
        $sql = 'UPDATE parametros SET institucion_Nombre = :institucion_Nombre, 
        director_Institucional = :director_Institucional, coordinador_Comite = :coordinador_Comite, 
        comite_Nutricion = :comite_Nutricion
        WHERE parametros_Id = :parametros_Id';
					
		try {
		
		$stmt = $this->pdo->prepare($sql);
				
		$stmt->execute([
        ':parametros_Id' => $parametros_Id,    		           
        ':institucion_Nombre' => $institucion_Nombre,
        ':director_Institucional' => $director_Institucional,        
        ':coordinador_Comite' => $coordinador_Comite,
        ':comite_Nutricion' => $comite_Nutricion
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