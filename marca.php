<?php
// *********** 
// Mauricio Bermudez Vargas 20/05/2018 12:10 p.m.
// ***********

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
error_reporting(E_ALL);
ini_set('display_errors', false);        
ini_set('html_errors', true);

try 
{

require_once("sql/select.php");
// 1: Solicitud Almuerzo
// 2: Registro Almuerzo
$getTipoMarca = $_GET['tipo'];
// 1: Almuerzo
$intMenuId = 1;

$db = new Select();
$rs = $db->conMenuDescripcion($intMenuId);

} catch (PDOException $e) {		
	$rs = null;
	$db = null;
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	exit;
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="autor" content="Mauricio Bermúdez Vargas" />
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" type="text/css" href="css/css_marca.css">
<title>Marca</title>
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
</head>
<body>
<div id="menuContenedor" class="menuContenedor">
	<a id="salir" class="salir" href="seleccion.php"></a>	
</div>
<!-- Contedor Principal -->
<div id="contenedorPrincipal" class="contenedorPrincipal">
	<!-- Contenerdor menu -->
	<div id="contenedorMenu" class="contenedorMenu">
		<img id="menuEncabezado" class="menuEncabezado" src="img/menu_top.jpg"></img>	
		<?php
		if(!empty($rs)) {
		foreach($rs as $rsMenu) {
		?>
		<div id="MenuCartaContenedor" class="MenuCartaContenedor">
			<div id="txtMenu" class="txtMenu"><?php echo $rsMenu["Menu_Descripcion"]; ?></div>	
		</div>
		<?php
		}
		$rs = null;
		}
		?>
		<img id="menuButtom" class="menuButtom" src="img/bottom.jpg"></img>
	</div>
	<!-- Contenedor de proceso marca -->
	<div id="contenedorMarca">
		<div id="divTitulo" class="divTitulo"></div>
		<div id="divNombre" class="divNombre"></div>
		<div class="containerTxt">
			<input type="text" id="txt1" class="txtMarca" name="marca" maxlength="20">
		</div>
		<div id="contenedorFrase" class="contenedorFrase">
			<img id="imagenMarca" class="imagenMarca">
		</div>
	</div>
</div>

<script language='javascript'>
// 1: Solicitud Almuerzo
// 2: Registro Almuerzo
var intSeleccion=<?php echo $getTipoMarca; ?>;
var intSolicitud=1; //Constante para ser usada en la verificación de solicitud
var strSolicitud="Solicitud Almuerzo";
var strRegistro="Registro Almuerzo"

function totalRegistros(intTipo){

	$.get("sql/selectCountMarcasGestor.php", { tipoRegistro: intTipo })
	.done(function(data) {
	if (intTipo==1) {
		document.getElementById("divTitulo").innerHTML = strSolicitud + ": " + data;		
	} else if (intTipo==2) {
		document.getElementById("divTitulo").innerHTML = strRegistro + ": " + data;		
	}
	}).fail(function(jqXHR, textStatus, error) {
	console.log("Error de la aplicación: " + error);
	});
	return false;
};

function registrarMarca(intId, intTipo){

	$.get("sql/selectMarcaRegistradaGestor.php", { tipoRegistro: intTipo, id: intId })
	.done(function(data) {
	if (data=="0") {
		//Registra marca		
		$.post("sql/insertMarcaGestor.php", { id: intId, seleccion: intTipo })
		.done(function(data) {
			document.getElementById('txt1').value = '';
			totalRegistros(intTipo);
			muestraImagen();		   		
			}).fail(function(jqXHR, textStatus, error) {
				console.log("Error de la aplicación: " + error);    			
				$(body).append("Error al conectar con la base de datos: " + error);			
				});
	} else if (data=="1") {
		document.getElementById("divNombre").innerHTML = "Su marca ya ha sido registrada";
		document.getElementById('txt1').value = '';			
	} 		
	}).fail(function(jqXHR, textStatus, error) {
	console.log("Error de la aplicación: " + error);	
	});
	return false;
}

function verificaSolicitud(intId, intSolicitud){

	$.get("sql/selectMarcaRegistradaGestor.php", { tipoRegistro: intSolicitud, id: intId })
	.done(function(data) {
	if (data=="0") {
		document.getElementById("divNombre").innerHTML = "No existe solicitud de almuerzo";
		document.getElementById('txt1').value = '';				
	} else if (data=="1") {
		//Registra marca
		registrarMarca(intId, intSeleccion);
	} 		
	}).fail(function(jqXHR, textStatus, error) {
	console.log("Error de la aplicación: " + error);	
	});
	return false;

};

function muestraImagen() {
//Muestra imagen
	$.get("php/selectImg.php")
	.done(function(data) {		
	document.getElementById("imagenMarca").src = "img/marca/" + data;
	}).fail(function(jqXHR, textStatus, error) {
	console.log("Error de la aplicación: " + error);
	});
	return false;
};

document.getElementById("txt1").onkeydown = function(evt) {
	var charCode = typeof evt.which == "number" ? evt.which : evt.keyCode;
	if (charCode == 13) {

		var strCedula = document.getElementById("txt1").value;		

		$.getJSON("sql/selectEstudianteGestor.php", { cedula: strCedula })
		.done(function(data) {	    		
		//Muestra nombre estudiante		
		document.getElementById("divNombre").innerHTML = data.Nombre + " " + data.Apellido1 + " " + data.Apellido2;
		// 1: Solicitud Almuerzo
		// 2: Registro Almuerzo
		if (intSeleccion==1) {
			//Registra marca solicitud			
			registrarMarca(data.Id, intSeleccion);
		} else if (intSeleccion==2) {
			//Verifa que se haya hecho la solicitud antes de guardar registro almuerzo			
			verificaSolicitud(data.Id, intSolicitud);
		}													
		}).fail(function(jqXHR, textStatus, error) {
			document.getElementById("divNombre").innerHTML = "No se encontró el estudiante";
			document.getElementById('txt1').value = '';
			console.log("Error de la aplicación: " + error);    			
			$(body).append("Error al conectar con la base de datos: " + error);			
		});
		
	}
};

function transformTypedChar(charStr) {
	return charStr == "'" ? "-" : charStr;
};

document.getElementById("txt1").onkeypress = function(evt) {
    var val = this.value;
    evt = evt || window.event;

    // Ensure we only handle printable keys, excluding enter and space
    var charCode = typeof evt.which == "number" ? evt.which : evt.keyCode;
    if (charCode && charCode > 32) {
        var keyChar = String.fromCharCode(charCode);

        // Transform typed character
        var mappedChar = transformTypedChar(keyChar);

        var start, end;
        if (typeof this.selectionStart == "number" && typeof this.selectionEnd == "number") {
            // Non-IE browsers and IE 9
            start = this.selectionStart;
            end = this.selectionEnd;
            this.value = val.slice(0, start) + mappedChar + val.slice(end);

            // Move the caret
            this.selectionStart = this.selectionEnd = start + 1;
        } else if (document.selection && document.selection.createRange) {
            // For IE up to version 8
            var selectionRange = document.selection.createRange();
            var textInputRange = this.createTextRange();
            var precedingRange = this.createTextRange();
            var bookmark = selectionRange.getBookmark();
            textInputRange.moveToBookmark(bookmark);
            precedingRange.setEndPoint("EndToStart", textInputRange);
            start = precedingRange.text.length;
            end = start + selectionRange.text.length;

            this.value = val.slice(0, start) + mappedChar + val.slice(end);
            start++;

            // Move the caret
            textInputRange = this.createTextRange();
            textInputRange.collapse(true);
            textInputRange.move("character", start - (this.value.slice(0, start).split("\r\n").length - 1));
            textInputRange.select();
        }
        return false;
    }
};

window.onload = function() {
	
	intSeleccion=<?php echo $getTipoMarca; ?>;
	totalRegistros(intSeleccion);
    document.getElementById("txt1").focus();
    return false;
};


$('.salir').html('<img src="img/salir.png">');

</script>

</body>
</html>
