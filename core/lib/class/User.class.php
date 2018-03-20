<?php
class Users extends Model{ 
   function login_user($user,$pass){
    $user=strtoupper($user);
     $ldaprdn = trim($user).'@'.$this->dominio; //$ldaprdn
     $ldappass = trim($pass); //$ldappass
     $ds = $this->dominio; 
     $dn = $this->dn;  
     $puertoldap = $this->puerto;
    
	 $array = array();
     $ldapconn = ldap_connect($ds,$puertoldap);
       ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3); 
       ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0);
       $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);
       
       if ($ldapbind){
		 $filter = "(&(objectClass=user) (samaccountname=".trim($user).") (memberOf=cn=AccesoWeb,DC=principal,DC=local))";
         $fields = array("SAMAccountName","physicaldeliveryofficename","title","department"); 
         $sr = @ldap_search($ldapconn, $dn, $filter, $fields); 
         $info = @ldap_get_entries($ldapconn, $sr);
		 if(isset($info[0])){
			 $array = $info[0];//$info[0]["samaccountname"][0];
	     }else{	 
             $array=9; // usuario no autorizado.
		 }
	   }else{
         	$array=0; // usuario invalido
       } 
     ldap_close($ldapconn);
       $query="insert into session(fechsesi,usersesi)values(now(),0)";
       $this->_SQL_tool($this->INSERT, __METHOD__,$query,'iniciar session','sesion','0');
	 return $array; 
   }
}
?>