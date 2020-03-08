var camaraActivar, camaraFoto;

const camaraControl = () =>
  new Promise(async resolve => {    

    var constraints = {
      video: {
        deviceId: {exact: videoSelect.value}
      }
    };

    const stream = await navigator.mediaDevices.getUserMedia(constraints);
    
    if (navigator.mozGetUserMedia) {
      video.mozSrcObject = stream;
    } else {     
      video.srcObject = stream;
    }

    video.addEventListener("dataavailable", event => {
        if (!streaming){
          height = video.videoHeight / (video.videoWidth/width);
          video.setAttribute('width', width);
          video.setAttribute('height', height);
          canvas.setAttribute('width', width);
          canvas.setAttribute('height', height);
          streaming = true;
        }
    });
      
    const start = () => video.play();

    const stop = () =>
    new Promise(resolve => {
      video.pause();
      
      video.addEventListener("stop", () => {
      
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

        barcode_result.textContent = "";        canvas.width = width;
        if (ZXing == null) {
          stopbutton.disabled = false;
          alert("Error con lector de barra!");
          return;
        }
        
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, 
          height);
        var data = canvas.toDataURL('image/png');
        photo.setAttribute('src', data);
        
        // read barcode
        var imageWidth = 640, imageHeight = 480;
        var imageData = canvas.getImageData(0, 0, width, height);
        
        var idd = imageData.data;
        var image = ZXing._resize(imageWidth, imageHeight);  
        
        for (var i = 0, j = 0; i < idd.length; i += 4, j++) {
            ZXing.HEAPU8[image + j] = idd[i];
        }
    
        var err = ZXing._decode_any(decodePtr);
        //console.timeEnd('decode barcode');
        console.log("error code", err);
        if (err == -2) {
            setTimeout(camaraStop, 30);
        }                         
      });

    //video.pause();

  }); resolve({ start, stop }); });

const camaraStart = async () => {
  camaraActivar = await camaraControl();
  camaraActivar.start();    
}

const camaraStop = async () => {    
  camaraFoto = await camaraActivar.stop();   
}
