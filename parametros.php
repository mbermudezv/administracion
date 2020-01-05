<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);
ini_set('display_errors', false);
/**
* Mauricio Bermudez Vargas 02/01/2020 12:26 a.m.
*/
try {
    require_once("sql/select.php");
    
    $institucion_Nombre = "";
    $director_Institucional = "";
    $coordinador_Comite = "";
    $comite_Nutricion = "";
                             
    $db = new Select();

    $rsParametros = $db->conParametros();
    if(!empty($rsParametros)) {
        foreach($rsParametros as $rsItemParametros) {
            $institucion_Nombre = $rsItemParametros["institucion_Nombre"];
            $director_Institucional = $rsItemParametros["director_Institucional"];
            $coordinador_Comite = $rsItemParametros["coordinador_Comite"];
            $comite_Nutricion = $rsItemParametros["comite_Nutricion"];
        }
    }
                  
} catch (PDOException $e) {		
	echo "Error al conectar con la base de datos: " . $e->getMessage() . "\n";
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/css_estudianteMantenimiento.css?<?php echo rand(1000,9999)?>">
    <script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>    
    <title>Parámetros</title>
       
</head>
<body>
   
    <div id="mainArea">
        <div id="menu">
            <a id="salir" class="menuBoton" href="reporte_almuerzo.php"></a>            
        </div>
        <div id="tabla">           
            <div id="fila">
                <div id="Col1">Institución Nombre:</div>
                <div id="Col2">
                    <input type="text" id="txtNombre" class="txtDescripcion" maxlength="255" value="<?php echo $institucion_Nombre;?>">
                </div>
            </div>            
             <div id="fila">
                <div id="Col1">Director Institucional:</div>
                <div id="Col2">
                    <input type="text" id="director_Institucional" class="txtDescripcion" maxlength="255" value="<?php echo $director_Institucional;?>">
                </div>
            </div>    
            <div id="fila">
                <div id="Col1">Coordinador Comité:</div>
                <div id="Col2">
                    <input type="text" id="coordinador_Comite" class="txtDescripcion" maxlength="255" value="<?php echo $coordinador_Comite;?>">
                </div>
            </div>
            <div id="fila">
                <div id="Col1">Comite Nutrición:</div>
                <div id="Col2"> <input type="text" id="comite_Nutricion" class="txtDescripcion" maxlength="255" value="<?php echo $comite_Nutricion;?>">                    
                </div>
            </div>                
                                        
        </div>
               
        <div id="tabla">
            <div id="fila">
                <div id="guardar" onclick="guardar()"></div>
            </div>
        </div>
    </div>    
    <div id="statusBar">
        <a id="linkHogar" href="https://www.lasesperanzas.ed.cr">lasesperanzas.ed.cr</a>
        <a id="linkWappcom" href="https://www.wappcom.net">wappcom.net</a>                                         
    </div>

<script>

    var parametros_Id = 1; //Solo deberia existir un registro den la tabla parametros
    
    function guardar() {

                
        var institucion_Nombre = $('#txtNombre').val();
        var director_Institucional = $('#director_Institucional').val();
        var coordinador_Comite = $('#coordinador_Comite').val();
        var comite_Nutricion = $('#comite_Nutricion').val();
        
        if (parametros_Id==0){            
           //No hay insert
            } else	{                                
                $('#guardar').html('<img src="img/cargando.gif">');
                $.post("sql/updateParametrosGestor.php", {parametros_Id: parametros_Id, 
                    institucion_Nombre: institucion_Nombre,
                    director_Institucional: director_Institucional, 
                    coordinador_Comite: coordinador_Comite, comite_Nutricion: comite_Nutricion})
                .done(function(data) {	    		                                                         
                    $('#guardar').html('<img src="img/guardar.png">');	    		
                }).fail(function(jqXHR, textStatus, error) {
                console.log("Error de la aplicación: " + error);    			
                $(body).append("Error al conectar con la base de datos: " + error);                			
                });			
        }

    }
            
    $('#salir').html('<img src="img/salir.png">'); 
    $('#guardar').html('<img src="img/guardar.png">');        

</script>
</body>
</html>