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

} catch (PDOException $e) {		
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="autor" content="Mauricio Bermúdez Vargas"/>
    <meta name="viewport" content="width=device-width"/>
    <link rel="stylesheet" type="text/css" href="css/css_marcam.css?<?php echo rand(); ?>">
    <title>Marca</title>    
    <script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
    <script async src="js/zxing.js"></script>
    <script type="text/javascript" src="js/barcode.js"></script>    
    <script type="text/javascript" src="js/camara.js"></script> 
</head>
<body>
<div id="menu">
	<a id="salir" href="seleccion.php"></a>
	<a id="add" href="busca_Estudiante.php?tipo=<?php echo $getTipoMarca; ?>"></a>	
</div>
 <div id="mainArea"> 
    <!-- Contenedor de proceso marca -->
    <div id="contenedorMarca"> 
      <div id="containerTxt">
        <div>Cédula: <span id="dbr"></span></div>        
      </div>
      <div class="select"><label for="videoSource">Video source: </label>
        <select id="videoSource"></select>
      </div>   
      <div id="containerButton">           
          <button id="startbutton"></button>    
          <button id="stopbutton"></button>
      </div>    	    
      <video id="video" autobuffer></video>
      <canvas id="canvas" width="240" height="320"></canvas>
       <!-- <img id="photo"> -->
    </div> 
</div> 
<div id="statusBar">
    <a id="linkHogar" href="https://www.lasesperanzas.ed.cr">lasesperanzas.ed.cr</a>
    <a id="linkWappcom"href="https://www.wappcom.net">wappcom.net</a>                                       
</div>

<script language='javascript'>

var streaming = false,
  video        = document.querySelector('#video'),
  canvas       = document.querySelector('#canvas'),
  startbutton  = document.getElementById('startbutton'),
  stopbutton  = document.getElementById('stopbutton'),
  barcode_result = document.getElementById('dbr'),
  width = 240,
  height = 320;

  //photo        = document.querySelector('#photo'),  

startbutton.addEventListener('click', function(ev){ camaraStart(); ev.preventDefault();}, false);
stopbutton.addEventListener('click', function(ev){ camaraStop(); scanBarcode(); ev.preventDefault();}, false);

function gotDevices(deviceInfos) {
  for (var i = deviceInfos.length - 1; i >= 0; --i) {
    var deviceInfo = deviceInfos[i];
    var videoSelect = document.getElementById('videoSource');
    var option = document.createElement('option');
    option.value = deviceInfo.deviceId;
    if (deviceInfo.kind === 'videoinput') {
      option.text = deviceInfo.label || 'camera ' +
        (videoSelect.length + 1);
      videoSelect.appendChild(option);
    } else {455
      console.log('Found one other kind of source/device: ', deviceInfo);
    }
  }
}

navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);

function handleError(error) {
  console.log('Error: ', error);
}

$('#salir').html('<img src="img/salir.png">');
$('#add').html('<img src="img/add.png">');
$('#stopbutton').html('<img src="img/camaraboton.png">');
$('#startbutton').html('<img src="img/start.png">');

</script>
</body>
</html>

