<?php
require("../core/config_var.php");
include("../core/lib/class/pedidos.class.php");
    if($_GET['type']=='filtrar'){
        
         $Obj_pedidos=new Pedidos;
         $resp=$Obj_pedidos->get_pedidos_filtrar($_GET['ini'],$_GET['fin'],$_GET['cli']);
        
         var_dump($_GET);
    }
?>