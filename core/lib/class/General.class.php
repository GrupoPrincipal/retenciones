<?php
class General extends Model{
    function get_moduls($tipo){
        $query="SELECT
            modulos.descmodu,
            modulos.fontmodu,
            modulos.diremodu,
            submodulo.descsbmd,
            submodulo.fontsbmd,
            submodulo.diresbmd
        FROM
            permisos
        INNER JOIN modulos ON permisos.codemodu = modulos.codemodu
        LEFT JOIN submodulo ON permisos.codesbmd = submodulo.codesbmd
        WHERE
            permisos.codetype ='$tipo' ";
        //die($query);
         return $this->_SQL_tool($this->SELECT, __METHOD__,$query);
    }
}
?>