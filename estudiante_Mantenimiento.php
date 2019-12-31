<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);
ini_set('display_errors', false);
/**
* Mauricio Bermudez Vargas 28/12/2019 10:30 p.m.
*/
try {
    require_once("sql/select.php");
    
    $estudiante_Id=0;
    $estudiante_Cedula="";
    $estudiante_Nombre="";
    $estudiante_PrimerApellido="";
    $estudiante_SegundoApellido="";    
    $estudiante_Seccion="";
                             
    if (isset($_GET['estudiante'])) {
        
        $estudiante_Id = $_GET['estudiante'];
        $db = new Select();
        $rsEstudiante = $db->conEstudiante($estudiante_Id);        
        if (!empty($rsEstudiante)) {                                       
            foreach ($rsEstudiante as $key => $value) {                
                $estudiante_Cedula = $value['Estudiante_Cedula'];
                $estudiante_Nombre = $value['Estudiante_Nombre'];
                $estudiante_PrimerApellido = $value['Estudiante_Apellido1'];
                $estudiante_SegundoApellido = $value['estudiante_Apellido2'];
                $estudiante_Seccion = $value['Estudiante_Seccion'];                                      
            }                                            
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
    <link rel="stylesheet" type="text/css" href="css/css_estudianteMantenimiento.css">
    <script type="text/javascript" src="jq/jquery-3.2.1.min.js"></script>    
    <title>Estudiante</title>
       
</head>
<body>
   
    <div id="mainArea">
        <div id="menu">
            <a id="salir" href="seleccion.php"></a>
        </div>
        <div id="tabla">
           
            <div id="fila">
                <div id="Col1">Nombre:</div>
                <div id="Col2">
                    <input type="text" id="txtNombre" class="txtDescripcion" maxlength="50" value="<?php echo $estudiante_Nombre;?>">
                </div>
            </div>            
             <div id="fila">
                <div id="Col1">Primer Apellido:</div>
                <div id="Col2">
                    <input type="text" id="txtApellido1" class="txtDescripcion" maxlength="50" value="<?php echo $estudiante_PrimerApellido;?>">
                </div>
            </div>    
            <div id="fila">
                <div id="Col1">Segundo Apellido:</div>
                <div id="Col2">
                    <input type="text" id="txtApellido2" class="txtDescripcion" maxlength="50" value="<?php echo $estudiante_SegundoApellido;?>">
                </div>
            </div>
            <div id="fila">
                <div id="Col1">Cédula:</div>
                <div id="Col2">                    
                    <input type="text" id="txtCedula" class="txtDescripcion" maxlength="50" value="<?php echo $estudiante_Cedula;?>">                    
                </div>
            </div>     
            <div id="fila">
                <div id="Col1">Sección:</div>
                <div id="Col2">                    
                    <input type="text" id="txtSeccion" class="txtDescripcion" maxlength="4" value="<?php echo $estudiante_Seccion;?>">                    
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

    var estudiante_Id = <?php echo $estudiante_Id;?>;
    
    function guardar() {

                
        var estudiante_Cedula = $('#txtCedula').val();
        var estudiante_Nombre = $('#txtNombre').val();
        var estudiante_PrimerApellido = $('#txtApellido1').val();
        var estudiante_SegundoApellido = $('#txtApellido2').val();
        var estudiante_Seccion = $('#txtSeccion').val();        

        if (estudiante_Id==0){
            $('#guardar').html('<img src="img/cargando.gif">');	
            $.post("sql/insertEstudianteGestor.php", {estudiante_Cedula: estudiante_Cedula,
                estudiante_Nombre: estudiante_Nombre, estudiante_PrimerApellido: estudiante_PrimerApellido, estudiante_SegundoApellido: estudiante_SegundoApellido,
                estudiante_Seccion: estudiante_Seccion})
                .done(function(data) {                                           							                         
                    $('#guardar').html('<img src="img/guardar.png">');                    
                }).fail(function(jqXHR, textStatus, error) {
                    console.log("Error de la aplicación: " + error);    			
                    $(body).append("Error al conectar con la base de datos: " + error);			
                });	                
            } else	{                
                $('#guardar').html('<img src="img/cargando.gif">');
                $.post("sql/updateTrabajadorGestor.php", {trabajador_Id: trabajador_Id, puesto_Id: puesto_Id, trabajador_Cedula: trabajador_Cedula,
                trabajador_Nombre: trabajador_Nombre, trabajador_PrimerApellido: trabajador_PrimerApellido, trabajador_SegundoApellido: trabajador_SegundoApellido,
                trabajador_Activo: trabajador_Activo, trabajador_Salario: trabajador_Salario, trabajador_Email: trabajador_Email})
                .done(function(data) {	    		                                                         
                    $('#guardar').html('<img src="img/guardar.png">');	    		
                }).fail(function(jqXHR, textStatus, error) {
                console.log("Error de la aplicación: " + error);    			
                $(body).append("Error al conectar con la base de datos: " + error);                			
                });			
        }

    }
    
    $(document).ready(function() {
            
        $('#txtSalario').inputmask({
            'alias': 'decimal',
            rightAlign: true,
            'groupSeparator': '.',
            'autoGroup': true
        });           
                       
    });
        
    $('#salir').html('<img src="img/salir.png">'); 
    $('#guardar').html('<img src="img/guardar.png">');
    $('#add').html('<img src="img/add.png">');
    $('#modificar').html('<img src="img/menu.png">');

    $("#cbox1").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
        if (trabajador_Activo == 0) {
            trabajador_Activo=1;
        } else {
            trabajador_Activo=0;
        }       
    });

</script>
</body>
</html>