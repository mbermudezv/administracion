var camaraActivar, camaraFoto;

const camaraControl = () =>
  new Promise(async resolve => {    

    var videoSelect = document.getElementById('videoSource');

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
          //height = video.videoHeight / (video.videoWidth/width);
          //video.setAttribute('width', width);
          //video.setAttribute('height', height);
          //canvas.setAttribute('width', width);
          //canvas.setAttribute('height', height);          
          streaming = true;
        }
    });
      
    const start = () => video.play();

    const stop = () =>
    new Promise(resolve => {

      video.addEventListener("stop", () => {
        //canvas.width = width;
        //canvas.height = height;
        //canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        //var data = canvas.toDataURL('image/png');
        //photo.setAttribute('src', data);                        
      });
      
    video.pause();
    
  }); resolve({ start, stop }); });

const camaraStart = async () => {
  camaraActivar = await camaraControl();
  camaraActivar.start();    
}

const camaraStop = async () => {    
  camaraFoto = await camaraActivar.stop();   
}
