<?php

class MY_Controller extends Controller{
	function MY_Controller(){
		parent::Controller();
	}

	function verificaUsuarioLogado(){
		session_start();

		if (!isset($_SESSION['login_id'])){
			$_SESSION['login_id'] = -1;
		}else if(isset($_GET['login_id']) && $_GET['login_id'] > -1){
			$_SESSION['login_id'] = $_GET['login_id'];
		}else if(isset($_POST['login_id']) && $_POST['login_id'] > -1){
			$_SESSION['login_id'] = $_POST['login_id'];
		}

		if($_SESSION['login_id'] < 1){
			redirect('begin','refresh');
		}
	}


	function isMobile(){
		//identificar se � mobile verificar o indice do ua_type != bro e mobile_test != null quer dizer que � mobile
		$array = browser_detection('full');
		if($array['8'] != 'bro' && !empty($array['12'])){
			return true;
		}else{
			return false;
		}
	}

}

?>
