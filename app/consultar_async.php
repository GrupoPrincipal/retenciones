<?php
require("../core/config_var.php");
include("../metodoswebservices.php");
if($_GET['type']=='lista' ){
    $pro=$_SESSION['user_gdp']['login'];
    $retenciones=get_retencion_iva($pro);
    $retenciones=json_decode($retenciones,JSON_UNESCAPED_UNICODE);
   // print_r($retenciones[0]);
?>
<div class="col-md-12" style="    background: #fff;
    padding: 19px;
    box-sizing: border-box;
    margin-bottom: 50px;
    margin-top: 19px;
    box-shadow: 6px 6px 35px #428bca;">
            
        
        <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Factura</th>
                <th>Fecha del documento</th>
                <th>Monto</th>
                <th>Base imponible</th>
                <th>Alicuota</th>
                <th>Impuesto causado</th>
                <th>Retencion</th>
                <th>IVA</th>
                <th>ISLR</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($retenciones as $ret){
               ?>
                    <tr>
                        <td><?php echo $ret['NUMLEGAL']; ?></td>
                        <td><?php echo $ret['FORIEMI']; ?></td>
                        <td><?php echo $ret['MONTO']; ?></td>
                        <td><?php echo $ret['BASE']; ?></td>
                        <td><?php echo $ret['ALIC']; ?></td>
                        <td><?php echo $ret['IVA']; ?></td>
                        <td><?php echo $ret['RET']; ?></td>
                        <td><a class='fa fa-eye ifancybox' href="app/consultar_async.php?type=iva&prov=<?php echo $pro; ?>&id=<?php echo $ret['NUMLEGAL']; ?>" title="Retencion de iva">  </a></td>
                        <td><?php if($ret['ISLR']=='1'){ ?><a class='fa fa-eye ifancybox' href="app/consultar_async.php?type=islr&prov=<?php echo $pro; ?>&suc=<?php echo $dir; ?>&id=<?php echo $ret['NUMLEGAL']; ?>" title="Retencion de islr">  </a><?php } ?></td>
                    </tr>
                <?php
            }
            ?>

        </tbody>
    </table>
        <h5 style='color:#ff5806'><strong><i class="fa fa-exclamation-triangle" aria-hidden="true" > </i> ¡Advertencia!</strong> En caso que su retencion no se encuentre notifique a administracion.sc@gdp.com.ve</h5>
    </div>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "language": {
            "search": "Buscar:",
            "LengthMenu": "Mostrar _MENU_ registros",
            "lengthMenu": 'Mostrar <select>'+
			             '<option value="10">10</option>'+
			             '<option value="20">20</option>'+
			             '<option value="-1">Todos</option>'+
			             '</select> registros',
            "zeroRecords": "<h5 style='color:#ff5806'><strong><i class='fa fa-exclamation-triangle' aria-hidden='true' > </i> ¡Advertencia!</strong> En caso que su retencion no se encuentre notifique a administracion.sc@gdp.com.ve</h5>",
            "info": "Mostrar _PAGE_ de _PAGES_",
            "infoEmpty": "Registro no encontrado",
            "infoFiltered": "",
            "loadingRecords": "Cargando...",
            "Processing": "Procesando...",
            "paginate":{
                "sFirst": "Primero",
                "sLast": "Ultimo",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            }
        }
    } );
    
    $(".ifancybox").fancybox({
		 'width' : '75%',
		 'height' : '75%',
		 'autoScale' : false,
		 'transitionIn' : 'none',
		 'transitionOut' : 'none',
		 'type' : 'iframe'
	 });
});
</script>

<?php
}if($_GET['type']=='iva' ){
    $fac=$_GET['id'];
    $pro=$_SESSION['user_gdp']['login'];
try {
    
    $retenciones=get_retencion_iva($pro,$fac);
    $sucursal=get_sucursal();
    
   $retencion=json_decode($retenciones,JSON_UNESCAPED_UNICODE);
    $sucursal=json_decode($sucursal,JSON_UNESCAPED_UNICODE);
    $ret=$retencion[0];
    $suc=$sucursal[0];
    $num=$ret['nume'];
    
    $base=0;
    $iva=0;
    $re=0;
    $mon=0;
    $emi=explode(' ',$ret['FORILLE']);
    ob_start();
    ?>
    <page backcolor="#FEFEFE" backimg="" backimgx="center" backimgy="bottom" backimgw="90%" backtop="0" backbottom="30mm" style="font-size: 12pt">
<page_header>

<table style=" text-align: center; font-size: 10pt;">
    <tr>
    <td  ><h3>COMPROBANTE DE RETENCIÓN DEL IMPUESTO AL VALOR AGREGADO</h3></td>
    </tr>
    <tr>
    <td   style="width:100%;">
        <table style="width:1740px">
            <tr>
                <td style="width: 25%;text-align: justify;font-size: 11px;padding-right: 15%;">LEY IVA ART.11 "Seran responsables del pago del impuesto en calidad de agentes de retencion
                    los compradores o adquirientes de determinados bienes muebles y los receptores de ciertos 
                    servicios a quienes laAdministracion Tributaria designe como tal."</td>
                <td  style="width:5%;">&nbsp;</td>
                <td style="    width: 12%;border: solid;border-width: 1px;text-align: center;border-radius: 10px;"><b>Comprobante No: <br><?php echo  $num; ?></b></td>
                <td style="width:3%"> &nbsp;</td>
                <td  style="    border: solid;border-width: 1px;border-radius: 10px;padding: 10px;text-align: center;">
                    <table>
                        <tr><td><b>Fecha de Emision:</b></td><td><b><?php echo date("d/m/Y",strtotime($emi[0])); ?></b></td></tr>
                    </table>
                </td>
            </tr>
        </table> 
    </td>
    
    </tr>
</table>
</page_header>
   <page_footer>
<table cellspacing="0" style="width: 1740px;">
    <tr>
       <td style="width:3%;"> &nbsp;</td>
        <td style="width:12%; text-align: center;">
           <br>
           <br>
           <br>
            <hr>
            Recibi conforme
        </td>
        <td style="width:29%;"> &nbsp;</td>
        <td style="width:12%; text-align: center;">
            <img src="../styles/images/sello-LG.png" style="width:200px">
            <hr>
            Firma y sello 
        </td>
    </tr>    
</table>       
</page_footer>
    
  <br><br><br><br><br><br><br><br>
<table style="width: 138px;">
    <tr>
    <td  style="width:50%">
            <table cellspacing="0" style="width: 50%;border: solid;border-width: 1px;border-radius: 10px;padding: 5px;">
        <tr>
            <td style=""><b>Distribuidor(Agente de Retención):</b></td>
            <td style=""><b>Rif(Agente de Retención):</b></td>
        </tr>
        <tr>
        <td><?php echo $suc['NOMBALMA']; ?></td>
        <td><?php echo $suc['RIF']; ?></td>
        </tr>
        <tr>
        <td>Direccion (Agente de Retención): </td>
        <td></td>
        </tr>
        <tr>
        <td><?php echo $suc['DIRECCION1'].', '.$suc['DIRECCION2']; ?></td>
        <td></td>
        </tr>
        <tr>
        <td><?php echo $suc['CIUDAD'].' &nbsp; &nbsp; &nbsp; '.$suc['ESTADO']; ?></td>
        <td></td>
        </tr>
    </table>
    </td>
    <td  style="width:20%;">
        <table style=" border: solid;border-width: 1px;border-radius: 10px;padding: 10px;text-align: center;">
            <tr>
                <td><b>Periodo Fiscal:<br>  Año: <?php echo substr($num,0,4) ?> /  Mes: <?php echo substr($num,4,2) ?> </b></td>
            </tr>
        </table>
    </td>
    </tr>
    <tr>
    <td   style="width:100%;">
        <table cellspacing="0" style="width: 100%;border-radius: 10px;border:solid;border-width:1px;padding: 5px;">
            <tr>
                <td style="width:610px;">Nombre o razón social del sujeto de retención:</td>
                <td style="">Rif del sujeto de retención:</td>
            </tr>
            <tr>
                <td  style="width:610px;" ><?php echo $ret['CODIPROV']." ".$ret['NOMBRE']; ?></td>
                <td><?php echo $ret['RIF']; ?></td>
            </tr>
        </table>  
    </td>
    <td  style="width:20%; ">
        <table style="width:100%;text-align: center; border-radius:5px; border:solid; border-width:1px;">
            <tr><td style="width:80%">% Retenido:</td></tr>
            <tr><td><?php echo trim($ret['p']); ?>%</td></tr>
        </table>
    </td>
    </tr>
    
</table>
<table cellspacing="0" style="width: 1740px;border-width:1px; text-align: center; font-size: 10pt;">
<tr>
    <td style="border:solid; border-width:1px; font-size:10px; width:15px;" >N°</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:60px;" >Fecha de la factura</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($retencion[0]['NUMLEGAL'])*8; ?>px;" >N° de factura</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($retencion[0]['CONTROL'])*8; ?>px;" >N° de Control</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php if($ret['TIPO']=='ND'){ strlen($retencion[0]['NUMLEGAL'])*8; }else{ echo "60"; } ?>px;" >N° (Nota Débit)</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php if($ret['TIPO']=='NC'){ strlen($retencion[0]['NUMLEGAL'])*8; }else{ echo "60"; } ?>px;" >N° (Nota Crdto)</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:25px;" >Tipo Tran</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($retencion[0]['LEGALAFE'])*8; ?>px;" >N° Fact Afectada</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($retencion[0]['MONTO'])*7; ?>px;" >Monto Total</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:50px;" >Compras Sin derecho a credito fiscal</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($retencion[0]['BASE'])*7; ?>px;" >Base Imponible</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:20px;" >% Alic</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($retencion[0]['IVA'])*7; ?>px;" >Impuesto IVA</td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($retencion[0]['RET'])*7; ?>px;" >IVA Retenido</td>
</tr>

    <?php
    $i=1;
    foreach($retencion as $rete){
            $base+=$rete['BASE'];
            $iva+=$rete['IVA'];
            $re+=$rete['RET'];
            $mon+=$rete['MONTO'];
        $fe=explode(' ',$rete['FORIEMI']);
    ?>
<tr>
    <td style="border:solid; border-width:1px; font-size:10px; width:15px; "><?php echo  $i; ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:60px; "><?php echo  date("d/m/Y",strtotime($fe[0])); ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($rete['NUMLEGAL'])*8; ?>px;"><?php echo $rete['NUMLEGAL']; ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($rete['CONTROL'])*8; ?>px; "><?php echo $rete['CONTROL']; ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php if($ret['TIPO']=='ND'){ strlen($retencion[0]['NUMLEGAL'])*8; }else{ echo "60"; } ?>px; "><?php if($ret['TIPO']=='ND'){ echo $rete['NUMLEGAL']; } ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php if($ret['TIPO']=='NC'){ strlen($retencion[0]['NUMLEGAL'])*8; }else{ echo "60"; } ?>px; "><?php if($ret['TIPO']=='NC'){ echo $rete['NUMLEGAL']; } ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:25px; "><?php if($ret['TIPO']=='NC'){ echo "02"; }else{ echo "01"; } ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($rete['LEGALAFE'])*8; ?>px; "><?php if($rete['TIPO']!='FP'){ echo $rete['LEGALAFE']; } ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($rete['MONTO'])*7; ?>px; "><?php echo number_format($rete['MONTO'], 2, '.', ','); ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:50px; "><?php echo $rete['EXENTO']; ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($retencion[0]['BASE'])*7; ?>px; "><?php echo number_format($rete['BASE'], 2, '.', ','); ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:20px; "><?php echo $rete['ALIC']; ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($rete['IVA'])*7; ?>px; "><?php echo number_format($rete['IVA'], 2, '.', ','); ?></td>
    <td style="border:solid; border-width:1px; font-size:10px; width:<?php echo strlen($rete['RET'])*7; ?>px; "><?php echo number_format($rete['RET'], 2, '.', ','); ?></td>
</tr>
    <?php
        $i++;
}
?>
<tr>
    <td colspan="8" style="font-size:11px;  ">&nbsp;</td>
    <td style="border:solid; border-width:1px; font-size:10px;  "><?php echo number_format($mon, 2, '.', ','); ?></td>
    <td style="border:solid; border-width:1px; font-size:10px;  "> </td>
    <td style="border:solid; border-width:1px; font-size:10px;  "><?php echo number_format($base, 2, '.', ','); ?></td>
    <td style="border:solid; border-width:1px; font-size:10px;  "></td>
    <td style="border:solid; border-width:1px; font-size:10px;  "><?php echo number_format($iva, 2, '.', ','); ?></td>
    <td style="border:solid; border-width:1px; font-size:10px;  "><?php echo number_format($re, 2, '.', ','); ?></td>
</tr>
</table>
<div style="text-align: right; font-size:12px">
    Total a pagar: &nbsp; <?php echo number_format($ret['TOTAL'], 2, '.', ',');  ?>
</div>

</page>
    
    
<?php
    
$html = ob_get_clean();
if(file_exists('../core/lib/html2pdf/html2pdf.class.php')){
        require_once('../core/lib/html2pdf/html2pdf.class.php');
    }else{
        die("ERROR AL CARGAR PDF");
    }   
    try{
        $html2pdf = new HTML2PDF('L', 'letter', 'es');
        $html2pdf->pdf->SetAuthor('Author');
    $html2pdf->pdf->SetTitle('Retención de iva de la factura '.$fac);
        $html2pdf->writeHTML($html);
        $html2pdf->Output('retencion.pdf');
    }catch(HTML2PDF_exception $e) {
            echo $e;
        exit;
    }
    
    
    
    
}catch(Exception $e) {
  ?>
  <h3>En estos momentos presentamos problemas para vizualizar tu retencion de iva </h3>
  <a href="https://sistemalg.gdp.com.ve/soap_app/reportes/retencion_iva.php?fac=<?php echo $fac; ?>&prov=<?php echo $pro; ?>">Haz click aqui para descargar automatiamente</a>
  <h4>Esto puede durar varios minutos</h4>
  <?php    
    }
}if($_GET['type']=='islr'){
    
     $fac=$_GET['id'];
    $pro=$_SESSION['user_gdp']['login'];
    
    $sucursal=get_sucursal();
    
    $sucursal=json_decode($sucursal,JSON_UNESCAPED_UNICODE);
    $islr=get_retencion_islr($pro,$fac);
    $islr=json_decode($islr,JSON_UNESCAPED_UNICODE);
    $suc=$sucursal[0];
    $slr=$islr[0];
    
ob_start();

?>

<page backcolor="#FEFEFE" backimg="" backimgx="center" backimgy="bottom" backimgw="90%" backtop="0" backbottom="30mm" style="font-size: 12pt">


<page_footer>
<table cellspacing="0" style="width: 1740px;">
    <tr>
       <td style="width:3%;"> &nbsp;</td>
        <td style="width:12%; text-align: center;">
           <br>
           <br>
           <br>
            <hr>
            Recibi conforme
        </td>
        <td style="width:29%;"> &nbsp;</td>
        <td style="width:12%; text-align: center;">
            <img src="../styles/images/sello-LG.png" style="width:200px">
            <hr>
            Firma y sello 
        </td>
    </tr>    
</table>       
</page_footer>

<table>
    <tr>
    <td  style="width: 820px;">
        <table cellspacing="0" style="width: 138px;border: solid;border-width: 1px;border-radius: 10px;padding: 5px;">
            <tr>
            <td style=""><b>Distribuidor(Agente de Retención):</b></td>
            <td style="width: 210px;"><b>Rif(Agente de Retención):</b></td>
            </tr>
            <tr>
            <td style="width: 610px;"><?php echo $suc['NOMBALMA']; ?></td>
            <td style="width: 210px;"><?php echo $suc['RIF']; ?></td>
            </tr>
            <tr>
            <td style="width: 610px;">Direccion (Agente de Retención): </td>
            <td></td>
            </tr>
            <tr>
            <td  style="width: 610px;"><?php echo $suc['DIRECCION1'].', '.$suc['DIRECCION2']; ?></td>
            <td></td>
            </tr>
            <tr>
            <td style="width: 610px;"><?php echo $suc['CIUDAD'].' &nbsp; &nbsp; &nbsp; '.$suc['ESTADO']; ?></td>
            <td></td>
            </tr>
        </table>
    </td>
    <td>
    </td>
    </tr>
    <tr>
        <td colspan="2">
            <table>
                <tr>
                    <th style="width: 700px;"><h3>COMPROBANTE DE RETENCIÓN DEL IMPUESTO SOBRE LA RENTA</h3></th>
                    <td  style="width: 220px;">
                        <table style="border-radius: 5px;border:solid;border-width:1px;padding: 2px;">
                            <tr>
                                <td style="width:120px;">Fecha Emision:</td><td style="width:100px;"><?php $for=explode(' ',$slr['FORILLE']); echo date("d/m/Y",strtotime($for[0])); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <tr>
    <td   style="width: 820px;">
      <b>DATOS DEL BENEFICIARIO</b>
        <table cellspacing="0" style="width: 1380px;border-radius: 10px;border:solid;border-width:1px;padding: 5px;">
            <tr><td  style=""><b>Razón social:</b></td><td style="width: 650px;"><?php echo $slr['NOMBRE'] ?></td></tr>
            <tr><td  style=""><b>Rif:</b></td><td style="width: 650px;"><?php echo $slr['RIF'] ?></td></tr>
            <tr><td><b>Direccion:</b></td><td style="width: 650px;"><?php echo $slr['DIRECCION1'].', '.$slr['DIRECCION2']; ?></td></tr>
            <tr><td><b>Telefono:</b></td><td style="width: 650px;"><?php echo $slr['TELEFONO'] ?></td></tr>
            <tr><td><b>Causa de Retencion:</b></td><td style="width: 650px;"><?php echo $slr['CODIRETE'] ?>&nbsp; <?php echo $slr['DESCRIPCION'] ?></td></tr>
        </table>  
    </td>
    <td></td>
    </tr>
    
</table>
<table style="text-align: center; font-size: 10pt;" >
    <tr>
        <th style="width:1005px;"><h3>IMPUESTO RETENIDO Y ENTERADO</h3></th>
    </tr>
</table>
<table cellspacing="0" style="width: 1740px;border-width:1px; text-align: center; font-size: 10pt;">
<tr>
    <td style="border:solid; border-width:1px; font-size:11px; width:10px " >N°</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:50px " >Fecha de la factura</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:140px " >N° de factura</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:55px " >N° de Control</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:20px " >Codi. ret.</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:90px " >Total compras incluyendo iva</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:70px " >Compras sin derecho a crédito iva</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:80px " >Base imponible</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:15px " >% Alic</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:60px " >Impuesto IVA</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:15px " >% Ret. Iva.</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:70px " >IVA Retenido</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:70px " >Base de Ret. I.S.L.R.</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:15px " >% Ret Islr</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:60px " >Ret de I.S.L.R.</td>
    <td style="border:solid; border-width:1px; font-size:11px; width:65px " >Sustraendo</td>
</tr>

<?php
    $i=1;
 foreach($islr as $rete){
    $fe=explode(' ',$rete['FORIEMI']);
    $sdcf+=$rete['MONTEXEN'];
    $ret+=$rete['RET'];
    $total+=$rete['TOTAL']+$rete['RETENIDO'];
    $base+=$rete['MONTO'];
    $imp+=$rete['IMPUESTO'];
    $sust+=$rete['SUSTRAEN'];
     $rtn+=$rete['RETENIDO'];
    $pagar+=$rete['ABONOS'];
?><tr>
    <td style="border:solid; border-width:1px; font-size:11px;  width:10px "><?php echo  $i; ?></td>
    <td style="border:solid; border-width:1px; font-size:11px;  width:50px "><?php echo  date("d/m/Y",strtotime($fe[0])); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:135px "><?php echo $rete['NUMLEGAL']; ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:55px "><?php echo $rete['CONTROL']; ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:20px "><?php echo $rete['CODIRETE']; ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:90px "><?php echo number_format($rete['TOTAL']+$rete['RETENIDO'], 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:70px "><?php echo number_format($rete['MONTEXEN'], 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:78px "><?php echo number_format($rete['MONTO'], 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:20px "><?php echo $rete['IMPU1']; ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:60px "><?php echo number_format($rete['IMPUESTO'], 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:20px "><?php echo $rete['PORRETVE']; ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:70px "><?php echo number_format($rete['RET'], 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:70px "><?php echo number_format($rete['MONTO'], 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:20px "><?php echo $rete['PORCRETE']; ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:60px "><?php echo number_format($rete['RETENIDO'], 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:65px "><?php echo number_format($rete['SUSTRAEN'], 2, '.', ','); ?></td>
    </tr>
<?php
     $i++;
}    
?>
<tr>
    <td colspan='5'></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:90px "><?php echo number_format($total, 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:70px "><?php echo number_format($sdcf, 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:80px "><?php echo number_format($base, 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:15px "></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:60px "><?php echo number_format($imp, 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:15px "></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:70px "><?php echo number_format($ret, 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:70px "><?php echo number_format($base, 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:15px "></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:60px "><?php echo number_format($rtn, 2, '.', ','); ?></td>
    <td  style="border:solid; border-width:1px; font-size:11px; width:65px "><?php echo number_format($sust, 2, '.', ','); ?></td>
    </tr>
</table>
<div style="text-align: right; font-size:12px">
    Saldo a pagar: &nbsp; <?php echo number_format($pagar, 2, '.', ',');  ?>
</div>
<div style="text-align: right; font-size:12px">
</div>

</page>
   <?php
    
    
    $html = ob_get_clean();
if(file_exists('../core/lib/html2pdf/html2pdf.class.php')){
        require_once('../core/lib/html2pdf/html2pdf.class.php');
    }else{
        die("ERROR AL CARGAR PDF");
    }   
    try{
        $html2pdf = new HTML2PDF('L', 'letter', 'es');
        $html2pdf->pdf->SetTitle('Retención de islr de la factura '.$fac);
        $html2pdf->writeHTML($html);
        $html2pdf->Output('retencion.pdf');
    }catch(HTML2PDF_exception $e) {
            echo $e;
        exit;
    }
}
?>


