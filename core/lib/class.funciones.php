<?php
class funciones extends Model {
    
    function login($user,$pass){
        $ldaprdn = trim($user).'@'.DOMINIO; 
             $ldappass = trim($pass); 
             $ds = DOMINIO; 
             $dn = DN;  
             $puertoldap = 389; 
             $array = array();
             $ldapconn = ldap_connect($ds,$puertoldap);
               ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3); 
               ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0); 
               $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass); 
               if ($ldapbind){
                 $filter = "(&(objectClass=user) (samaccountname=".trim($user)."))";
                 $fields = array("SAMAccountName","physicaldeliveryofficename","title","department","description","mail","info"); 
                 $sr = @ldap_search($ldapconn, $dn, $filter, $fields); 
                 $info = @ldap_get_entries($ldapconn, $sr); 
                 if(isset($info[0])){
                     $array = $info[0];//$info[0]["samaccountname"][0];
                 } 
                 else{
                     $array=9; // usuario no autorizado.
                 }
               }else{ 
                    $array=0; // usuario invalido
               } 
             ldap_close($ldapconn); 
        $usuario=$array;
        if($usuario==9){
        $records["resp"] = 1002;
        $records["error"] = "USUARIO NO AUTORIZADO";
    }elseif($usuario){
        
        $res=explode(',',$usuario['dn']);
        foreach($res as $r){
            $p=explode('=',$r);
            $ar[0][$p[0]].=$p[1].'|';
            $ar[0][$p[0]]=str_replace('Excepción Unidades Extraibles|','',$ar[0][$p[0]]);
        }
            $des=explode('|',$ar[0]['OU']);
        if($des[0]=='GDP Tecnologia'){
            $tipo=0;
        }else{
            $tipo=1;
        }
        $records["CUENV_TIPO"] = $tipo; //$usuario;
        $records["CUENV_USUARIO"] = str_replace('|','',$ar[0]['CN']);
        $records["CUENV_CEDULA"] = $usuario["info"][0];
            if($tipo > 0){
                $records["details"]['CRVV_CODIEMPR']='E0000053';
                $records["details"]['CRVV_IDVENDEDOR']=$usuario["title"][0];
                $records["info"]['VENDV_CODIEMPR']='E0000053';
                $records["info"]['VENDV_IDVENDEDOR']=$usuario["title"][0];
                $records["info"]['VENDV_NOMBRE']=str_replace('|','',$ar[0]['CN']);
            }
    }else{
        $records["resp"] = 1001;
        $records["error"] = "USUARIO INVALIDO";
    }
    $rec = json_encode($records,JSON_UNESCAPED_UNICODE);
        
             return $records;
    }
    
    
    function get_distribuidor(){
        $query="SELECT CIUDAD,ESTADO,RIF,DIRECCION1,DIRECCION2,NOMBALMA FROM tdisb";
        return $this->_SQL_tool($this->SELECT, __METHOD__,$query,'','','mysql','','_VENTOR');
    }
    function get_retencion_iva($clie,$fact){
        $query="SELECT
                    tcppa.NOMBRE,
                    tcppa.RIF,
                    treiva.FORIEMI,
                    treiva.NUMLEGAL,
                    treiva.CONTROL,
                    treiva.TIPO,
                    treiva.LEGALAFE,
                    treiva.EXENTO,
                    treiva.MONTO,
                    treiva.BASE,
                    treiva.ALIC,
                    treiva.IVA,
                    treiva.RET,
                    treiva.EMISION,
                    treiva.TOTAL,
                    treiva.FORILLE,
                    treiva.p,
                    treiva.nume,
                    treiva.CODIPROV,
                    tcppa.DIRECCION1,
                    tcppa.DIRECCION2,
                    tciua.NOMBCIUD AS CIUDAD,
                    testa.NOMBESTA AS ESTADO,
                    tislrpv.MONTO,

                IF (tislrpv.MONTO > 0, 1, 0) AS ISLR
                FROM
                    treiva
                LEFT JOIN tcppa ON treiva.CODIPROV = tcppa.CODIPROV
                LEFT JOIN tciua ON tcppa.CODICIUD = tciua.CODICIUD
                LEFT JOIN testa ON tcppa.CODIESTA = testa.CODIESTA
                AND tciua.CODIESTA = testa.CODIESTA
                LEFT JOIN tislrpv ON treiva.CODIPROV = tislrpv.CODIPROV
                AND treiva.NUMLEGAL = '%'|tislrpv.NUMEDOCU
                WHERE treiva.MONTO > 0 and
                    tcppa.CODIPROV = '$clie'";
        if(!empty($fact)){
                $query.="AND trim(NUMLEGAL) LIKE '%$fact%' ";
        }else{
                $query.=" order by treiva.FORIEMI desc limit 35 ";
        }
        return $this->_SQL_tool($this->SELECT, __METHOD__,$query,'','','mysql','','_VENTOR');
    }
    function get_proveedor(){
        $query="select nombre,proveedor from usuarios where ISNULL(proveedor)= 0 and proveedor != '0' ";
        return $this->_SQL_tool($this->SELECT, __METHOD__,$query);
    }
    function dologi_ini($user,$pass){
        $query="SELECT
                    users.codeuser,
                    users.nameuser,
                    users.direuser,
                    users.codiuser,
                    users.fotouser,
                    users.edituser,
                    users.rifuser,
                    users.tipouser,
                    users.logiuser,
                    users.ucomuser,
                    users.pcomuser
                FROM
                    users where logiuser = '$user' and passuser='$pass' ";
        //die($query);
        return $this->_SQL_tool($this->SELECT, __METHOD__,$query);
    }
    function login_comerse($login,$pass){
        $query="SELECT CUENV_IDCUENTA,CUENV_USUARIO,CUENV_PASSWORD,CUENV_TIPO FROM tcuentas WHERE CUENV_USUARIO ='$login'  AND `CUENV_PASSWORD` = '$pass' LIMIT 1";
        $resp=$this->_SQL_tool($this->SELECT, __METHOD__,$query,'','','mysql','','_COMERCE');
        $cuent=$resp[0];
        $idaccount=$cuent['CUENV_IDCUENTA'];
        $query = "SELECT `CRCN_IDCUENTA`, `CRCV_CODIEMPR`, `CRCV_IDCLIENTE`,CRCV_IDVENDEDOR FROM `tcuentas_cli` WHERE `CRCN_IDCUENTA` ='$idaccount'  LIMIT 1";
        $resp=$this->_SQL_tool($this->SELECT, __METHOD__,$query,'','','mysql','','_COMERCE');
        $cuent['details']=$resp[0];
        $accountID = $cuent["details"]["CRCV_IDCLIENTE"];
        $accountEMP = $cuent["details"]["CRCV_CODIEMPR"];
        $query = "SELECT `CLIEV_CODIEMPR`, `CLIEV_IDCLIENTE`, `CLIEV_RIF`, `CLIEV_RAZONSOC`, `CLIEV_NOMBRE`, `CLIEV_PROPIETARIO`, `CLIEV_ENCARGADO`, `CLIEV_DIRECCION1`, `CLIEV_DIRECCION2`, `CLIEV_DIRECCION3`, `CLIEV_DIRECCION4`, `CLIEV_DIRECCION5`, `CLIEV_TELEFONO2`, `CLIEV_MOVIL`, `CLIEV_IDESTADO`, `CLIEV_IDCIUDAD`, `CLIEV_IDTMUNICIPIO`, `CLIEV_IDPARROQUIA`, `CLIEV_IDURBANIZACION`, `CLIEV_IDZONA`, `CLIEV_IDGRUPO`, `CLIEV_IDSUBGRUPO`, `CLIEN_STATUS`, `CLIEV_EMAIL`, `CLIEN_DIASDESPACHO`, `CLIEV_HORADESPACHO`, `CLIEV_GRUPCANAL`, `CLIEV_GRUPOFREC`, `CLIET_ULTIVENTA`, `CLIEN_LATITUD`, `CLIEN_LONGITUD`, `CLIEV_CODIGOPOSTAL`, `CLIEV_CONTRIBUYE`, `CLIEV_DIASCRED`, `CLIEV_LIMICRED` FROM `tclientes` WHERE `CLIEV_IDCLIENTE` = '$accountID' AND CLIEV_CODIEMPR = '$accountEMP' LIMIT 1";
        $resp=$this->_SQL_tool($this->SELECT, __METHOD__,$query,'','','mysql','','_COMERCE');
        $cuent['info']=$resp[0];
        return $cuent;
    }
    function cliente($cod=''){
        $query = "SELECT `CLIEV_CODIEMPR`, `CLIEV_IDCLIENTE`,
        `CLIEV_RIF`, `CLIEV_RAZONSOC`, `CLIEV_NOMBRE`,
        `CLIEV_PROPIETARIO`, `CLIEV_ENCARGADO`, `CLIEV_DIRECCION1`, 
        `CLIEV_DIRECCION2`, `CLIEV_DIRECCION3`, `CLIEV_DIRECCION4`,
        `CLIEV_DIRECCION5`, `CLIEV_TELEFONO2`, `CLIEV_MOVIL`,
        `CLIEV_IDESTADO`, `CLIEV_IDCIUDAD`, `CLIEV_IDTMUNICIPIO`, 
        `CLIEV_IDPARROQUIA`, `CLIEV_IDURBANIZACION`, `CLIEV_IDZONA`,
        `CLIEV_IDGRUPO`, `CLIEV_IDSUBGRUPO`, `CLIEN_STATUS`, `CLIEV_EMAIL`,
        `CLIEN_DIASDESPACHO`, `CLIEV_HORADESPACHO`, `CLIEV_GRUPCANAL`,
        `CLIEV_GRUPOFREC`, `CLIET_ULTIVENTA`, `CLIEN_LATITUD`, 
        `CLIEN_LONGITUD`, `CLIEV_CODIGOPOSTAL`, `CLIEV_CONTRIBUYE`,
        `CLIEV_DIASCRED`, `CLIEV_LIMICRED` FROM `tclientes` 
                      WHERE `CLIEV_IDCLIENTE` = '$cod' ";
        return $this->_SQL_tool($this->SELECT, __METHOD__,$query,'','','mysql','','_COMERCE');
        
    }
    function update_user($user,$pass){
        $query="update users set passuser='$pass', edituser=now() where codeuser='$user' ";
        return $this->_SQL_tool($this->UPDATE, __METHOD__,$query);
    }
    function update_foto($foto,$cod){
        $query="update users set fotouser='$foto' where codeuser='$cod' ";
        return $this->_SQL_tool($this->UPDATE, __METHOD__,$query);
    }
    function get_retencion_islr($prov,$fac){
        $query="SELECT
                    tcppc.FORIEMI,
                    tcppc.ABONOS,
                    tcppc.MONTEXEN,
                    tcppc.NUMCONTF,
                    tcppc.CODIRETE,
                    tcppc.FORILLE,
                    tcppc.MONTO AS TOTAL,
                    tcppc.IMPUESTO,
                    tcppc.IMPU1,
                    tcppc.SUSTRAEN,
                    tcppc.RETENIDO,
                    tcppc.PORCRETE,
                    tcppc.MONRETVE,
                    tcppa.NOMBRE,
                    tcppa.DIRECCION1,
                    tcppa.DIRECCION2,
                    tcppa.RIF,
                    tcppa.TELEFONO,
                    tciua.NOMBCIUD AS CIUDAD,
                    testa.NOMBESTA AS ESTADO,
                    tislrpv.CODIRETE,
                    tislrpv.TIPODOCU,
                    tislrpv.SUSTRAEN,
                    tislrpv.MONTO,
                    timph.DESCIMPU as DESCRIPCION,
                    treiva.MONTO AS PAGO,
                    treiva.RET,
                    tcppc.CODIPROV,
                    tcppc.NUMLEGAL
                FROM
                    tcppc
                LEFT JOIN tcppa ON tcppc.CODIPROV = tcppa.CODIPROV
                LEFT JOIN tciua ON tcppa.CODICIUD = tciua.CODICIUD
                LEFT JOIN testa ON tcppa.CODIESTA = testa.CODIESTA
                AND tciua.CODIESTA = testa.CODIESTA
                INNER JOIN tislrpv ON tcppc.CODIPROV = tislrpv.CODIPROV
                AND tcppc.NUMEDOCU = tislrpv.NUMEDOCU
                LEFT JOIN timph ON tcppc.CODIRETE = timph.CODIIMPU
                LEFT JOIN treiva ON treiva.CODIPROV = tcppa.CODIPROV
                WHERE
                tcppc.CODIPROV = '$prov'
            AND tcppc.NUMLEGAL = '$fac'  group by tcppc.NUMLEGAL";
        return $this->_SQL_tool($this->SELECT, __METHOD__,$query,'','','mysql','','_VENTOR');
       //return $query;
    }
    function get_islr($prov,$fact){
        $query="select CODIPROV,NUMEDOCU,CODIRETE from tislrpv where NUMEDOCU='$fact' and ";
        $record=$this->_SQL_tool($this->SELECT, __METHOD__,$query,'','','dbf');
        $n=0;
        for($i=0;$i<count($record);$i++){
             if($record[$i]['NUMEDOCU'] == $fact && $record[$i]['CODIPROV'] == $prov){
                $rec['CODIPROV']= trim($record[$i]['CODIPROV']);
                $rec['NUMEDOCU']=trim($record[$i]['NUMEDOCU']);
                $rec['CODIRETE']=trim($record[$i]['CODIRETE']);
                $rec['TIPODOCU']=trim($record[$i]['TIPODOCU']);
                $rec['SUSTRAEN']=trim($record[$i]['SUSTRAEN']);
                $rec['MONTO']=trim($record[$i]['MONTO']);
            }
        }
        return $rec;
    }
}
?>