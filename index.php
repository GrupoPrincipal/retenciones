<?php
require("core/config_var.php");
if(!isset($_SESSION['user_gdp'])){
    header("location: login.php");
}

$link='';
$ip='';
$proy='1002';
$host= $_SERVER["HTTP_HOST"];
$url= '/'.$_GET['view'];
$link= "http://".$host.$_SERVER["REQUEST_URI"];
if (!empty($_SERVER['HTTP_CLIENT_IP']))
    $ip = $_SERVER['HTTP_CLIENT_IP'];
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
else
    $ip = $_SERVER['REMOTE_ADDR'];
$postData=array("proy"=>$proy,"host"=>$host,"url"=>$url,"link"=>$link,"ip"=>$ip);
//die(var_dump($postData));
try {
    $handler = curl_init();  
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

$Obj_General=new General;

require(COREROOT."common/top.php");

?>
    <!-- Main content -->
    <section class="content">
    <?php
        if($_GET['view']=='index' || empty($_GET['view']) ){
            include(APPROOT."inicio.php");
        }else{
            if(file_exists(APPROOT.$_GET['view'].".php")){
                include(APPROOT.$_GET['view'].".php");
            }else{
                include(APPROOT."404.php");
            }
        }
    ?>
    </section>
    <!-- /.content -->
<?php
require(COREROOT."common/footer.php");
?>