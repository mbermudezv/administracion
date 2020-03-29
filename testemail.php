<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
    <script language='javascript'>
        
        function enviar() {

            var email = "mauriciobermudez@hotmail.com";

            //var contenidophp =  <?php //echo '"'. urlencode($htmlContent) .'"'; ?>;
            var contenido = document.getElementsByTagName("body");
            var contenidojs = "<html>"+contenido[0].outerHTML+"</html>"            

            var params = "email="+encodeURIComponent(email)+"&body="+encodeURIComponent(contenidojs);        
            
            var xhr=new XMLHttpRequest();
            xhr.open('POST','https://www.wappcom.net/comedor/email_comprobante.php',true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");            
            xhr.onload=function(e) {    
                if (xhr.readyState === xhr.DONE) {                                                                                            
                    if (xhr.status === 200) {
                        console.log(xhr.response);                                                                 
                    }  
                }                   
            };
            xhr.send(params);
        }       

</script>
</head>
<body>
 <label>Hola!</label>
 <button onclick="enviar()">Enviar</button>
 <p id="php"></p>
 <p id="js"></p>
</body>
</html>    
