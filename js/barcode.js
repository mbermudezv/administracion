var ZXing = null;
var decodePtr = null;
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);     
const sinSolicitud = urlParams.get('sinSolicitud');
const intSolicitud=1; //Constante para ser usada en la verificación de solicitud
const intSeleccion = 2;// 2: Registro Almuerzo

var tick = function () {
if (window.ZXing) {
  ZXing = ZXing();
  decodePtr = ZXing.Runtime.addFunction(decodeCallback);
  
} else {
  setTimeout(tick, 10);
}
};

tick();

var decodeCallback = function (ptr, len, resultIndex, resultCount) {
  var result = new Uint8Array(ZXing.HEAPU8.buffer, ptr, len);
  console.log(String.fromCharCode.apply(null, result));
  barcode_result.textContent = String.fromCharCode.apply(null, result);
};

function scanBarcode() {
  
  var ctx = canvas.getContext('2d');  
  barcode_result.textContent = "";        
  
  if (ZXing == null) {
      stopbutton.disabled = false;
      alert("Error con lector de barra!");
      return 0;
  }
  
  var context = null;
  context = ctx;
  
  context.drawImage(video, 0, 0, width, height);
  var vid = document.getElementById("video");
  console.log("video width: " + vid.videoWidth + ", height: " + vid.videoHeight);

  var barcodeCanvas = document.createElement("canvas");
  barcodeCanvas.width = vid.videoWidth;
  barcodeCanvas.height = vid.videoHeight;

  var barcodeContext = barcodeCanvas.getContext('2d');
  var imageWidth = vid.videoWidth, imageHeight = vid.videoHeight;
  barcodeContext.drawImage(video, 0, 0, imageWidth, imageHeight);
  
  // read barcode
  var imageData = barcodeContext.getImageData(0, 0, imageWidth, imageHeight);
  
  var idd = imageData.data;
  var image = ZXing._resize(imageWidth, imageHeight);  
  console.time("decode barcode");
  for (var i = 0, j = 0; i < idd.length; i += 4, j++) {
      ZXing.HEAPU8[image + j] = idd[i];
  }
  
  var err = ZXing._decode_any(decodePtr);
  //alert(err);
  console.timeEnd('decode barcode');
  //console.log("error code", err);
  if (err == -2) {
      setTimeout(scanBarcode, 30);
      return 0;
    } else {
        estudianteDatos();
        return 1;
      }    
}

function registrarMarca(intId, intTipo){

	/* muestraImagen();
	return false; */
	
	$.get("sql/selectMarcaRegistradaGestor.php", { tipoRegistro: intTipo, id: intId })
	.done(function(data) {
	if (data=="0") {
		//Registra marca		
		$.post("sql/insertMarcaGestor.php", { id: intId, seleccion: intTipo })
		.done(function(data) {
      //document.getElementById('dbr').value = '';
      //document.getElementById('divNombre').value = '';
			//totalRegistros(intTipo);
			//muestraImagen();		   		
			}).fail(function(jqXHR, textStatus, error) {
				console.log("Error de la aplicación: " + error);    			
				$(body).append("Error al conectar con la base de datos: " + error);			
				});
	} else if (data=="1") {
		document.getElementById("divNombre").innerHTML = "Su marca ya ha sido registrada";
		document.getElementById('dbr').value = '';			
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
		document.getElementById('dbr').value = '';				
	} else if (data=="1") {
		//Registra marca
		registrarMarca(intId, intSeleccion);
	} 		
	}).fail(function(jqXHR, textStatus, error) {
	console.log("Error de la aplicación: " + error);	
	});
	return false;

};

function estudianteDatos() {
  
  $.getJSON("sql/selectEstudianteGestor.php", { cedula: barcode_result.textContent })
  .done(function(data) {	    		
    //Muestra nombre estudiante		
    document.getElementById("divNombre").innerHTML = data.Nombre + " " + data.Apellido1 + " " + data.Apellido2;
    
    

    if (sinSolicitud==0) {
      //Verifa que se haya hecho la solicitud antes de guardar registro almuerzo			
      verificaSolicitud(data.Id, intSolicitud);				
    } else {
      //Si viene de la pantalla busqueda estudiante
      intSeleccion = 3; // 3: Registro Almuerzo sin Solicitud
      registrarMarca(data.Id, intSeleccion);
      sinSolicitud = 0; //Reinicia la variable 
      intSeleccion = 2; //Deja la variable como estaba
    }												
  }).fail(function(jqXHR, textStatus, error) {
    document.getElementById("divNombre").innerHTML = "No se encontró el estudiante";
    document.getElementById('txtMarca').value = '';
    console.log("Error de la aplicación: " + error);    			
    $(body).append("Error al conectar con la base de datos: " + error);			
  });


}