<?php


function get_retencion_iva($prov,$fac){
    $obj=new funciones();
    $resp=$obj->get_retencion_iva($prov,$fac);
    $resp=json_encode($resp,JSON_UNESCAPED_UNICODE);
    return $resp;
}

function get_proveedores(){
    $ret=new funciones();
    $proveedores=$ret->get_proveedor($user,$pass);
    if(!empty($proveedores)){
        $rec = json_encode($proveedores,JSON_UNESCAPED_UNICODE);
	
    }else{
        $proveedores["resp"]=1003;
        $proveedores["error"]="NO SE ENCONTRRON REGISTROS";
    }
    return $rec;
}

function get_sucursal(){
    $obj=new funciones();
    $distribuidor=$obj->get_distribuidor();
    $rec = json_encode($distribuidor,JSON_UNESCAPED_UNICODE);
     return $rec;
}


function dologi_ini($user,$pass){
    $obj=new funciones();
    $obj_v=new Validate();
    $pass=$obj_v->Encrypt($pass);
    $user=$obj->dologi_ini($user,$pass);
    if(!empty($user)){
        $resp['resp']="ok";
        $resp['cod']=trim($user[0]['codiuser']);
        $resp['rif']=trim($user[0]['rifuser']);
        $resp['user']=trim($user[0]['nameuser']);
        $resp['dir']=trim($user[0]['direuser']);
        $resp['tipo']=trim($user[0]['tipouser']);
        $resp['login']=trim($user[0]['logiuser']);
        $resp['edit']=trim($user[0]['edituser']);
        $resp['foto']=trim($user[0]['fotouser']);
        $resp['code']=trim($user[0]['codeuser']);
        $resp["sucur"] = "LG";
    }else{
        $resp["resp"] = 1001;
        $resp["error"] = "USUARIO INVALIDO";
    }
    $resp=json_encode($resp,JSON_UNESCAPED_UNICODE);
    return $resp;
}
function update_user($user,$pass){
    $obj=new funciones();
    $obj_v=new Validate();
    $pass=$obj_v->Encrypt($pass);
    $user=$obj->update_user($user,$pass);
    if(!empty($user)){
        $resp['resp']="ok";
        $resp['error']="USUARIO ACTUALIZADO";
    }else{
        $resp["resp"] = 1002;
        $resp["error"] = "ERROR AL ACTUALIZAR";
    }
    $resp=json_encode($resp,JSON_UNESCAPED_UNICODE);
    return $resp;
}
function update_foto($foto,$id){
    $obj=new funciones();
    $user=$obj->update_foto($user,$pass);
    if(!empty($user)){
        $resp['resp']="ok";
        $resp['error']="USUARIO ACTUALIZADO";
    }else{
        $resp["resp"] = 1001;
        $resp["error"] = "ERROR AL ACTUALIZAR";
    }
    $resp=json_encode($resp,JSON_UNESCAPED_UNICODE);
    return $resp;
}
function get_retencion_islr($prov,$fac){
    $obj=new funciones();
    $resp=$obj->get_retencion_islr($prov,$fac);
    $resp=json_encode($resp,JSON_UNESCAPED_UNICODE);
    return $resp;
}

?>