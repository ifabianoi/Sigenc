<?php

class CSecure extends Controller {

	function CSecure(){
		parent::Controller();
		session_start();

		if (!isset($_SESSION['login_id'])){
			$_SESSION['login_id'] = -1;
		}

		if($_SESSION['login_id'] < 1){
			redirect('cautenticacao','refresh');
		}

	}

	function index(){
	}
}

?>