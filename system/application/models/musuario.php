<?php

class MUsuario extends Model{
	function MUsuario(){
		parent::Model();
	}

	function verificarUsuario($u,$pw){
		$this->db->select('login, login_id');
		$this->db->where('login',$u);
		$this->db->where('senha', md5($pw));
		$this->db->limit(1);
		$Q = $this->db->get('login');

		if ($Q->num_rows() > 0){
			return $Q->row_array();
		}else{
			return null;
		}
	}

	function findByEmail($email){
		$this->db->where('email', $email);
		$Q = $this->db->get('pessoa');
		return $Q->row_array();
	}
	
	function findByUserName($loginUsuario){
		$this->db->where('login', $loginUsuario);
		$Q = $this->db->get('login');
		return $Q->row_array();
	}
	
	function findById($login_id){
		$this->db->where('login_id', $login_id);
		$Q = $this->db->get('login');
		return $Q->row_array();
	}
	
	function incluirAlterar($data){
		if (isset($data['login_id']) && $data['login_id'] > 0){
			$this->db->set($data);
			$this->db->where('login_id', $data['login_id']);
			$this->db->update('login');
			$login_id = $data['login_id'];
		}else{
			$this->db->insert('login', $data);
			$login_id =   $this->db->insert_id();
		}
		
		$this->db->where('login_id', $login_id);
		$Q = $this->db->get('login');
		return $Q->row_array();
	}
}
?>