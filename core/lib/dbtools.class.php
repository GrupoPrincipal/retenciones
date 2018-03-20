<?php
class cls_dbtools{
/******************************************************************
/*******  VARIABLES
/******************************************************************/
var $return_id='';
var $time='';
var $genera_log=true;
static $arr_codigosLogNoRewrite=array('INSERT'=>201,'UPDATE'=>202,'DELETE'=>203);
private $codigos=array('INSERT'=>201,'UPDATE'=>202,'DELETE'=>203);
private $add_myoptime_errors=true;
public static $dbDebug =array();
var $var_trans = '0';
var $INSERT = 'INSERT';
var $UPDATE = 'UPDATE';
var $DELETE = 'DELETE';
var $SELECT = 'SELECT';
var $SELECT_SINGLE = 'SELECT_SINGLE';
var $_DIE = 'DIE';
var $_ECHO = 'ECHO';
public static $DBParameters = array();
private $DBconnection = array();
private $resultDB = false;
public static $DBsession = '';
public $DriverDsn='';

    
public static function assignDBParameters($arrDB){
	self::$DBParameters = $arrDB;
}
public function assignDriver($driver){
	$this->DriverDsn = $driver;
}
function _connectDB($app){
$arrDBP = self::$DBParameters[$app];


	$this->DBconnection[$app] = mysql_connect($arrDBP['host'], $arrDBP['user'], $arrDBP['pass'], true) or die("Error de conexion");
mysql_select_db($arrDBP['db'], $this->DBconnection[$app])or die("Error de base de datos");
	if(!is_object($this->DBconnection[$app]))
	{
		//echo ' => NO conecto';
		return false;
	}
	else
	{
	   //echo ' => SI conecto';
		return true;
	}
}
    
function _SQL_tool($tipo, $funct_call, $query, $comentario='', $tabla,$type='mysql', $viewQ='', $app='_DEFAULT'){
    $user='0';
    cls_dbtools::$dbDebug[] = array('class'=>get_class($this),'method'=>$funct_call,'query'=>$query,'time'=>  $this->time);
    
    if ($viewQ == _ECHO || $tipo == 'ECHO'){
        Debug::pr($query);
    }
    if ($viewQ == _DIE || $tipo == 'ECHO'){
        Debug::pr($query, true);
    }
    $tipo=strtoupper($tipo);
    $this->return_id = '';
    $query = trim($query);
    // Chequeo de conexion
    $this->check_connect($app);

    switch($tipo){
            case 'SELECT':
                if( stripos($query,'GROUP_CONCAT') !== false ){ $this->alterar_group_concat_max_len($app); }
                set_time_limit(0);
                ini_set('memory_limit',-1);
                if($calcrows){ $query = substr($query,0,6)." SQL_CALC_FOUND_ROWS ".substr($query,6); }
                $inicio = microtime();
                $result = mysql_query("set names 'utf8'");
                $result = mysql_query($query, $this->DBconnection[$app]) or die('Consulta fallida: ' . mysql_error());
                $fin = microtime();
                $this->time = $fin - $inicio;
                $res_array = array ();
                $i = 0;
                //Consulta general
                if ($result) {
                        while($rows=mysql_fetch_assoc($result)){
                                foreach($rows as $columna => $valor){
                                        $res_array[$i][$columna] = $valor;
                                }
                                $i++;
                        }
                        //$rows2=mysql_fetch_assoc($result);
                        print_r($rows=mysql_fetch_assoc($result));
                        //Para retornar el total de registros si no existiera el limite
                        $result = mysql_query('SELECT FOUND_ROWS() as total', $this->DBconnection[$app]);
                        if($row=mysql_fetch_assoc($result)){
                                $this->total_verdadero = $row['total'];
                        } else {
                                $this->total_verdadero = 0;
                        }

                        return $res_array;
                }else{
                    return 0;
                }
                    
                break;
            case 'SELECT_SINGLE':
                    if( stripos($query,'GROUP_CONCAT') !== false ){ $this->alterar_group_concat_max_len($app); }
                    $inicio = microtime();
                    //~ $result = mysql_query("set names 'utf8'");
                    $result = mysql_query($query, $this->DBconnection[$app]);

                    $fin = microtime();
                    $this->time = $fin - $inicio;
                    $res_array=array();
                    if ($result) {
                            if($rows=mysql_fetch_assoc($result)){
                                    foreach($rows as $columna => $valor){
                                            $res_array[$columna] = $valor;
                                    }
                            }
                            return $res_array;
                    }else{
                        return 0;
                    }
                    break;
            case 'INSERT':
            case 'UPDATE':
            case 'DELETE':

                //include_once(APPROOT.'../../browser_detection/your_computer_info.php');

                //$html=mysql_real_escape_string($html);
                    $return_value="0";
                    try{
                            $inicio = microtime();
                            $result = mysql_query("set names 'utf8'");
                            $result = mysql_query($query, $this->DBconnection[$app]);
                            $query=addslashes($query);
                            if($result){
                                    $return_value = true;
                                    if($tipo=='INSERT'){
                                            $this->return_id = mysql_insert_id($this->DBconnection[$app]);
                                            $return_value = $this->return_id;
                                    }
                            }else{
                                return 0;
                            }
                                //****************************************
                                //****************************************
                                //Hacer auditoria en un insert en esta zona
                                //****************************************
                                //****************************************                            
                        return $return_value;
                    } catch(Exception $e) {
                            die("Sentencia no corresponde con el primer parametro de la funcion _SQL_tool. Debe ser corregido para continuar");
                    }
                    break;
    }
}
/**
 * Propiedad para alargar el resultado de la lista al ejecutar
 * el comando GROUP_CONCAT de mysql al hacer un select
*/
private function alterar_group_concat_max_len(){
		//Hay que quitar el limite de la funcion para poder mostrar todos los posibles valores
		$prequery="SET @@group_concat_max_len = 9999999";
		mysql_query($prequery, $this->DBconnection[$app]);
}
function check_connect($app){
	$arr_config = '';
	if (!isset($this->DBconnection[$app]) && !is_object($this->DBconnection[$app])){
		if (!isset($this->DBconnection[$app]) && !is_object($this->DBconnection[$app])){
				$this->_connectDB($app);
            }
    }
}  
    
}
?>