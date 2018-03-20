<?php
include("core/lib/core_lib.php");
include("core/lib/class/clientes.class.php");

$Obj_clients=new Clientes;
$clientes=$Obj_clients->get_clientes();
?>
<section class="content-header">
  <h1>Pedidos<small>Listado de pedidos</small></h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-money"></i> Pedidos</a></li>
    <li class="active">lista</li>
  </ol>
</section>
<br><br>
<div class="row">
    <div class="col-lg-12 ">
      <div class="portlet box blue-hoki">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Filtrar poor: </div>
        </div>
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="#" class="form-horizontal" id='filtrar'>
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Fecha:</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input id="fechas"  class="form-control"  name="fechas" onchange="up_fechas(this)">
                                <span class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="hidden" name="fech_a" id="fech_a" >
                            <input type="hidden" name="fech_b" id="fech_b" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Clientes:</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                
                                <select class="form-control" id='clients' name='clients'>
                                    <option value=''></option>
                                    <?php
                                    for($i=0;$i<count($clientes);$i++){
                                    ?>
                                    <option value='<?php echo $clientes[$i]['cli_codigo'] ?>'><?php echo $clientes[$i]['cli_nombre'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="input-group-addon">
                                    <i class="fa fa-users"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions fluid">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">Filtrar</button>
                            <a class="btn default">Limpiar</a>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>

  </div>
</div>
<script>
$(function() {
    $("#fechas").daterangepicker({
          presetRanges: [{
             text: 'Hoy',
             dateStart: function() { return moment() },
             dateEnd: function() { return moment() }
         }, {
             text: 'Semana actual',
             dateStart: function() { return moment().startOf('week') },
             dateEnd: function() { return moment().endOf('week') }
         }, {
             text: 'Semana anterior',
             dateStart: function() { return moment().add('weeks', -1).startOf('week') },
             dateEnd: function() { return moment().add('week',-1).endOf('week')  }
         }, {
             text: 'Mes actual',
             dateStart: function() { return moment().startOf('month')},
             dateEnd: function() { return moment()  }
         }, {
             text: 'Mes anterior',
             dateStart: function() { return moment().add('month', -1).startOf('month')},
             dateEnd: function() { return moment().add('month', -1).endOf('month')  }
         }],
         applyOnMenuSelect: false,
         datepickerOptions: {
             minDate: null,
             maxDate: 0,
             numberOfMonths : 2
         }
     });
    
  $('#clients').select2({
      theme: "classic",
      placeholder:"Cliente"
  });
    
    $('#filtrar').submit(function(){
        $('.sec-cont').html("<center><img src='styles/images/cargando.gif' width='60px'></center>");
        setTimeout(function(){ }, 3000000);
        var start=$('#fech_a').val();
        var end=$('#fech_b').val();
        var clients=$('#clients').val();
        var datos="ini="+start+"&fin="+end+'&cli='+clients;
        $('.sec-cont').load('app/pedidos_async.php?type=filtrar&'+datos);
        return false;
    })
    
});
    
function up_fechas(element){
    var fechas=jQuery.parseJSON($(element).val());
    var start=fechas.start;
    var end=fechas.end;
    $('#fech_a').val(start);
    $('#fech_b').val(end);
}
</script>

<div class="row">
    <section class="col-lg-12 connectedSortable sec-cont">
        <?php
        $var=(1 > 2 and 3 < 1);
        if($var){
            echo "esta validando si la variable es true o false";
        }else{
            echo "valido el contenido de la variable";
        }
        ?>
    </section>
</div>
