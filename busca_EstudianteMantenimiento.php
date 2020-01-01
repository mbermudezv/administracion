<!-- Mauricio Bermudez Vargas 14/10/2019 04:12 p.m. -->
<?php
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
error_reporting(E_ALL);
ini_set('display_errors', true);        
ini_set('html_errors', true);
 
$dir = "estudiante_Mantenimiento.php";

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Pantalla de búsqueda">
    <meta name="theme-color" content="#499bea" />
    <title>Búsqueda de estudiante</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" type="text/css" media="screen" href="css/css_busca_Estudiante.css" />    
</head>
<body>
<div id="menu">
    <a id="salir" href="<?php echo $dir; ?>"></a>
</div> 
<div id="mainArea">
    <div id="contenedor_Fila"><input type="text" id="txtBuscar" name="buscar" value=""></div>
    <div id="contenedor_Fila"><div id="btnbuscar" onclick="buscar();"></div></div>
    <div id="contenedor_Fila"><a id="hyp_cliente" class="cell"></a></div>         
</div>
<div id="statusBar">
    <a href="https://www.lasesperanzas.ed.cr">lasesperanzas.ed.cr</a>
    <a href="https://www.wappcom.net">wappcom.net</a>                                       
</div>

<script language='javascript'>

function buscar() {
	
	var strAlias = document.getElementById("txtBuscar").value;
    var dir = <?php echo json_encode($dir); ?>;

	$( ".cell" ).remove();	
	
	$.getJSON("sql/selectEstudianteBusquedaGestor.php", { alias: strAlias })	
	.done(function(data) {										
	$.each(data, function(n, linkData) {
				
		var item = document.getElementById("contenedor_Fila");
		var listItem = document.createElement('a');
		var createAText = document.createTextNode(linkData.estudiante_Nombre + " " + 
                                                    linkData.estudiante_PrimerApellido  + " " + 
                                                    linkData.estudiante_SegundoApellido);
		
		listItem.className = "cell";
		listItem.id = "hyp_cliente"	;
		listItem.setAttribute('href', dir + "?estudiante=" + linkData.estudiante_Id);				
		listItem.appendChild(createAText);
		item.appendChild(listItem);				
		
	});		
	}).fail(function(jqXHR, textStatus, error) {			
	console.log("Error de la aplicación: " + error);    			
	$(body).append("Error al conectar con la base de datos: " + error);			
	});
}

	
window.onload = function() { 
	document.getElementById("txtBuscar").focus();
	return false; 
};

$('#salir').html('<img src="img/salir.png">');
$('#btnbuscar').html('<img src="img/refresh.png">');


</script>
</body>
</html>