<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
error_reporting(E_ALL);
ini_set('display_errors', false);
ini_set('html_errors', true);

require_once("sql/select.php");
try {

if (isset($_GET['fechaDesde']) and isset($_GET['fechaHasta'])) {
    
    $getfecDesde = $_GET['fechaDesde'];
	$getfecHasta = $_GET['fechaHasta'];
	$db = new Select();
	$rs = $db->conReporteCuentasPendientes($getfecDesde,$getfecHasta);
    
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
<link rel="stylesheet" type="text/css" href="css/css_Reporte.css">
<title>Exportar</title>
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
</head>
<body>
<table>
	 <tr>
        <td style="padding: 2vw;">
            <strong style="font-size: 2em; font-family: "Lucida Console", Monaco, monospace;">Informe de almuerzos por cobrar</strong>
        </td>
    </tr>
    <?php
    $desde_hasta = 'Desde: ' .  $getfecDesde . ' '. 'Hasta: ' . $getfecHasta;
    ?>
    <tr>
        <td><?php echo $desde_hasta; ?></td>
    </tr>
    <tr>
        <td>Fecha</td>
        <td>Nombre</td>
        <td>Monto</td>
    </tr>
    <?php
    if(!empty($rs)) {
        foreach($rs as $rsCliente) {
            $nombrecompleto = $rsCliente["Cliente_Nombre"] . ' ' . $rsCliente["Cliente_Apellido1"] . ' ' . $rsCliente["Cliente_Apellido2"];
            $total = $total + $rsCliente["Monto"];
            ?>
            <tr>
                <td> <?php echo $rsCliente["Fecha"]; ?> </td>
                <td> <?php echo $nombrecompleto; ?> </td>
                <td> <?php echo $rsCliente["Monto"]; ?> </td>
            </tr>
            <?php
        }
    }
    $rs = null;
    $db = null;
    ?>    
    <tr>
        <td>Total:</td>
        <td><?php echo $total; ?></td>
    </tr>
    <tr>        
        <td>-------------------------</td>
    </tr>
     <tr>        
        <td> <?php echo "Comité de nutrición"; ?></td>
    </tr>
   
</table>
<script>
$('.salir').html('<img src="img/lista.png">');
</script>
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