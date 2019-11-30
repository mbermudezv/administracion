<?php

// Mauricio Bermudez Vargas 12/07/2018 9:35 a.m.

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
error_reporting(E_ALL);
ini_set('display_errors', false);
ini_set('html_errors', true);

require_once("sql/select.php");
try {

if (isset($_GET['fechaDesde'])) {
	$getfecDesde = $_GET['fechaDesde'];
	$db = new Select();
	$rs = $db->conReporteAlmuerzo($getfecDesde,2); // 2: Registro Almuerzo
}

} catch (PDOException $e) {
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
    exit;	
}

if (isset($_GET['t'])) {
	$archivo = 'Reporte - '.date("d/m/Y");
    $t = $_GET['t'];    
	if ($t != 3){
        if ($t == 1){
            $tipo = 'excel';
            $extension = '.xls';
        }else if ($t == 2){
            $tipo = 'word';
            $extension = '.doc';
        }   
        header("Content-type: application/vnd.ms-$tipo");
        header("Content-Disposition: attachment; filename=$archivo$extension");
        header("Pragma: no-cache");
        header("Expires: 0");
    	}else {           
        	ob_start();
    	}    
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="autor" content="Mauricio Bermúdez Vargas" />
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" type="text/css" href="css/css_ReporteAlmuerzo.css">
<title>Exportar</title>
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
</head>
<body>
<table>
	 <tr>
    <td style="padding: 2vw;">
    <strong style="font-size: 2em; font-family: "Lucida Console", Monaco, monospace;">Informe almuerzos</strong>
    </td>
    </tr>
    <?php
    $desde_hasta = 'Fecha: ' .  $getfecDesde;
    ?>
    <tr>
        <td><?php echo $desde_hasta; ?></td>
    </tr>
    <tr>
        <td>Nombre</td>
        <td>Sección</td>
    </tr>
    <?php
    if(!empty($rs)) {
    foreach($rs as $rsItemAlmuerzo) { 
      $nombrecompleto = $rsItemAlmuerzo["Estudiante_Nombre"] . ' ' . $rsItemAlmuerzo["Estudiante_Apellido1"] . ' ' . $rsItemAlmuerzo["Estudiante_Apellido2"];
    ?>
    <tr>
        <td> <?php echo $nombrecompleto; ?> </td>
        <td> <?php echo $rsItemAlmuerzo["Estudiante_Seccion"]; ?> </td>
    </tr>
    <?php
    }
    }
    $rs = null;
    $db = null;
    ?>        
    <tr>
        <td>-------------------------</td>
        <td>-------------------------</td>
        <td>-------------------------</td>
    </tr>
     <tr>
        <td>MSc. Henry Navarro Zuñiga</td>
        <td>MSc. Raquel Vindas Quiros</td>
        <td>Anais Monge Montoya</td>
    </tr>
    <tr>
        <td>Director institucional</td>
        <td>Coordinadora Comité Nutrición</td>
        <td>Comité Nutrición</td>
    </tr>   
</table>
</body>
</html>
<?php 
if (isset($_GET['t']) and $_GET['t'] == 3){
    $salida_html = ob_get_contents();
    ob_end_clean();  

    require_once 'dompdf/dompdf_config.inc.php';
    $dompdf = new DOMPDF();
    $dompdf->load_html($salida_html);
    $dompdf->set_paper ('letter','landscape'); 
    $dompdf->render();
    $dompdf->stream($archivo.".pdf");
}
?>