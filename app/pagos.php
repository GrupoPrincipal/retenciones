<?php
include("core/lib/core_lib.php");
?>
<section class="content-header">
  <h1>Pagos<small>Listado de pagos</small></h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-money"></i> Pagos</a></li>
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
            <form action="#" class="form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Fecha:</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input id="fechas"  class="form-control"  name="fechas">
                                <span class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                            <input type="hidden" name="fech_a" >
                            <input type="hidden" name="fech_b" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Cliente:</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                
                                <input type="email" class="form-control" placeholder="clientes">
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
                            <button type="button" class="btn default">Limpiar</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
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
             maxDate: 0
         }
     });
});
</script>

<section class="col-lg-7 body content-body ">
    
</section>
