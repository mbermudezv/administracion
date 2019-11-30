<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);
ini_set('display_errors', 1);
/**
* Mauricio Bermudez Vargas 24/02/2018 10:07 p.m.
*/
try 
{

require_once("sql/select.php");

$getCliente = $_GET['clienteId'];
$db = new Select();
$rs = $db->conClienteAlias($getCliente);
$rsCuenta = $db->conCuentaCliente($getCliente);

} catch (PDOException $e) {		
	$rs = null;
	$db = null;
	$rsCuenta = null;
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/> 
	<meta name="autor" content="Mauricio Bermúdez Vargas" />
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="css/css_ModificaCuenta.css">	
	<title>Administración</title>
	<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>	
</head>
<body>
<div id="menu" class="menu">
	<?php
	if(!empty($rs)) {
	foreach($rs as $rsCliente) {	
	?>
	<a id="menu1" class="salir" href="cuenta.php?clienteId=<?php echo $rsCliente["Cliente_id"]; ?>"></a>
	<?php
	}
	}
	?>
</div>

<div id="bloque0" class="containerNombre">
<?php
if(!empty($rs)) {
foreach($rs as $rsCliente) {
?>
<input type="text"  id="txtNombre" class="txtNombre" name="nombre" disabled="disabled" value="<?php echo $rsCliente["Cliente_Alias"]; ?>">
</div>
<?php
}
?>
<?php 
$rs = null;
}
?>

<div id="conta1" class="container">
<?php
if(!empty($rsCuenta)) 
{
$cont=0;
$arCuenta = array();
foreach($rsCuenta as $rsMonto) {
	array_push($arCuenta, $rsMonto["Cuenta_id"]);
?>
<div id="div_boton" class="item" tabindex="1">
	
	<a id="hyp_cuenta" class="cell" href="cuenta.php?clienteId=<?php echo $rsCliente["Cliente_id"];?>&cuentaId=<?php echo $rsMonto["Cuenta_id"];?>">
	<?php
	date_default_timezone_set('America/Costa_Rica');
	$hoy = date_create('now')->format('Y-m-d');
	$fecha = date_create($rsMonto['Fecha'])->format('Y-m-d');
	$hora = date_create($rsMonto['Fecha'])->format('H:i:s');
	$fechaMostrar = date_create($rsMonto['Fecha'])->format('d-m-Y');		
	if ($fecha==$hoy)
		{				
			//echo $rsMonto["Monto"]. " " .$hora;
			echo $rsMonto["Monto"]. " " .$fechaMostrar;
		}
	else 
		{
			//echo $rsMonto["Monto"]. " " .$fechaMostrar. " " .$hora;
			echo $rsMonto["Monto"]. " " .$fechaMostrar;
		}
	
	?>			
	</a>	
	<div id="btn1" class="cellBotonBorrar" onclick="guardar(<?php echo $cont;?>)"></div>
	<?php
	$cont = $cont+1;
	?>	
</div>	
<?php
}
$rsCuenta = null;
$db = null;
}
?>
</div>

<script>

function guardar(cont){
	
	var arrayFromPHP = <?php echo json_encode($arCuenta) ?>;
	var cuentaId;
	var pendiente=0;
	
	$.each(arrayFromPHP, function (i, elem) {
    	if (i==cont) {    		
    		cuentaId = elem;
    		return false;	
    	}    	
	});	
	
	$('.cellBotonBorrar').html('<img src="img/cargando.png">');   	
	
	$.post("sql/updatePendienteGestor.php", { pendiente: pendiente, cuenta: cuentaId })
	.done(function(data) {	    		
		location.reload();
		$('.cellBotonBorrar').html('<img src="img/borrar.png">');	    		
	}).fail(function(jqXHR, textStatus, error) {
	console.log("Error de la aplicación: " + error);    			
	$(body).append("Error al conectar con la base de datos: " + error);			
	});			
		
}

function borrar(cont)
{		
	var arrayFromPHP = <?php echo json_encode($arCuenta) ?>;
	var cuentaId;	
	
	$.each(arrayFromPHP, function (i, elem) {
    	if (i==cont) {    		
    		cuentaId = elem;
    		return false;	
    	}    	
	});	
	
	$.post("sql/deleteCuentaGestor.php", { cuenta: cuentaId })
	.done(function(data) {
		location.reload();			
		}).fail(function(jqXHR, textStatus, error) {
		console.log("Error de la aplicación: " + error);    			
		$(body).append("Error al conectar con la base de datos: " + error);			
		});
}

$('.salir').html('<img src="img/salir.png">');
$('.cellBotonBorrar').html('<img src="img/borrar.png">');

</script>	
</body>
</html>