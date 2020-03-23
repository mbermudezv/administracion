<?php
$htmlContent = '
<html>
<body>
<center><h2>COMPROBANTE DE PAGO ASOCIACIÓN HOGAR BETANIA</h2></center>
<center><h3>ORIGINAL TRABAJADOR</h3></center>
<center><p>Daniel Flores, Pérez Zeledón</p></center>
<center><p>Telefónos: 27726441 - 27713469</p></center>
<table border="1" align="center" cellpadding="5">';
$htmlContent .= '
</table>
<table align="center" cellpadding="5">
    <tr><td></td><td></td></tr>          
    <tr><td width="50%">Firma del trabajador:</td><td align="center">____________________________</td></tr>
    <tr><td>Cédula:</td><td align="center"></td></tr>
    <tr><td></td><td></td></tr>
    <tr><td>Observaciones:</td><td></td></tr>
</table>
</body>
</html>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>
</head>
<body>
 <label>Hola!</label>
 <button onclick="enviar()">Enviar</button>
<script language='javascript'>

    function enviar() {

        var email = "mauriciobermudez@hotmail.com";
        var contenido =  <?php echo '"'. urlencode($htmlContent) .'"'; ?>;        
        //var contenido = document.getElementsByTagName("body");
        var params = "email="+encodeURIComponent(email)+"&body="+contenido;
        //var params = "email="+"1"+"&body="+"1";
        
        var xhr=new XMLHttpRequest();
        xhr.open('POST','https://www.wappcom.net/comedor/email_comprobante.php',true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        //xhr.setRequestHeader("Content-length", params.length);               
        xhr.onload=function(e) {    
            if (xhr.readyState === xhr.DONE) {
                // Listo;                                                                            
                if (xhr.status === 200) {
                    console.log(xhr.response);                                                                 
                }  
            }                   
        };
        xhr.onreadystatechange=function() {
            if (xhr.readyState==4) {
                document.write(xhr.responseText);
            }
        };         
        //xhr.send(params);
    }    

</script>        
</body>
</html>