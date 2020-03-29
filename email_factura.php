<?php

error_reporting(E_ALL);

require_once("sql/select.php");

$correo = "";
$htmlContent = "";
$total = 0;

try {

if (isset($_GET['fechaDesde']) and isset($_GET['fechaHasta']) and isset($_GET['clienteId'])) {
	$getfecDesde = $_GET['fechaDesde'];
	$getfecHasta = $_GET['fechaHasta'];
	$getCliente = $_GET['clienteId'];	
	$db = new Select();
	$rs = $db->conReporteCuentaCliente($getCliente,$getfecDesde,$getfecHasta);
    $rsCliente = $db->conClienteNombre($getCliente);
    $rsEmail = $db->conClienteEmail($getCliente);
}

if(!empty($rsEmail)) {
    foreach($rsEmail as $rsItemEmail) {
        $correo = $rsItemEmail["Cliente_Email"];
    }
    $rsEmail=null;
}

if(!empty($rsCliente)) {
    foreach($rsCliente as $rsItemCliente) {
        $nombrecompleto = $rsItemCliente["Cliente_Nombre"] . ' ' . $rsItemCliente["Cliente_Apellido1"] . ' ' . $rsItemCliente["Cliente_Apellido2"];
    }
    $rsCliente=null;
}

$desde_hasta = 'Desde: ' .  $getfecDesde . ' '. 'Hasta: ' . $getfecHasta;

} catch (PDOException $e) {
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
    exit;	
}

$htmlContent = '
<html>
<body>
    <table>
        <tr>
        <td style="padding: 2vw;">
        <strong style="font-size: 2em; font-family: "Lucida Console", Monaco, monospace;">Informe estado de cuenta almuerzos</strong>
        </td>
        </tr>
        <tr>';
 $htmlContent .= ' <td>' . $nombrecompleto . ' </td>';            
 $htmlContent .= ' </tr>';
 $htmlContent .= '      
        <tr>
            <td>' . $desde_hasta .'</td>
        </tr>
        <tr>
            <td>Fecha</td>
            <td>Monto</td>
        </tr>';
       
if(!empty($rs)) {
    foreach($rs as $rsCliente) {
        
        $total = $total + $rsCliente["Monto"];
        $htmlContent .= '
        <tr>
            <td>' . $rsCliente["Fecha"] . ' </td>
            <td>' . $rsCliente["Monto"] . ' </td>
        </tr>';
      
        }
}
$rs = null;
$db = null;
$htmlContent .= '        
        <tr>
            <td>Total:</td>
            <td>'. $total . '</td>
        </tr>
        <tr>
            <td>-------------------------</td>
            <td>-------------------------</td>
        </tr>
        <tr>
            <td>' . $nombrecompleto .'</td>
            <td> Comité de nutrición </td>
        </tr>
    
    </table>
    </body>
</html>';

echo  $htmlContent;
//echo  $correo. "\r\n";

?>
