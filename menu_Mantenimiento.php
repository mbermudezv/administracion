<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
error_reporting(E_ALL);
ini_set('display_errors', false);        
ini_set('html_errors', true);

/**
* Mauricio Bermudez Vargas 9/07/2018 2:22 p.m.
*/
try 
{
			
require_once("sql/select.php");

$getId = $_GET['menuId'];

$db = new Select();
$rs = $db->conMenuDescripcion($getId);

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
	<link rel="stylesheet" type="text/css" href="css/css_MenuMantenimiento.css">
	<title>Administración</title>
	<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
</head> 
<body>	
<div id="menu" class="menu">
	<a id="menu1" class="salir" href="seleccion.php"></a>
</div>

<div class="container">
<?php
if(!empty($rs)) {
foreach($rs as $rsMenu) {
	$intMenu = $rsMenu["Menu_id"];
?>
<input type="text" id="txtMenu" class="txtDescripcion" name="menu" value="<?php echo $rsMenu["Menu_Descripcion"]; ?>">
</div>
<?php 
}
$rs = null;
$db = null;
}
?>
<div class="containerCalc">
	<div id="div1" class="guardar" onclick="guardar()"></div>
</div>



<script>

function guardar() {

	var intMenu = <?php echo $intMenu; ?>;
	var strDescripcion = $('#txtMenu').val();
	
	$('.guardar').html('<img src="img/cargando.gif">');	    	
		
	$.post("sql/updateMenuGestor.php", { descripcion: strDescripcion, id: intMenu })
	.done(function(data) {	    		
	$(".txtDescripcion").val('');
	$('.guardar').html('<img src="img/guardar.png">');	    		
	}).fail(function(jqXHR, textStatus, error) {
	console.log("Error de la aplicación: " + error);    			
	$(body).append("Error al conectar con la base de datos: " + error);			
	});			
		
}

$(document).ready(function() {
		
	$('input').on('focus', function (e) {
	    $(this)
	        .one('mouseup', function () {
	            $(this).select();
	            return false;
	        })
	        .select();
	});
});

window.onload = function() { document.getElementById("txtMenu").focus(); };

$('.salir').html('<img src="img/salir.png">');
$('.guardar').html('<img src="img/guardar.png">');	

</script>
</body>
</html>