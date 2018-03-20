<?php
require("../core/config_var.php");
?>
<?php
include("../core/lib/class/rutas.class.php");
$Obj_rutas=new Rutas;
if($_GET['type']=='inicio'){
    if($_SESSION["GdpUserpedidos"]['ruta']<=0 ){
?>
<div class="nav-tabs-custom" id="list-rutas" style='display: <?php if(!empty($_SESSION['crgruta'])){ ?> none !important; <?php } ?>' >
<!-- Tabs within a box -->
<div class="tab-content ">
  <!-- Morris chart - Sales -->

</div>
</div>
<script>
$(function(){
    $('#data-table').DataTable();
});
</script>
