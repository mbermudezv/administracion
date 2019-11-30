<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);
/**
* Mauricio Bermudez Vargas 27/03/2018 06:35 p.m.
*/
try {
require_once("sql/select.php");
$db = new Select();
$rs = $db->conCliente();
} catch (PDOException $e) {
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	exit;
}
?>
<html>
<head>
<meta charset="utf-8">
<meta name="autor" content="Mauricio Bermúdez Vargas" />
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" type="text/css" href="css/css_Principal.css">
<title>Administración</title>
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
</head> 
<body>

<div class="menu">	
	<a id="hyp_reporte1" class="cellBotonMenu" href="reporteCancelados.php"></a>
	<a id="hyp_reporte2" class="cellBotonMenu" href="reportePendientes.php"></a>	
</div>

<div class="container">
<?php
if(!empty($rs)) {
$arCliente = array();
foreach($rs as $rsCliente) {	
?>
<div id="div_boton" class="item" tabindex="1">
	<a id="hyp_nombre" class="cell" href="cuenta.php?clienteId=<?php echo $rsCliente["Cliente_id"]; ?>"><?php echo $rsCliente["Cliente_Alias"]; ?></a>
	<a id="hyp_reporte" class="cellBotonMenu" href="reporte.php?clienteId=<?php echo $rsCliente["Cliente_id"]; ?>"></a>	
</div>
<?php 
}
$rs = null;
$db = null;
}
?>
</div>
<script>
$('.cellBotonMenu').html('<img src=img/print.png>');
</script>			
</body>
</html>