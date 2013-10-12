<?php
function id_clean($id,$size=11){
	return intval(substr($id,0,$size));
}

function db_clean($string,$size=255){
	return xss_clean(substr($string,0,$size));
}

function save_user($iduser, $loginUser){
	$_SESSION['login_id'] = $iduser;
	setcookie("login_id",$iduser, time() + 36000000);
	$_SESSION['login'] = $loginUser;
	setCookie("login", $loginUser, time() + 36000000);
}

function isUserAutenticate(){
	ob_start();
	if (!isset($_SESSION['login_id'])){
		$_SESSION['login_id'] = -1;
	}
	 
	if(isset($_COOKIE["login_id"])){
		$_SESSION['login_id'] = $_COOKIE["login_id"];
	}

	if($_SESSION['login_id'] < 1){
		return false;
	}else{
		return true;
	}
}

?>