<?php
class Pedidos extends Model{ 
    function get_pedidos_filtrar($fecha_a,$fecha_b,$cliente){
        if(empty($fecha_a) && empty($fecha_b)){
            $fecha_b = date('Y-m-d');
            $nuevafecha = strtotime ( '-7 day' , strtotime ( $fecha_b ) ) ; 
            $nuevafecha = date ( 'Y-m-d' , $nuevafecha );  
            $fecha_a = str_replace("-","", $nuevafecha);
        }
        $query=" select NUMEDOCU,PEDIDO,CODIPROD,CAJAS,UNIDADES,PRECVENT,DESCUENTO,DESCUENT2,TOTAPROD,CODICLIE,FECHA from tfacpeda 
        where CODIRUTA = '".$_SESSION['crgruta']."' and FECHA >= '$fecha_a' and FECHA <= '$fecha_b' "; 
        
        $ini=strpos($query,"select")+6;
        $fin=strpos($query,"from")-$ini;
        $campos=substr($query,$ini,$fin);
        $ini=strpos($query,"from")+4;
        $fin=strpos($query,"where")-$ini;
        $tabla=substr($query,$ini,$fin);
       $campos=explode(',',$campos);
       $tabla=trim($tabla);
       foreach($campos as $c=>$val){
           $campos[$c]=trim($val);
       }
        $ini=strpos($query,"where")+5;
        $where=substr($query,$ini);
        $where=explode(' ', trim($where));
        die(var_dump($where));
        //$resp= $this->_SQL_tool($this->SELECT, __METHOD__,$query,'','','dbf');
        //$query=" select NUMEPEDI from tfachisa where "; 
        //$resp2= $this->_SQL_tool($this->SELECT, __METHOD__,$query,'','','dbf');
        //$j=0;
        //for($i=0;$i<count($resp);$i++){
         //  if (trim($resp[$i]['CODIRUTA'])== $_SESSION['crgruta'] )  {
            //    $resp[$j]=$resp[$i];
          //     $j++;
            //}
       //}
        //return $resp;
    }
    
    function filtro_fecha($f1,$f2,$r){
        
        
    }
    
    function filtro_cliente($c,$r){
        
    }
}
?>