<?php
class Clientes extends Model{ 
   function get_clientes(){
       $query="SELECT cli_codigo, cli_nombre, codiruta FROM 
       clientes INNER JOIN tcpcarut ON cli_codigo=codiclie WHERE desactiv = '0' AND codiruta ='".$_SESSION['crgruta']."' ";
      // die($query);
       return $this->_SQL_tool($this->SELECT, __METHOD__,$query);
   }
}
?>