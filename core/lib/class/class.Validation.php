<?php
class Validate extends Model{
//~ error_reporting(E_ALL);
//~ ini_set("display_errors", 1);
	//~ Definir variables default
	private $Charset="spa"; //~ cotejamiento por defecto
	private $Key = "ϠϡϞϟϚϛΣσςΨψΣσςΗηΞξΘθωδικόςΩωԻکدնդեքսкодקאָדעקסããकोçãडਪਿਆਰ"; //~ Llave de seguridad para encriptar y desencriptar contraseñas
	private $errors=array();
	private $Formatdate="yyyy-mm-dd";
	private $separator="-";
	private $year=4;
	

	function Errors($val){
		
		$errors["empty"]=array("Error"=>"EMPTY","ValError"=>"1001");
		$errors["notnum"]=array("Error"=>"LENGTH_NOT_NUMBER","ValError"=>"1002");
		$errors["invalidkey"]=array("Error"=>"KEY_INVALID","ValError"=>"1003");
		$errors["invalidformat"]=array("Error"=>"FORMAT_INVALID","ValError"=>"1004");
		$resp=json_encode($errors[$val]);
		die($resp);
	}
	function Alpha($value){
	$alpha['eng']= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'";
	$alpha['spa']= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ";
	$alpha['por']="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜÁáÀàÂâÃãÉéÊêÍíÓóÔôÕõÚúç";
	$alpha['rus']="АаБбВвГгДдЕеёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя";
	$alpha['all']="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZБбВвГгДдЕеёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯяáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜÁáÀàÂâÃãÉéÊêÍíÓóÔôÕõÚúçáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ";
		if(!empty($value))
			$this -> Charset=$value;
		return $alpha[$this -> Charset];
	}
	//~ funcion para validar letras
	function Letters($value,$length='',$alpha=''){
		$value=trim($value);
		$this->EmptyNull($value);
		for ($i=0; $i<strlen($value); $i++){
			$regex="/^([".$this->Alpha($alpha)."])+$/";
			if (preg_match($regex,$value))
				$resp=true;
			else
				$resp= false;
		}
		if( !empty($length) && $resp== true ){
			if($this->Length($length) && strlen($value)==$length)
				$resp=true;
			else
				$resp=false;
		}
		return $resp;
	}

	//~ Validar que la cantenga contenga un numero minimo de caracteres
	function MinLength($value,$min){
		$value=trim($value);
		$value=trim($min);
		$this->EmptyNull($value);
		$this->EmptyNull($min);
		$this->Length($min);
		if(strlen($value)>=$min){
			$resp=true;
		}
		else
			$resp=false;
		return $resp;
	}
	//~ Validar que la cadena contenga un numero maximo de caracteres
	function MaxLength($value,$max){
		$value=trim($value);
		$value=trim($max);
		$this->EmptyNull($value);
		$this->EmptyNull($max);
		$this->Length($max);
		if(strlen($value)<=$max){
			$resp=true;
		}
		else
			$resp=false;
		return $resp;
	}
	//~ Validar rangos de tamaño de una cadena
	function RangLength($value,$min,$max){
		$value=trim($value);
		$value=trim($max);
		$value=trim($min);
		$this->EmptyNull($value);
		$this->EmptyNull($max);
		$this->Length($max);
		$this->EmptyNull($min);
		$this->Length($min);
		if(strlen($value)<=$max && strlen($value)>=$min){
			$resp=true;
		}
		else
			$resp=false;
		return $resp;
	}
	//~ validar numeros
	function Numbers($value,$length=''){
		$value=trim($value);
		$this->EmptyNull($value);
		$length=trim($length);
		
		if(preg_match("/^[0-9]+$/", $value))
			$resp=true;
		else
			$resp=false;
			
		if(!empty($length)){
			if($this->Length($length) && strlen($value)==$length )
				$resp=true;
			else
				$resp=false;
		}
		return $resp;
	}
	//~ validar si el largo que quiere validar el usuario sea un numero
	function Length($value){
		if(preg_match("/^[0-9]+$/", $value))
			return true;
		else
			$this->Errors("notnum");
	}
	//~ Devolver error si el valor es vacio
	function EmptyNull($value){
		if(empty($value))
			$this->errors("empty");
		else
			return true;
	}
	//~ Validar correo
	function Email($value) 
	{
	  if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$value))
		$resp = true;
	  else
		$resp = false;
		
	  return $resp;
	}
	function Password($value,$level){
		$value=trim($value);
		if (preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $value))
			$resp=true;
		else
			$resp=false; 
		return $resp;
	}
	//~ Funcion para encriptar contraseñas
	function Encrypt($value, $key="") {
		$result = '';
		$value=trim($value);
		$this->EmptyNull($value);
		$key=trim($key);
		if(!empty($key) && $this->ValideKey($key))
			$key= $this->key();
		for($i=0; $i<strlen($value); $i++) {
			$char = substr($value, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}
	return base64_encode($result);
	}
	
	function Decrypting($value,$key='') {
		$value=trim($value);
		$this->EmptyNull($value);
		$key=trim($key);
		if(!empty($key) && $this->ValideKey($key))
			$key= $this->key;
			
		$result = '';
		$string = base64_decode($value);
			for($i=0; $i<strlen($value); $i++) {
				$char = substr($value, $i, 1);
				$keychar = substr($key, ($i % strlen($key))-1, 1);
				$char = chr(ord($char)-ord($keychar));
				$result.=$char;
			}
		return $result;
	}

	//~ funcion para validar la fecha
	function ValideDate($value,$format){
		$value=trim($value);
		$this->EmptyNull($value);
		trim($format);
		$fecha=explode($this->separator,$value);
		
		if(!empty($format))
		{
			if($this->Format($format)==false)
				$this->errors("invalidformat");
		}
		
	}
	function Format($value){
		
		$value=trim($value);
		$this->EmptyNull($value);
		
		$value=explode('-',$value);
		if(is_array($value))
			$this->separator="-";
		$value=explode('/',$value);
		if(is_array($value))
			$this->separator="/";
		
		$regex="/^([yY]{2,4})+([mM{2})+([dD]{2})|([dD]{2})+([mM]{2})+([yY]{2,4})|([mM]{2})+([dD]{2})+([yY]{2,4})|([yY]{2,4})+([dD]{2})+([mM]{2})+$/";
		if(preg_match($regex,$value)){
			$resp=true;
		}else{
			$resp=false;
		}
		return $resp;
	}
    
    function Clearing($post){

        foreach($post as $id => $val){
            $value[$id]=trim($val);
            $value[$id]=addslashes($val);
        }
        return $value;
    }
	
}

?>
