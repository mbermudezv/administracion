<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

/**
* Mauricio Bermudez Vargas 13/02/2018 9:30 p.m.
*/
try 
{
	
require_once("sql/select.php");

$getCliente = $_GET['clienteId'];

if (isset($_GET['cuentaId'])) {
	$getCuenta = $_GET['cuentaId'];
}

$cuenta = 0;

$db = new Select();
$rs = $db->conClienteAlias($getCliente);
if (!empty($getCuenta)) {
	$rsCuenta = $db->conMontoCuenta($getCuenta);	
}	
else
{
	$rsCuenta = null;
	$cuenta = 0;
}

} catch (PDOException $e) {		
	$rs = null;
	$db = null;
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	exit;
}
?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="autor" content="Mauricio Bermúdez Vargas" />
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="css/css_Cuenta.css">
	<title>Administración</title>
	<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="jq/jquery.inputmask.bundle.min.js"></script>
</head> 
<body>	
<div id="menu" class="menu">
	<a id="menu1" class="salir" href="principal.php"></a>			
	<?php
	if(!empty($rs)) {
	foreach($rs as $rsCliente) {	
	?>
	<a id="menu2" class="modificar" href="modifica_cuenta.php?clienteId=<?php echo $rsCliente["Cliente_id"]; ?>"></a>
	<?php
	}
	}
	?>

</div>

<div class="container">
	<?php
	if(!empty($rs)) {
	$monto = 0;
	foreach($rs as $rsCliente) {
	?>
	<input type="text" id="txtNombre" class="txtNombre" name="nombre" disabled="disabled" value="<?php echo $rsCliente["Cliente_Alias"]; ?>">
	<?php
	if(!empty($rsCuenta)) {
		foreach($rsCuenta as $rsMonto) {
			$cuenta= $rsMonto["Cuenta_id"];
			$monto = $rsMonto["Monto"];
		}
	}	
	?>
	<input type="text" id="txtMonto" class="txtMonto" name="monto" maxlength="10" value="<?php echo $monto;?>">
</div>
<?php 
}
$rsCuenta= null;
$rs = null;
$db = null;
}
?>

<div class="containerCalc">
	<div id="div1" class="quin">500</div>
	<div id="div2" class="cuat">400</div>
	<div id="div3" class="tres">300</div>
	<div id="div4" class="dosi">200</div>
	<div id="div5" class="limpiar">C</div>
    <div id="div6" class="guardar" onclick="guardar()"></div>
</div>

<script>

function guardar()
{
	
	var cliente = <?php echo $getCliente; ?>;
	var monto = $('#txtMonto').val();
	var cuenta = <?php echo $cuenta; ?>;

	$('.guardar').html('<img src="img/cargando.gif">');	    	
	
	if (cuenta==0)	{
			$.post("sql/insertCuentaGestor.php", {cliente: cliente, monto: monto})
			.done(function(data) {	    		
			$(".txtMonto").val("0");
			$('.guardar').html('<img src="img/guardar.png">');	    		
			}).fail(function(jqXHR, textStatus, error) {
			console.log("Error de la aplicación: " + error);    			
			$(body).append("Error al conectar con la base de datos: " + error);			
			});	

	} else	{
		$.post("sql/updateCuentaGestor.php", { monto: monto, cuenta: cuenta })
		.done(function(data) {	    		
		//$(".txtMonto").val("0");
		$('.guardar').html('<img src="img/guardar.png">');	    		
		}).fail(function(jqXHR, textStatus, error) {
		console.log("Error de la aplicación: " + error);    			
		$(body).append("Error al conectar con la base de datos: " + error);			
		});			
	}	

}

$(document).ready(function() 
{
	
	$(".txtMonto").inputmask({
	'alias': 'decimal',
	rightAlign: true,
	'groupSeparator': '.',
	'autoGroup': true
	});
	
	$('.containerCalc').on('click', ".quin", function () {
	    $(".txtMonto").val("500");
	});
	
	$('.containerCalc').on('click', ".cuat", function () {
	    $(".txtMonto").val("400");	       
	});
	
	$('.containerCalc').on('click', ".tres", function () {
	    $(".txtMonto").val("300");	       
	});

	$('.containerCalc').on('click', ".dosi", function () {
    $(".txtMonto").val("200");	       
	});

	$('.containerCalc').on('click', ".limpiar", function () {
    $(".txtMonto").val("0");	       
	});

	$('input').on('focus', function (e) {
	    $(this)
	        .one('mouseup', function () {
	            $(this).select();
	            return false;
	        })
	        .select();
	});
});

$('.salir').html('<img src="img/lista.png">');
$('.modificar').html('<img src="img/menu.png">');
$('.guardar').html('<img src="img/guardar.png">');	

</script>
</body>
</html>