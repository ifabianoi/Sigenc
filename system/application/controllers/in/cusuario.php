<?php

class CUsuario extends MY_Controller {

	function CUsuario(){
		parent::MY_Controller();
	}

	function index(){
	}
	
	function isAutenticate(){
		if(isUserAutenticate()){
			print '{"sucess": true}';
		}else{
			print '{"sucess": false}';
		}
	}

	function cadastrar(){
		header('Content-type: application/json');
		$data = array(
		    'login_id'  => $this->input->get_post('login_id', TRUE),
            'nome' 		=> $this->input->get_post('nome', TRUE),
            'email' 	=> $this->input->get_post('email', TRUE),
            'login' 	=> $this->input->get_post('login', TRUE),
			'senha' 	=> $this->input->get_post('senha', TRUE),
		);


		$usuario = $this->MUsuario->findByEmail($data['email']);

		if($usuario){
			$dataRet['success'] = false;
			$dataRet['msg'] = 'J&aacute; existe um usu&aacute;rio cadastrado com o email informado!';
			$dataRet['usuario'] = $usuario;
			print json_encode($dataRet);
		}else{
			$usuario = $this->MUsuario->findByUserName($data['login']);
			if($usuario){
				$dataRet['success'] = false;
				$dataRet['msg'] = 'J&aacute; existe um usu&aacute;rio cadastrado com o login informado!';
				$dataRet['usuario'] = $usuario;
				print json_encode($dataRet);
			}else{
				

				$usuarioEmail = $data;

				$data['senha'] = md5($data['senha']);

				$usuario = $this->MUsuario->incluirAlterar($data);

				$dataRet['success'] = true;
				$dataRet['usuario'] = $usuario;
				print json_encode($dataRet);
				$this-> cadastrarCategoriasPadroes($usuario['login_id']);
				$this -> enviarEmailBemVindo($usuarioEmail);
			}
		}
	}

	function cadastrarProdutosPadroes($produto_id){
		$produto = array(
            'descricao'		        => utf8_encode('Alimentação'),
			'produto_id'	            => $produto_id
		);
		$this->MCategoria->incluir($produto);

		$produto = array(
            'descricao'         => utf8_encode('Higine/Limpeza'),
            'produto_id'	            => $produto_id
		);
		$this->MCategoria->incluir($produto);

		$produto = array(
            'descricao'         => utf8_encode('Moradia'),
            'produto_id'	            => $produto_id
		);
		$this->MCategoria->incluir($produto);

		$produto = array(
            'descricao'         => utf8_encode('Transporte'),
			'produto_id'	            => $produto_id
		);
		$this->MCategoria->incluir($produto);

		$produto = array(
            'descricao'         => utf8_encode('Saúde'),
            'produto_id'	            => $produto_id
		);
		$this->MCategoria->incluir($produto);

		$produto = array(
            'descricao'         => utf8_encode('Estudos'),
            'produto_id'	            => $produto_id
		);
		$this->MCategoria->incluir($produto);
	}

	function atualizar(){
		header('Content-type: application/json');
		$data = array(
		    'login_id'  => $this->input->get_post('login_id', TRUE),
            'nome'  	=> $this->input->get_post('nome', TRUE),
            'email'  	=> $this->input->get_post('email', TRUE),
            'login' 	=> $this->input->get_post('login', TRUE),
			'senha' 	=> $this->input->get_post('senha', TRUE),
		);

		$data['senha'] = md5($data['senha']);

		$usuario = $this->MUsuario->incluirAlterar($data);

		$dataRet['success'] = true;
		$dataRet['usuario'] = $usuario;
		print json_encode($dataRet);

	}

	function findById(){
		header('Content-type: application/json');
		$login_id  = $this->input->get_post('login_id', TRUE);
		$usuario = $this->MUsuario->findById($login_id);
		$usuario['senha'] = null;

		$return = array(
                'success' => true,
                'data'    => $usuario
		);
		print json_encode($return);
	}

	function recuperarSenha(){
		header('Content-type: application/json');
		$email = $this->input->get_post('email', TRUE);
		if ($email){
			$usuario = $this->MUsuario->findByEmail($email);
			if($usuario){
				$usuario['senha'] = $this->gerar_senha(8,true,true,false,false);
				$usuBase = $usuario;

				$usuario['senha'] = md5($usuario['senha']);

				$login_id =  $this->MUsuario->incluirAlterar($usuario);

				if($login_id && ($login_id > 0)){
					$this->enviarEmailRecuperacaoSenha($usuBase);
					$data['success'] = true;
					print json_encode($data);
				}
			}else{
				$data['success'] = false;
				$data['msg'] = 'N&atilde;o foi encontrado usu&aacute;rio para o email informado!';
				print json_encode($data);
			}
		}else{
			$data['success'] = false;
			$data['msg'] = 'E necessario informar um email para recuperar a senha!';
			print json_encode($data);
		}
	}

	function enviarEmailRecuperacaoSenha($usuario){
		$this->email->from('sigenc@gmail.com', 'Sigenc');
		$this->email->to($usuario['emailUsuario']);
		$this->email->bcc('sigenc@gmail.com');

		$this->email->subject('Sua nova senha!');
		$this->email->message('
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
       		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
				<head>
				</head>
				<body>
					Ol&aacute; '.$usuario['nome'].', segue abaixo seus dados para acesso ao sistema Sigenc.
				<p>Usu&aacute;rio: '.$usuario['login'].'</p>
				<p>Senha: '.$usuario['senha'].'</p>
				</body>
			</html>
		');	

		$this->email->send();
	}

	function enviarEmailBemVindo($usuario){
		$this->email->from('sigenc@gmail.com', 'Sigenc');
		$this->email->to($usuario['emailUsuario']);
		$this->email->bcc('sigenc@gmail.com');

		$this->email->subject('Bem vindo ao sistema Sigenc');
		$this->email->message('
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
       		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
				<head>
				</head>
				<body>
					Ol&aacute; '.$usuario['nome'].', segue abaixo seus dados para acesso ao sistema Sigenc.
				<p>Usu&aacute;rio: '.$usuario['login'].'</p>
				<p>Senha: '.$usuario['senha'].'</p>
				</body>
			</html>
		');	

		$this->email->send();
	}

	function gerar_senha($tamanho, $maiuscula, $minuscula, $numeros, $codigos){
		$maius = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
		$minus = "abcdefghijklmnopqrstuwxyz";
		$numer = "0123456789";
		$codig = '!@#$%&*()-+.,;?{[}]^><:|';
			
		$base = '';
		$base .= ($maiuscula) ? $maius : '';
		$base .= ($minuscula) ? $minus : '';
		$base .= ($numeros) ? $numer : '';
		$base .= ($codigos) ? $codig : '';
			
		srand((float) microtime() * 10000000);
		$senha = '';
		for ($i = 0; $i < $tamanho; $i++) {
			$senha .= substr($base, rand(0, strlen($base)-1), 1);
		}
		return $senha;
	}
}

?>