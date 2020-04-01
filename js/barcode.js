var ZXing = null;
var decodePtr = null;

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
  console.log("error code", err);
  if (err == -2) {
      setTimeout(scanBarcode, 30);
      return 0;
  }

}