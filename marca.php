<?php
// *********** 
// Mauricio Bermudez Vargas 29/11/2019 10:12 a.m.
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
//Variable que indica guardar aunque no tenga solicitud
$sinSolicitud=0;

$db = new Select();
$rs = $db->conMenuDescripcion($intMenuId);

$estudiante_Nombre="";
$estudiante_PrimerApellido="";
$estudiante_SegundoApellido="";
$estudiante_Descripcion="";
$estudiante_Cedula="";

if (isset($_GET['estudiante'])) { 
    $estudiante_Id = $_GET['estudiante'];   
    $rsEstudiante = $db->conEstudiante($estudiante_Id);    
    if (!empty($rsEstudiante)) {            
        foreach ($rsEstudiante as $key => $value) {
            $estudiante_Nombre = $value['estudiante_Nombre'];
            $estudiante_PrimerApellido = $value['estudiante_PrimerApellido'];
			$estudiante_SegundoApellido = $value['estudiante_SegundoApellido'];
			$estudiante_Cedula = $value['estudiante_Cedula'];
        }
        $estudiante_Descripcion = $estudiante_Nombre . " " . $estudiante_PrimerApellido . " " . $estudiante_SegundoApellido;                      
    }            
} 
//Si esta setiado, proviene de la pantalla busqueda estudiante
if (isset($_GET['sinSolicitud'])) { 
 	$sinSolicitud = 1;
}

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

<div id="menu">
	<a id="salir" href="seleccion.php"></a>
	<a id="add" href="busca_Estudiante.php?tipo=<?php echo $getTipoMarca; ?>"></a>	
</div>
<div id="mainArea">
    <!-- Contenerdor menu -->
    <div id="contenedorMenu">
        <img id="menuEncabezado" src="img/menu_top.jpg"></img>	
        <?php
            if(!empty($rs)) {
                foreach($rs as $rsMenu) {
                ?>
                <div id="MenuCartaContenedor">
                    <div id="txtMenu"><?php echo $rsMenu["Menu_Descripcion"]; ?></div>	
                </div>
                <?php
            }
            $rs = null;
            }
        ?>
        <img id="menuButtom" src="img/bottom.jpg"></img>
    </div>

    <!-- Contenedor de proceso marca -->
    <div id="contenedorMarca">
        <div id="divTitulo"></div>
        <div id="divNombre"><?php echo $estudiante_Descripcion; ?></div>
        <div id="containerTxt">
            <input type="text" id="txtMarca" name="marca" maxlength="20" value="<?php echo $estudiante_Cedula; ?>">
        </div>
        <div id="contenedorFrase">
            <img id="imagenMarca">
        </div>
    </div>
</div>
<div id="statusBar">
    <a id="linkHogar" href="https://www.lasesperanzas.ed.cr">lasesperanzas.ed.cr</a>
    <a id="linkWappcom"href="https://www.wappcom.net">wappcom.net</a>                                       
</div>

<script language='javascript'>
// 1: Solicitud Almuerzo
// 2: Registro Almuerzo
var intSeleccion=<?php echo $getTipoMarca; ?>;
var intSolicitud=1; //Constante para ser usada en la verificación de solicitud
var strSolicitud="Solicitud Almuerzo";
var strRegistro="Registro Almuerzo"
var sinSolicitud = <?php echo $sinSolicitud; ?>;

function totalRegistros(intTipo){

	$.get("sql/selectCountMarcasGestor.php", { tipoRegistro: intTipo })
	.done(function(data) {
	if (intTipo==1) {
		document.getElementById("divTitulo").innerHTML = strSolicitud + " " + data;		
	} else if (intTipo==2) {
		document.getElementById("divTitulo").innerHTML = strRegistro + " " + data;		
	}
	}).fail(function(jqXHR, textStatus, error) {
	console.log("Error de la aplicación: " + error);
	});
	return false;
};

function registrarMarca(intId, intTipo){

	/* muestraImagen();
	return false; */
	
	$.get("sql/selectMarcaRegistradaGestor.php", { tipoRegistro: intTipo, id: intId })
	.done(function(data) {
	if (data=="0") {
		//Registra marca		
		$.post("sql/insertMarcaGestor.php", { id: intId, seleccion: intTipo })
		.done(function(data) {
			document.getElementById('txtMarca').value = '';
			totalRegistros(intTipo);
			muestraImagen();		   		
			}).fail(function(jqXHR, textStatus, error) {
				console.log("Error de la aplicación: " + error);    			
				$(body).append("Error al conectar con la base de datos: " + error);			
				});
	} else if (data=="1") {
		document.getElementById("divNombre").innerHTML = "Su marca ya ha sido registrada";
		document.getElementById('txtMarca').value = '';			
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
		document.getElementById('txtMarca').value = '';				
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

document.getElementById("txtMarca").onkeydown = function(evt) {
	var charCode = typeof evt.which == "number" ? evt.which : evt.keyCode;
	if (charCode == 13) {

		var strCedula = document.getElementById("txtMarca").value;		

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
			if (sinSolicitud==0) {
				//Verifa que se haya hecho la solicitud antes de guardar registro almuerzo			
				verificaSolicitud(data.Id, intSolicitud);				
			} else {
				//Si viene de la pantalla busqueda estudiante
				registrarMarca(data.Id, intSeleccion);
				sinSolicitud = 0;
			}
		}													
		}).fail(function(jqXHR, textStatus, error) {
			document.getElementById("divNombre").innerHTML = "No se encontró el estudiante";
			document.getElementById('txtMarca').value = '';
			console.log("Error de la aplicación: " + error);    			
			$(body).append("Error al conectar con la base de datos: " + error);			
		});
		
	}
};

function transformTypedChar(charStr) {
	return charStr == "'" ? "-" : charStr;
};

document.getElementById("txtMarca").onkeypress = function(evt) {
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
    document.getElementById("txtMarca").focus();
    return false;
};


$('#salir').html('<img src="img/salir.png">');
$('#add').html('<img src="img/add.png">');
</script>

</body>
</htm>

