<?php

class MCategoria extends Model{
	function MCategoria(){
		parent::Model();
	}

	function incluir($data){
		if (isset($data['produto_id']) && $data['produto_id'] > 0){
			$this->db->set($data);
			$this->db->where('produto_id', $data['produto_id']);
			$this->db->update('produto_id');
			return $data['produto_id'];
		}else{
			$this->db->insert('produto', $data);
			return  $this->db->insert_id();
		}
	}

	function excluirCategoria($produto_id = null){
		if ($produto_id) {
			$this->db->where('produto_id', $produto_id);
			$this->db->delete('produto');
		}
		return array('success'=>TRUE);
	}

	function findAllCategorias($produto_id){
		$data = array();
		$this->db->where('produto_id = ', $produto_id);
		$Q = $this->db->get('produto');
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[] = $row;
			}
		}
		$Q->free_result();
		return $data;
	}
}
?>