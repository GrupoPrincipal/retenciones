<?php 
require_once('../core/config_var.php');
$link='';
$ip='';
$proy='1005';
$host= $_SERVER["HTTP_HOST"];
$url= '/'.$_GET['view'];
$link= "http://".$host.$url;
if (!empty($_SERVER['HTTP_CLIENT_IP']))
    $ip = $_SERVER['HTTP_CLIENT_IP'];
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
else
    $ip = $_SERVER['REMOTE_ADDR'];
//$postData=array("proy"=>$proy,"host"=>$host,"url"=>$url,"link"=>$link,"ip"=>$ip);
$postData=array("proy"=>$proy,"host"=>$host,"url"=>$url,"link"=>$link,"ip"=>$ip,"user"=>$_SESSION['user_gdp']['user'],"login"=>$_SESSION['user_gdp']['login'],"tipo"=>$_SESSION['user_gdp']['tipo']);
//die(var_dump($postData));
try {
    $handler = curl_init();  
     curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($handler, CURLOPT_URL, "http://sistemasc.gdp.com.ve/laprincipal/dashboard/dasboard.php");  
    curl_setopt($handler, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1");  
    curl_setopt($handler, CURLOPT_HTTPHEADER, array("Accept-Language: es-es,en"));
    curl_setopt($handler, CURLOPT_POST,true); 
    curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($handler, CURLOPT_POSTFIELDS, $postData);
    $response = curl_exec($handler);  
    curl_close($handler);
}catch(Exception $e) {
    
}
?>
<!DOCTYPE html>
<html lang="es" ng-app>
<head>
	<meta charset="UTF-8">
	<title><?php echo SITENAME; ?> | RETENCIONES</title>
	<link rel="icon" href="<?php echo ASSETS; ?>images/ico.png" type="image/x-icon" />

	<link href="<?php echo ASSETS; ?>custom/css/site.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ASSETS; ?>custom/plugins/lightslider-master/src/css/lightslider.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo ASSETS; ?>components.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>css/blog.css">
	<?php require_once(COREROOT . "headercode.php"); ?>
<link rel="stylesheet" id="us-font-2-css" href="https://fonts.googleapis.com/css?family=Open+Sans%3A400%2C400italic%2C600&amp;subset=latin&amp;ver=4.8.1" type="text/css" media="all">
<link rel="stylesheet" id="us-font-1-css" href="https://fonts.googleapis.com/css?family=Roboto%3A300%2C400%2C700&amp;subset=latin&amp;ver=4.8.1" type="text/css" media="all">
<script src="<?php echo ASSETS; ?>custom/plugins/lightslider-master/src/js/lightslider.js"></script>
    <link rel="stylesheet" href="<?php echo ASSETS; ?>plugins/daterangepicker/jquery.comiseo.daterangepicker.css">
<script src="<?php echo ASSETS; ?>plugins/daterangepicker/moment.js"></script>
    <script src="<?php echo ASSETS; ?>plugins/jqueryui/jquery-ui.min.js"></script>
    <script src="<?php echo ASSETS; ?>plugins/daterangepicker/jquery.comiseo.daterangepicker.js"></script>
    <link rel="stylesheet" href="<?php echo ASSETS; ?>alertify.core.css">
<link rel="stylesheet" href="<?php echo ASSETS; ?>alertify.default.css">
<script type="text/javascript" src="<?php echo ASSETS; ?>alertify.js"></script>
</head>
<body>
<script>
    function salir(){
        $.post("../app/salir.php", function(){
            window.location.assign("https://www.gdp.com.ve/wp-content/themes/Impreza/logaut.php");
        })
    }
</script>
<div class="header row" style="margin:0;">
    
    <header class="head row col-md-12" style="margin:0;background-size: cover; background-repeat: no-repeat; background-position: 50% -186.152px;background-image: url(<?php echo ASSETS; ?>images/retencion.jpg);">
    <div class="col-md-12">
       
    <div class=" col-md-4 row">
            <div class=" col-md-4" style="padding-top: 9px;">
                <img src="<?php echo FILES; ?>logo.png" class="logo-site"> 
               
            </div>
            <div  class=" col-md-8"> <h3  class="site-title" style=""></h3></div>
    </div> 
            <div class=" col-md-7 col-md-offset-1" style="text-align: right;">
                <nav class="nav" style="    position: relative;">
                        <ul class="list">
                                                    
                            
                            <?php
                            if(isset($_SESSION['user_gdp'])){
                            ?>
                            <li class=" item fa  dropdown">
                              <span class="dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $_SESSION['user_gdp']['user'];  ?>
                              <span class="caret"></span></span>
                              <ul class="dropdown-menu">
                                <li class=""><a href="https://www.gdp.com.ve/iniciar/"  style="color: #000;" > Inicio</a></li>
                                <li class=""><a href="#" onclick="salir()"  style="color: #000;" > Cerrar sesion</a></li>
                              </ul>
                            </li>


                            <?php
                            }else{
                            ?>
                                <li class="item fa "><a href="https://www.gdp.com.ve/iniciar/"> &nbsp; Ingresar</a></li>
                            <?php
                            }
                            ?>

                        </ul>
                    </nav>
            </div>
    </div>
</header>

</div>