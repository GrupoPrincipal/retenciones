<?php

class Rutas extends Model{
   function get_rutas($type){
        $query="select CODIRUTA, NOMBVEND from TRUTA where NOMBVEND != 'VACANTE' and NOMBVEND != '.' ";
       $resp= $this->_SQL_tool($this->SELECT, __METHOD__,$query,'','','dbf');
       $j=0;
       for($i=0;$i<count($resp);$i++){
           if ((trim($resp[$i]['NOMBVEND']) != "VACANTE") && (trim($resp[$i]['NOMBVEND']) != "."))  {
                $response[$j]=trim($resp[$i]);
               $j++;
            }
       }
       
       return $response;
   }
}
?>