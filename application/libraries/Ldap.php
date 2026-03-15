<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Ldap {
	public  function connect($username,$password,$authentication=true){
		$ldapbind = $this->authentication($username,$password);
	  if ($ldapbind) {
			if($authentication == true) return array('username'=>$username); return true;
	  } else {
	    return  false;
	  }
	}

	private function authentication($username,$password){
		$ldap_password = $password;
		$ldapconn = ldap_connect(HOST_NAME,PORT_NUMBER) or die("Could not connect to $ldaphost");
		ldap_set_option($ldapconn , LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldapconn , LDAP_OPT_REFERRALS, 0);
		$bind_data = @ldap_bind($ldapconn,PREFIX_DC.$username.DC, $ldap_password);
		return $bind_data;
	}

}
?>