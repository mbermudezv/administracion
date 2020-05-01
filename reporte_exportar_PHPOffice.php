<?php

ini_set('display_errors', false);
require_once("sql/select.php");

require __DIR__ . "/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (isset($_GET['fechaDesde']) and isset($_GET['fechaHasta']) and isset($_GET['clienteId'])) {
	$getfecDesde = $_GET['fechaDesde'];
	$getfecHasta = $_GET['fechaHasta'];
	$getCliente = $_GET['clienteId'];	
	$db = new Select();
	$rs = $db->conReporteCuentaCliente($getCliente,$getfecDesde,$getfecHasta);
    $rsCliente = $db->conClienteNombre($getCliente);
}

if(!empty($rsCliente)) {
    foreach($rsCliente as $rsItemCliente) {
        $nombrecompleto = $rsItemCliente["Cliente_Nombre"] . ' ' . $rsItemCliente["Cliente_Apellido1"] . ' ' . $rsItemCliente["Cliente_Apellido2"];
    }
    $rsCliente=null;
}

$titulo = "Informe estado de cuenta almuerzos";
$documento = new Spreadsheet();
$nombreDelDocumento = "Programación de Actividades.xlsx";    
$hoja = $documento->getActiveSheet();
$hoja->setTitle("Nombre Regional");

//Imagen Logo
$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawing->setName('Mep');
$drawing->setDescription('Mep');
$drawing->setPath('mep.png');
$drawing->setCoordinates('A1');
$drawing->setWidthAndHeight(110, 110);
$drawing->setWorksheet($documento->getActiveSheet());

// Titulo
$hoja->setCellValueByColumnAndRow(2, 1, $titulo);
$hoja->getStyle('B1')->getFont()->setBold(true);
$hoja->getRowDimension(1)->setRowHeight(100);
$hoja->getStyle('B1:D1')->getAlignment()->setWrapText(true); 
$hoja->mergeCells('B1:D1');
$hoja->getStyle('B1:D1')->getAlignment()->setHorizontal('center');

//Hancho de columnas
$hoja->getColumnDimension('A')->setWidth(30);
$hoja->getColumnDimension('B')->setWidth(30);
$hoja->getColumnDimension('C')->setWidth(30);
$hoja->getColumnDimension('D')->setWidth(30);

// Fila Nombre
$hoja->setCellValueByColumnAndRow(1, 6, "Nombre");
$hoja->setCellValueByColumnAndRow(2, 6, $nombrecompleto);

//Fecha
$hoja->setCellValueByColumnAndRow(1, 7, "Desde");
$hoja->setCellValueByColumnAndRow(2, 7, $getfecDesde);

$hoja->setCellValueByColumnAndRow(3, 7, "Hasta");
$hoja->setCellValueByColumnAndRow(4, 7, $getfecHasta);

//titulo
$hoja->setCellValueByColumnAndRow(8, 1, "Fecha");
$hoja->setCellValueByColumnAndRow(8, 2, "Monto");

$fila=9;

        if(!empty($rs)) {
        foreach($rs as $rsCliente) {
        $total = $total + $rsCliente["Monto"];
        ?>
        <tr>
            <td> <?php echo $rsCliente["Fecha"]; ?> </td>
            <td> <?php echo $rsCliente["Monto"]; ?> </td>
        </tr>
        <?php
        }
        }
        $rs = null;
        $db = null;
        ?>    
        <tr>
            <td>Total:</td>
            <td><?php echo $total; ?></td>
        </tr>
        <tr>
            <td>-------------------------</td>
            <td>-------------------------</td>
        </tr>
        <tr>
            <td> <?php echo $nombrecompleto; ?></td>
            <td> <?php echo "Comité de nutrición"; ?></td>
        </tr>
    
    </table>

</div> <!-- Container Email -->

<script language='javascript'>

var tipoExport = <?php echo $_GET['t']; ?>;

if (tipoExport == 3) {    
    enviar();
}

function enviar() {

        var email =  <?php echo "'". $correo ."'"; ?>;
        var contenido = document.getElementsByTagName("body");        
        var contenidojs = "<html>"+contenido[0].outerHTML+"</html>"                    
        var params = "email="+encodeURIComponent(email)+"&body="+encodeURIComponent(contenidojs);        

        var xhr=new XMLHttpRequest();
        xhr.open('POST','https://www.wappcom.net/comedor/email_comprobante.php',true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");            
        if (xhr.status == 200) {
            console.log("Enviado ..");
            } else {
                console.log("Error " + xhr.status + " al enviar email");
            }    
        xhr.send(params);
    }    
</script>
</body>
</html>