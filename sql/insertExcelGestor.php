<?php
/**
* Mauricio Bermudez Vargas 4/01/2020 10:31 p.m.
*/

if (!isset($_FILES['upexcel']['tmp_name']) || !in_array($_FILES['upexcel']['type'], [
    'text/x-comma-separated-values', 
    'text/comma-separated-values', 
    'text/x-csv', 
    'text/csv', 
    'text/plain',
    'application/octet-stream', 
    'application/vnd.ms-excel', 
    'application/x-csv', 
    'application/csv', 
    'application/excel', 
    'application/vnd.msexcel', 
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
  ])) {
    die("Invalid file type");
  }	

  require '../vendor/autoload.php';
  require_once 'insertExcel.php';

  try {
    
    if (pathinfo($_FILES['upexcel']['name'], PATHINFO_EXTENSION) == 'csv') {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
      } else {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
      }

      $spreadsheet = $reader->load($_FILES['upexcel']['tmp_name']);
      $worksheet = $spreadsheet->getActiveSheet();   
      $highestRow = $worksheet->getHighestRow();

       for ($row = 7; $row <= $highestRow; ++$row) {    

            $estudiante_Cedula = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
            $estudiante_PrimerApellido = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $estudiante_SegundoApellido = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
            $estudiante_Nombre = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
            $estudiante_Seccion = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

            $db = new insertExcel();
            $db-> insertExcel($estudiante_Cedula, $estudiante_Nombre, 
            $estudiante_PrimerApellido, $estudiante_SegundoApellido, $estudiante_Seccion);

            $db = null;	
            
        }    
	
} 
catch (Exception $e) {		
	console.log("Error de la aplicación: " + $e->getMessage());
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	$db = null;
	exit;
}

?>