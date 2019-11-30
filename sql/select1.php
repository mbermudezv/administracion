<?php

require_once 'conexion.php';

class Select 
{

	function conCliente(){
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);	
		if ($pdo != null)
			$sql = $pdo->query('SELECT * FROM Cliente ORDER BY Cliente_Nombre');			
			$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
					$rs[] = [
						'Cliente_id' => $row['Cliente_id'],
						'Cliente_Nombre' => $row['Cliente_Nombre'],
						'Cliente_Apellido1' => $row['Cliente_Apellido1'],
						'Cliente_Apellido2' => $row['Cliente_Apellido2'],
						'Cliente_Alias' => $row['Cliente_Alias']
					];
			}
		return $rs;
	}

	function conClienteAlias($id){
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);	
		if ($pdo != null)		
			$sql = $pdo->query('SELECT * FROM Cliente WHERE Cliente_id ='.$id.'');
			$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = [
		            	'Cliente_id' => $row['Cliente_id'],	                
		                'Cliente_Alias' => $row['Cliente_Alias']
		            ];
		    }
		    return $rs;
	}

	function conCuentaCliente ($idCliente)
	{
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		if ($pdo != null)		
			$sql = $pdo->query('SELECT * FROM Cuenta WHERE 
								Cliente_id ='.$idCliente.' 
								AND Pendiente = 1 ORDER BY Fecha DESC');
			$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = [
		            	'Cuenta_id' => $row['Cuenta_id'],	                
		                'Monto' => $row['Monto'],
		                'Fecha' => $row['Fecha']
		            ];
		    }
		    return $rs;		
	}

	function conClienteNombre ($idCliente)
	{
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		if ($pdo != null)		
			$sql = $pdo->query('SELECT * FROM Cliente WHERE Cliente_id ='.$idCliente.'');
			$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = [		            	
	                	'Cliente_Nombre' => $row['Cliente_Nombre'],
	                	'Cliente_Apellido1' => $row['Cliente_Apellido1'],
	                	'Cliente_Apellido2' => $row['Cliente_Apellido2']
		            ];
		    }
		    return $rs;		
	}

function conMontoCuenta ($idCuenta)
	{
		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		if ($pdo != null)		
			$sql = $pdo->query('SELECT * FROM Cuenta WHERE Cuenta_id ='.$idCuenta.'');
			$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = [
		            	'Cuenta_id' => $row['Cuenta_id'],		            		               
		                'Monto' => $row['Monto']		                
		            ];
		    }
		    return $rs;		
	}

	function conReporteCuentasPendientes ($desde,$hasta){
		
		date_default_timezone_set('America/Costa_Rica');
	 	$fechaDesde = date_create($desde)->format('Y-m-d');
		$fechaHasta = date_create($hasta)->format('Y-m-d');
		
  		try {

  		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);									
		if ($pdo != null)
			$consultaSQL = "SELECT Fecha, Cliente.Cliente_Nombre, Cliente.Cliente_Apellido1, 
						Cliente.Cliente_Apellido2, Monto FROM Cuenta inner join Cliente
						ON Cuenta.Cliente_id = Cliente.Cliente_id
						WHERE (Pendiente = 1) AND 
						Fecha BETWEEN '".$fechaDesde."' AND '".$fechaHasta."' ORDER BY Fecha asc;";
						
			$sql = $pdo->query($consultaSQL);
			$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = [
						'Cliente_Nombre' => $row['Cliente_Nombre'],
						'Cliente_Apellido1' => $row['Cliente_Apellido1'],
						'Cliente_Apellido2' => $row['Cliente_Apellido2'],
		            	'Fecha' => $row['Fecha'],		            		               
		                'Monto' => $row['Monto']		                
		            ];
		    }
		    return $rs;	
		
  			
  		} catch (Exception $e) {
			echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
			exit;	  			
  		}

	}

	function conReporteCuentasCanceladas ($desde,$hasta){
		
		date_default_timezone_set('America/Costa_Rica');
	 	$fechaDesde = date_create($desde)->format('Y-m-d');
		$fechaHasta = date_create($hasta)->format('Y-m-d');
		
  		try {

  		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);									
		if ($pdo != null)
			$consultaSQL = "SELECT Fecha, Cliente.Cliente_Nombre, Cliente.Cliente_Apellido1, 
						Cliente.Cliente_Apellido2, Monto FROM Cuenta inner join Cliente
						ON Cuenta.Cliente_id = Cliente.Cliente_id
						WHERE (Pendiente = 0) AND 
						Fecha BETWEEN '".$fechaDesde."' AND '".$fechaHasta."' ORDER BY Fecha asc;";
						
			$sql = $pdo->query($consultaSQL);
			$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = [
						'Cliente_Nombre' => $row['Cliente_Nombre'],
						'Cliente_Apellido1' => $row['Cliente_Apellido1'],
						'Cliente_Apellido2' => $row['Cliente_Apellido2'],
		            	'Fecha' => $row['Fecha'],		            		               
		                'Monto' => $row['Monto']		                
		            ];
		    }
		    return $rs;	
		
  			
  		} catch (Exception $e) {
			echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
			exit;	  			
  		}

	}


	function conReporteCuentaCliente ($idCliente,$desde,$hasta)
	{
		
		date_default_timezone_set('America/Costa_Rica');
	 	$fechaDesde = date_create($desde)->format('Y-m-d');
		$fechaHasta = date_create($hasta)->format('Y-m-d');
		
  		try {

  		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);									
		if ($pdo != null)	
			$consultaSQL = "SELECT Fecha, Monto FROM Cuenta WHERE 
							Pendiente = 1 AND
							Cliente_id = ".$idCliente." AND 
							Fecha BETWEEN '".$fechaDesde."' AND 
							'".$fechaHasta."' ORDER BY Fecha DESC";	
			$sql = $pdo->query($consultaSQL);
			$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = [
		            	'Fecha' => $row['Fecha'],		            		               
		                'Monto' => $row['Monto']		                
		            ];
		    }
		    return $rs;	
		
  			
  		} catch (Exception $e) {
			echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
			exit;	  			
  		}

	}

	function conEstudianteNombre ($strCedula)
	{

		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		try {
		if ($pdo != null)
			$consultaSQL = "SELECT * FROM Estudiante WHERE Estudiante_Cedula = '".$strCedula."'";			
			$sql = $pdo->query($consultaSQL);
		 	$rs = [];		 	
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = [		            	
	                	'Estudiante_Nombre' => $row['Estudiante_Nombre'],
	                	'Estudiante_Apellido1' => $row['Estudiante_Apellido1'],
	                	'Estudiante_Apellido2' => $row['Estudiante_Apellido2'],
	                	'Estudiante_Id' => $row['Estudiante_Id']
		            ];
		    }		    
		    return $rs;			
		} catch (Exception $e) {
		echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
		exit;	  						
		}
	}

	function totalRegistros($intTipo){

		date_default_timezone_set('America/Costa_Rica');
		$fecha = date_create('now')->format('Y-m-d');	

		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		try {
		if ($pdo != null)
			$consultaSQL = "SELECT count(*) AS Total FROM Marca WHERE Marca_Tipo = ".$intTipo." AND Marca_Fecha = '".$fecha."'";
			$sql = $pdo->query($consultaSQL);
		 	$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = ['Total' => $row['Total']];
		    }   
		    return $rs;			
		} catch (Exception $e) {
		echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
		exit;	  						
		}	
	}

	function marcaRegistrada($intId, $intTipo){

		date_default_timezone_set('America/Costa_Rica');
		$fecha = date_create('now')->format('Y-m-d');	

		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		try {
		if ($pdo != null)
			$consultaSQL = "SELECT Marca_Id FROM Marca WHERE Marca_Tipo = ".$intTipo." AND Estudiante_Id = ".$intId." AND Marca_Fecha = '".$fecha."'";
			$sql = $pdo->query($consultaSQL);
		 	$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = ['Marca_Id' => $row['Marca_Id']];
		    }   
		    return $rs;			
		} catch (Exception $e) {
		echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
		exit;	  						
		}	
	}

	function conMenuDescripcion($intId){

		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);
		try {
		if ($pdo != null)
			$consultaSQL = "SELECT * FROM Menu WHERE Menu_Id = ".$intId."";
			$sql = $pdo->query($consultaSQL);
		 	$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = [
		            	'Menu_id' => $row['Menu_Id'],
		            	'Menu_Descripcion' => $row['Menu_Descripcion']
		            ];
		    }   
		    return $rs;			
		} catch (Exception $e) {
		echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
		exit;	  						
		}
			
	}

function conReporteAlmuerzo ($fecha, $intTipo) {
		
		date_default_timezone_set('America/Costa_Rica');
	 	$fechaDesde = date_create($fecha)->format('Y-m-d');
		
  		try {

  		$pdo = new \PDO(DB_Str, DB_USER, DB_PASS);									
		if ($pdo != null)						
			$consultaSQL = "SELECT Estudiante_Nombre, Estudiante_Apellido1, Estudiante_Apellido2, Estudiante_Seccion 
							FROM Estudiante INNER JOIN Marca
							ON Estudiante.Estudiante_Id = Marca.Estudiante_Id 
							WHERE Marca_Tipo = ".$intTipo." AND Marca.Marca_Fecha = '".$fechaDesde."' ORDER BY Estudiante_Seccion, Estudiante_Apellido1,
								Estudiante_Apellido2,Estudiante_Nombre";
			$sql = $pdo->query($consultaSQL);
			$rs = [];
			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) {
		            $rs[] = [
		            	'Estudiante_Nombre' => $row['Estudiante_Nombre'],		            		               
		                'Estudiante_Apellido1' => $row['Estudiante_Apellido1'],
						'Estudiante_Apellido2' => $row['Estudiante_Apellido2'],
						'Estudiante_Seccion' => $row['Estudiante_Seccion']		                	                
		            ];
		    }
		    return $rs;	
		  			
  		} catch (Exception $e) {
			echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
			exit;	  			
  		}

	}

}
