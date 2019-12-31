<?php

// Mauricio Bermudez Vargas 12/07/2018 9:35 a.m.

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
error_reporting(E_ALL);
ini_set('display_errors', false);
ini_set('html_errors', true);

require_once("sql/select.php");

try {

$getmarcaTipo = 0;

if (isset($_GET['fechaDesde'])) {
    $getfecDesde = $_GET['fechaDesde'];
    $getmarcaTipo = $_GET['tipo'];    
    $db = new Select();
    if ($getmarcaTipo == 2) {
        $rs = $db->conReporteAlmuerzo($getfecDesde,2,3); // 2: Registro Almuerzo y 3: Registro Almuerzo sin Solicitud
    } else {
        // 1: Solicitud Almuerzo y 3: Registro Almuerzo sin Solicitud
        $rs = $db->conReporteSolicitudySin($getfecDesde,$getmarcaTipo);
    }
    
}	
} catch (PDOException $e) {
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
<link rel="stylesheet" type="text/css" href="css/css_ReporteAlmuerzo.css">
<title>Reporte</title>
<script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="jq/jquery-ui.js"></script>
<script>
 
 var tipo = <?php echo $getmarcaTipo; ?>;

$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '< Anterior',
    nextText: '  Siguiente >',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd-mm-yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
 };

 $.datepicker.setDefaults($.datepicker.regional['es']);

$(function() {
    $('.datepicker').datepicker();
});
</script>

</head>

<body>

<div class="menu">
<a id="menu1" class="salir" href="seleccion.php"></a>    
</div>

<form action="" id="formulario" method="get">
    <div id="itemOption">
            <!-- 1: Solicitud Almuerzo -->
            <!-- 2: Registro Almuerzo -->
            <!-- 3: Registro Almuerzo sin Solicitud -->
            <div><input type="radio" id="rad1" name="tipo" value="2"> Registro de Almuerzos</div>
            <div><input type="radio" id="rad2" name="tipo" value="1"> Registro de Solicitudes </div>
            <div><input type="radio" id="rad3" name="tipo" value="3"> Registro de Almuerzos sin Solicitudes </div>
    </div> 
    <div id="cont1" class="contDate">       
        <div id="cont2" class="itemDate">
            <input  id="inp1" type="text" name="fechaDesde" maxlength="10" autocomplete="off" class="datepicker" placeholder="  Fecha inicio..." readonly="readonly">
        </div> 
        <div id="btn1" class="btnbuscar" onclick="document.getElementById('formulario').submit();"></div>
    </div>
</form>
<div class="menu_export">
    <div class="imprimir"></div>
    <a id="hyp_excel" class="excel" href="reporte_exportarAlmuerzo.php?fechaDesde=<?php echo $getfecDesde;?>&t=1"></a>
    <a id="hyp_excel" class="word" href="reporte_exportarAlmuerzo.php?fechaDesde=<?php echo $getfecDesde;?>&t=2"></a>    
</div>
<div id="enc1" class="encabezado">
    <div id="log1" class="logo"></div>
    <div id="tit1" class="titulo"></div>
</div>

<div id="enc1" class="tabla_encabezado_rango">
    <div id="encItem1" class="tabla_encabezado_rango_item">Fecha:</div>
    <div id="encItem2" class="tabla_encabezado_rango_item"><?php echo $getfecDesde; ?></div>
</div>
<div id="tab1" class="tabla_titulo">
    <div id="tab1Item1" class="tabla_titulo_item">Nombre</div>
    <div id="tab1Item2" class="tabla_titulo_item">Sección</div>
</div>
<?php
    if(!empty($rs)) {
    foreach($rs as $rsItemAlmuerzo) {
        $nombrecompleto = $rsItemAlmuerzo["Estudiante_Nombre"] . ' ' . $rsItemAlmuerzo["Estudiante_Apellido1"] . ' ' . $rsItemAlmuerzo["Estudiante_Apellido2"];
?>  
<div id="tab2" class="tabla">  
    <div id="tab2Item1" class="tabla_item"><?php echo $nombrecompleto; ?></div>
    <div id="tab2Item2" class="tabla_item"><?php echo $rsItemAlmuerzo["Estudiante_Seccion"]; ?></div>
</div>    
<?php
} 
$rs = null;
$db = null;
}
?>

<div id="tab3" class="contendor_linea_firma">
    <div id="tab3Item1" class="linea_firma">------------------------------</div>
    <div id="tab3Item2" class="linea_firma">------------------------------</div>
    <div id="tab3Item3" class="linea_firma">------------------------------</div>
</div>
<div id="tab4" class="contenedor_nombre_firma">
    <div id="tab4Item1" class="item_nombre_firma">MSc. Magaly Camacho Aguero</div>
    <div id="tab4Item2" class="item_nombre_firma">MSc. Raquel Vindas Quirós</div>
    <div id="tab4Item3" class="item_nombre_firma">Anaís Monge Montoya</div>
</div>
<div id="tab4" class="contenedor_nombre_firma">
    <div id="tab4Item1" class="item_nombre_firma">Directora institucional</div>
    <div id="tab4Item2" class="item_nombre_firma">Coordinadora Comité Nutrición</div>
    <div id="tab4Item3" class="item_nombre_firma">Comité Nutrición</div>
</div>
 <script>

 if (tipo==2) {
    document.getElementById('tit1').innerHTML = "Registro de Almuerzos";
}

if (tipo==1) {
    document.getElementById('tit1').innerHTML = "Registro de Solicitudes";
} 

if (tipo==3) {
    document.getElementById('tit1').innerHTML = "Registro de Almuerzos sin Solicitudes";
}

$(document).ready(function() {

    $('.menu_export').on('click', ".imprimir", function () {
        $('.menu').hide();
        $('.containerNombre').hide();
        $('.contDate').hide();
        $('.menu_export').hide();
        window.print();
        $('.menu').show();
        $('.containerNombre').show();
        $('.contDate').show();
        $('.menu_export').show();        
    });
    
    $('#rad1').click(function () {
           document.getElementById('tit1').innerHTML = "Registro de Almuerzos";
    });

    $('#rad2').click(function () {
           document.getElementById('tit1').innerHTML = "Registro de Solicitudes";
    });

    $('#rad3').click(function () {
           document.getElementById('tit1').innerHTML = "Registro de Almuerzos sin Solicitudes";
    });

});

$('.salir').html('<img src="img/salir.png">');
$('.btnbuscar').html('<img src="img/refresh.png">');
$('.imprimir').html('<img src="img/print.png">');
$('.excel').html('<img src="img/excel.png">');
$('.word').html('<img src="img/word.png">');
$('.logo').html('<img src="img/escudo.png">');

</script> 
</body>
</html>