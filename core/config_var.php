<?php
//error_reporting(0);
//ini_set(display_errors, 0);
session_start();
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
$document_root = '';
$cwd = getcwd();
$arrDirectoryHierarchy = explode(DIRECTORY_SEPARATOR, $cwd);
for($i=0, $limit=count($arrDirectoryHierarchy); $i<$limit; $i++){
	if($arrDirectoryHierarchy[$i]=='app' or $arrDirectoryHierarchy[$i]=='pages' ){
		break;
	} else{
		$document_root .= $arrDirectoryHierarchy[$i].DIRECTORY_SEPARATOR;
	}
}
define ( 'COREROOT', $document_root."core/" );
define ( 'APPROOT', $document_root."app/" );
define ( 'FONTROOT', $document_root );
define ( 'DOMAIN_ROOT', 'https://' . $_SERVER ['SERVER_NAME'] . '/retenciones/app/' );
define ( 'PAGES', 'https://' . $_SERVER ['SERVER_NAME'] . '/retenciones/pages/' );
define ( 'ASSETS', 'https://' . $_SERVER ['SERVER_NAME'] . '/retenciones/styles/' );
define ( 'FILES', 'https://' . $_SERVER ['SERVER_NAME'] . '/laprincipal/files/' );
define ( 'DOMAIN_ROOT', 'https://' . $_SERVER ['SERVER_NAME'] . '/soap_app/' );
define ( 'SITENAME', 'GRUPO PRINCIPAL' );
define('DOMINIO', 'principal.local');
define('DN', 'dc=principal,dc=local');
define('DBF','C:/sisventor/VENTOR/DATA/');
define('DSN','Driver={Microsoft Visual FoxPro Driver};SourceType=DBC;SourceDB=C:/SISVENTOR/VENTOR/DATA/TRITON.DBC;Exclusive=No;NULL=NO;Collate=Machine;BACKGROUNDFETCH=NO;DELETED=NO');

//die(COREROOT);
$arrDB = array(
    '_DEFAULT' => array(
 		'host' => '192.168.64.2:3307',
		'user' => 'gestorm',
		'pass' => 'gestorm',
		'db' => 'principal'),
    '_VENTOR' => array(
 		'host' => '192.168.64.2:3307',
		'user' => 'estaciones',
		'pass' => '123',
		'db' => 'ventoradm001')
		);
include_once(COREROOT."lib/logs.class.php");
require(COREROOT."lib/dbtools.class.php");
require(COREROOT."lib/model.class.php");
require(COREROOT."lib/class/User.class.php");
require(COREROOT."lib/class/General.class.php");
require(COREROOT."lib/class/class.funciones.php");
require(COREROOT."lib/class/class.Validation.php");


$db_dbtools= new cls_dbtools();
$db_dbtools->assignDBParameters($arrDB);
$db_dbtools->assignDriver(DSN);
$db_dbtools->_connectDB("_DEFAULT");




setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8'); # Asi es mucho mas seguro que funciones, ya que no todos los sistemas llaman igual al locale ;)
date_default_timezone_set('America/Caracas');
?>