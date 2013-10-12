<?php

class CCategoria extends MY_Controller {

	function CCategoria(){
		parent::MY_Controller();
	}

	function index(){
		session_start();
		$data['title'] = 'Cadastro de Categorias';
		$data['main'] = 'in/categoria';
		$data['isBarraNav'] = true;
		$this->load->vars($data);
		$this->load->view('in/template');
	}

	function cadastrar(){
		session_start();
		header('Content-type: application/json');
		$data = array(
            'produto_id'        => $this->input->get_post('produto_id', TRUE),
            'descricao'         => $this->input->get_post('descricao', TRUE)
		);
		$produto_id = $this->MCategoria->incluir($data);
		$dataRet['success'] = true;
		$dataRet['produto_id'] = $produto_id;
		print json_encode($dataRet);
	}

	function excluir(){
		session_start();
		header('Content-type: application/json');
		$catId  =  $this->input->get_post('produto_id', TRUE);
		$login_id = $this->input->get_post('login_id', TRUE) ? $this->input->get_post('login_id', TRUE) : $_SESSION['login_id'];
		
		if (strlen($catId) > 0) {
			$custos = $this->MCusto->findCustosByCategoria($catId, $login_id);
			if(count($custos) > 0){
				$return = array(
				                'success' => FALSE,
                				'msg'     => 'Possui '.count($custos).' custos associados a ela.');
			}else{
				$return = $this->MCategoria->excluirCategoria($catId, $login_id);
			}
		} else {
			$return = array(
                'success' => FALSE,
                'msg'     => 'Nenhum codigo de categoria para exclusao'
                );
		}
		print json_encode($return);
	}


	function getCategorias($userId = null){
		session_start();
		header('Content-type: application/json');
		$idUsu = $this->input->get_post('login_id', TRUE) ? $this->input->get_post('login_id', TRUE) : $userId;
		$login_id =  $idUsu ? $idUsu : $_SESSION['login_id'];
		$data['categorias'] = $this->MCategoria->findAllCategorias($login_id);
		print json_encode($data);
	}

}

?>