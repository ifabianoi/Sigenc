<?php

class MEntrada extends Model{
	function MEntrada(){
		parent::Model();
	}

	function findAll($login_id){
		$data = array();
		$this->db->where('login_id = ', $login_id);
		$Q = $this->db->get('entrada');

		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$row['dataEntrada'] = convertDateNoSql($row['dataEntrada']);
				$data[] = $row;
			}
		}

		$Q->free_result();
		return $data;
	}

	/**
	 * Incluir ou atualiza uma entrada no banco de dados
	 * @param $data
	 */
	function incluir($data){
		$data['dataEntrada'] = convertDateMysql($data['dataEntrada']);
		$data['valorEntrada'] = convertNumberMysql($data['valorEntrada']);
		if (isset($data['idEntrada']) && $data['idEntrada'] > 0){
			$this->db->set($data);
			$this->db->where('idEntrada', $data['idEntrada']);
			$this->db->update('entrada');
		}else{
			$this->db->insert('entrada', $data);
			$data['idEntrada'] = $this->db->insert_id();
		}
		$data['dataEntrada'] = convertDateNoSql($data['dataEntrada']);
		return  $data;
	}

	function excluir($idEntrada = null, $login_id){
		if ($idEntrada) {
			$this->db->where('idEntrada', $idEntrada);
			$this->db->where('login_id', $login_id);
			$this->db->delete('entrada');
		}
	}

	function buscarSomaEntradasPeriodo($dataInicial, $dataFinal, $login_id){
		$this->db->select_sum('valorEntrada');
		$this->db->from('entrada');
		if(isset($dataInicial) && isset($dataFinal)){
			$this->db->where('dataEntrada >= ',convertDateMysql($dataInicial));
			$this->db->where('dataEntrada <=',convertDateMysql($dataFinal));
		}
		$this->db->where('login_id = ', $login_id);
		$query = $this->db->get();
		return $query->row()->valorEntrada;
	}

}
?>