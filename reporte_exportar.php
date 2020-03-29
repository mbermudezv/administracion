<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
error_reporting(E_ALL);
ini_set('display_errors', false);
ini_set('html_errors', true);

require_once("sql/select.php");
try {
$correo = "";

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
        	//ob_start();
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
<div id="ContainerEmail">
    <table>
        <tr>
        <!-- <td>
            <img src="img/escudo.png" width="100" height="100" >    
         </td>-->
        <td style="padding: 2vw;">
        <strong style="font-size: 2em; font-family: "Lucida Console", Monaco, monospace;">Informe estado de cuenta almuerzos</strong>
        </td>
        </tr>
        <tr>
        <?php
        if(!empty($rsCliente)) {
        foreach($rsCliente as $rsItemCliente) {
        $nombrecompleto = $rsItemCliente["Cliente_Nombre"] . ' ' . $rsItemCliente["Cliente_Apellido1"] . ' ' . $rsItemCliente["Cliente_Apellido2"];
        }
        $rsCliente=null;
        }
        ?>
        <td><?php echo $nombrecompleto; ?></td>            
        </tr>
        <?php
        $desde_hasta = 'Desde: ' .  $getfecDesde . ' '. 'Hasta: ' . $getfecHasta;
        ?>
        <tr>
            <td><?php echo $desde_hasta; ?></td>
        </tr>
        <tr>
            <td>Fecha</td>
            <td>Monto</td>
        </tr>
        <?php
        if(!empty($rs)) {
        foreach($rs as $rsCliente) {
        $total = $total + $rsCliente["Monto"];
        ?>
        <tr>
            <td> <?php echo $rsCliente["Fecha"]; ?> </td>
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
            <td>-------------------------</td>
        </tr>
        <tr>
            <td> <?php echo $nombrecompleto; ?></td>
            <td> <?php echo "Comité de nutrición"; ?></td>
        </tr>
    
    </table>

</div> <!-- Container Email -->

<script language='javascript'>

var tipoExport = <?php echo $_GET['t']; ?>;

if (tipoExport == 3) {    
    enviar();
}

function enviar() {

        var email =  <?php echo "'". $correo ."'"; ?>;
        var contenido = document.getElementsByTagName("body");        
        var contenidojs = "<html>"+contenido[0].outerHTML+"</html>"                    
        var params = "email="+encodeURIComponent(email)+"&body="+encodeURIComponent(contenidojs);        

        var xhr=new XMLHttpRequest();
        xhr.open('POST','https://www.wappcom.net/comedor/email_comprobante.php',true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");            
        if (xhr.status == 200) {
            console.log("Enviado ..");
            } else {
                console.log("Error " + xhr.status + " al enviar email");
            }    
        xhr.send(params);
    }    
</script>
</body>
</html>