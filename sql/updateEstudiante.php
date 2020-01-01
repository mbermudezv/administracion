<?php
/**
* Mauricio Bermudez Vargas 01/06/2019 6:39 p.m.
*/
require_once 'conexion.php';

class updateEstudiante
{
	private $pdo;
	
	function __construct()
	{
        $pdo = new \PDO(DB_Str, DB_USER, DB_PASS);	
		$this->pdo = $pdo;
	}

    public function updateEstudiante($estudiante_Id, $estudiante_Cedula, $estudiante_Nombre, $estudiante_PrimerApellido, 
                                    $estudiante_SegundoApellido, $estudiante_Seccion){ 
                        
        $sql = 'UPDATE Estudiante SET Estudiante_Cedula = :estudiante_Cedula, 
        Estudiante_Nombre = :estudiante_Nombre, Estudiante_Apellido1 = :estudiante_PrimerApellido, 
        Estudiante_Apellido2 = :estudiante_SegundoApellido, 
        Estudiante_Seccion =:estudiante_Seccion
        WHERE Estudiante_Id = :estudiante_Id';
					
		try {
		
		$stmt = $this->pdo->prepare($sql);
				
		$stmt->execute([
        ':estudiante_Id' => $estudiante_Id,    		           
        ':estudiante_Cedula' => $estudiante_Cedula,
        ':estudiante_Nombre' => $estudiante_Nombre,
        ':estudiante_PrimerApellido' => $estudiante_PrimerApellido,
        ':estudiante_SegundoApellido' => $estudiante_SegundoApellido,
        ':estudiante_Seccion' => $estudiante_Seccion
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