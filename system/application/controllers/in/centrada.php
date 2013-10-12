<?php

class CEntrada extends MY_Controller {

	function CEntrada(){
		parent::MY_Controller();
	}

	function index(){
	}

	function getEntradas(){
		session_start();
		header('Content-type: application/json');
		$login_id = $this->input->get_post('login_id', TRUE) ? $this->input->get_post('login_id', TRUE) : $_SESSION['login_id'];
		$data['entradas'] = $this->MEntrada->findAll($login_id);
		print json_encode($data);
	}

	function cadastrar(){
		session_start();
		header('Content-type: application/json');
		$login_id = $this->input->get_post('login_id', TRUE) ? $this->input->get_post('login_id', TRUE) : $_SESSION['login_id'];

		$data = array(
            'idEntrada'     => $this->input->get_post('idEntrada', TRUE),
            'dataEntrada'     => $this->input->get_post('dataEntrada', TRUE),
            'descricao' 	=> $this->input->get_post('descricao', TRUE),
			'valorEntrada' 	=> $this->input->get_post('valorEntrada', TRUE),
			'login_id'	    => $login_id
		);

		$entrada = $this->MEntrada->incluir($data);
		$dataRet['success'] = true;
		$dataRet['entrada'] = $entrada;
		print json_encode($dataRet);
	}


	function excluir(){
		session_start();
		header('Content-type: application/json');

		$idEntrada  =  $this->input->get_post('idEntrada', TRUE);
		$login_id = $this->input->get_post('login_id', TRUE) ? $this->input->get_post('login_id', TRUE) : $_SESSION['login_id'];

		if (strlen($idEntrada) > 0) {
			$this->MEntrada->excluir($idEntrada, $login_id);
			$return = array(
                'success' => TRUE
			);
		} else {
			$return = array(
                'success' => FALSE,
                'msg'     => 'Nenhum codigo de entrada para exclus&atilde;o'
                );
		}
		print json_encode($return);
	}

}

?>