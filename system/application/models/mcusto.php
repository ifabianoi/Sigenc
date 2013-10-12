<?php

class MCusto extends Model{
	function MCusto(){
		parent::Model();
	}

	function incluir($data){
		if (isset($data['idCusto']) && $data['idCusto'] > 0){
			$this->db->set($data);
			$this->db->where('idCusto', $data['idCusto']);
			$this->db->update('custo');
			return $data['idCusto'];
		}else{
			$this->db->insert('custo', $data);
			$idCusto = $this->db->insert_id();
			return $idCusto;
		}
	}

	function findAllCustos($login_id){
		$data = array();
		$this->db->from('custo');
		$this->db->where('login_id = ', $login_id);
		$Q = $this->db->get('custo');
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[] = $row;
			}
		}
		$Q->free_result();
		return $data;
	}

	function findCustosByPeriod($dataInicial, $dataFinal, $login_id){
		$data = array();
		$this->db->from('custo');
		$this->db->join('produto', 'produto.produto_id = custo.idCategoriaGasto');
		$this->db->join('parcelas', 'parcelas.idCusto = custo.idCusto');
		if(isset($dataInicial) && isset($dataFinal)){
			$this->db->where('dataVencimento >= ',convertDateMysql($dataInicial));
			$this->db->where('dataVencimento <=',convertDateMysql($dataFinal));
		}
		$this->db->where('custo.login_id = ', $login_id);
		$this->db->order_by("descricao", "asc"); 
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$row['dataVencimento'] = convertDateNoSql($row['dataVencimento']);
				$data[] = $row;
			}
		}
		$Q->free_result();
		return $data;
	}

	function findCustosByParameters($baseBusca, $login_id){
		$data = array();
		$this->db->from('custo');
		$this->db->join('produto', 'produto.produto_id = custo.idCategoriaGasto');
		$this->db->join('parcelas', 'parcelas.idCusto = custo.idCusto');
		if(isset($baseBusca['dataInicial']) && isset($baseBusca['dataFinal'])){
			$this->db->where('dataVencimento >= ',convertDateMysql($baseBusca['dataInicial']));
			$this->db->where('dataVencimento <=',convertDateMysql($baseBusca['dataFinal']));
		}

		if(isset($baseBusca['idCategoriaGasto']) && $baseBusca['idCategoriaGasto'] > 0){
			$this->db->where('idCategoriaGasto = ', $baseBusca['idCategoriaGasto']);
		}

		if(isset($baseBusca['descricaoGasto']) && strlen($baseBusca['descricaoGasto']) > 0){
			$this->db->like('descricaoGasto', $baseBusca['descricaoGasto']);
		}

		$this->db->where('custo.login_id = ', $login_id);

		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$row['dataVencimento'] = convertDateNoSql($row['dataVencimento']);
				$data[] = $row;
			}
		}
		$Q->free_result();
		return $data;
	}

	function findCustosByCategoria($produto_id = null, $login_id){
		$data = array();
		$this->db->from('custo');
		$this->db->where('idCategoriaGasto = ', $produto_id);
		$this->db->where('login_id = ', $login_id);
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[] = $row;
			}
		}
		$Q->free_result();
		return $data;
	}

	function findCustosByData($dataAtual, $login_id){
		$data = array();
		$this->db->from('custo');
		$this->db->join('produto', 'produto.produto_id = custo.idCategoriaGasto');
		$this->db->join('parcelas', 'parcelas.idCusto = custo.idCusto');
		$this->db->where('dataVencimento = ', convertDateMysql($dataAtual));
		$this->db->where('custo.login_id = ', $login_id);

		$Q = $this->db->get();

		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[] = $row;
			}
		}
		$Q->free_result();
		return $data;
	}

	function getQuantParcelasByCost($idCusto){
		$this->db->from('parcelas');
		$this->db->where('idCusto = ', $idCusto);
		$Q = $this->db->get();

		$count = $Q->num_rows();

		$Q->free_result();

		return $count;
	}

	function deleteCostAndParcelas($idCusto = null, $idParcela = null){
		$this->db->where('idCusto', $idCusto);
		if ($idParcela) {
			$this->db->where('numeroParcela', $idParcela);
		}
		$this->db->delete('parcelas');

		$this->db->where('idCusto', $idCusto);
		$this->db->delete('custo');

		return true;
	}

	function buscarSomaCustosPeriodo($dataInicial, $dataFinal, $login_id){
		$this->db->select_sum('valorParcela');
		$this->db->from('custo');
		$this->db->join('parcelas', 'parcelas.idCusto = custo.idCusto');
		if(isset($dataInicial) && isset($dataFinal)){
			$this->db->where('dataVencimento >= ',convertDateMysql($dataInicial));
			$this->db->where('dataVencimento <=',convertDateMysql($dataFinal));
		}
		$this->db->where('custo.login_id = ', $login_id);
		$query = $this->db->get();
		return $query->row()->valorParcela;
	}

	/**
	 * Retorna uma lista de custos de acordo com o periodo informado de acordo com o código do produto e código do usuário
	 * @param $dataInicio
	 * @param $dataFinal
	 * @param $produto_id
	 * @param $login_id
	 */
	function findCustosByCategoryAndPeriod($dataInicio, $dataFinal, $produto_id, $login_id){
		$data = array();
		$this->db->from('custo');
		$this->db->join('produto', 'produto.produto_id = custo.idCategoriaGasto');
		$this->db->join('parcelas', 'parcelas.idCusto = custo.idCusto');
		$this->db->where('dataVencimento >= ',convertDateMysql($dataInicio));
		$this->db->where('dataVencimento <=',convertDateMysql($dataFinal));
		$this->db->where('idCategoriaGasto = ', $produto_id);
		
		$this->db->where('custo.login_id = ', $login_id);

		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$row['dataVencimento'] = convertDateNoSql($row['dataVencimento']);
				$data[] = $row;
			}
		}
		$Q->free_result();
		return $data;
	}

	function buscarGastosCategoriaPeriodo($dataInicial, $dataFinal, $login_id){
		$data = array();
		$this->db->select(" produto_id, descricao, sum(p.valorParcela) as total from custo c
		join categoria cat on cat.produto_id = c.idCategoriaGasto 
		join parcelas p on p.idCusto = c.idCusto where 
			c.login_id=".$login_id." and
			p.dataVencimento between '".convertDateMysql($dataInicial)."' and '".convertDateMysql($dataFinal)."'
			group by descricao, produto_id");

		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[] = $row;
			}
		}
		$Q->free_result();
		return $data;
	}

	function buscarGastosCategoriaTotaisMensal($dataInicial, $dataFinal, $login_id){
		$data = array();
		$this->db->select(" date_format(p.dataVencimento, '%c/%Y') AS mes, sum(p.valorParcela) as total from custo c
		join produto prod on prod.produto_id = c.idCategoriaGasto
		join parcelas p on p.idCusto = c.idCusto where
			c.login_id=".$login_id." and
			p.dataVencimento between '".convertDateMysql($dataInicial)."' and '".convertDateMysql($dataFinal)."'
			group by mes order by p.dataVencimento");

		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[] = $row;
			}
		}
		$Q->free_result();
		return $data;
	}
	
	function buscarGastosCategoriaTotaisPeriodo($dataInicial, $dataFinal, $login_id){
		$data = array();
		$this->db->select(" sum(p.valorParcela) as total, prod.descricao as produto from custo c
		join produto prod on prod.produto_id = c.idCategoriaGasto
		join parcelas p on p.idCusto = c.idCusto where
			c.login_id=".$login_id." and 
			p.dataVencimento between '".convertDateMysql($dataInicial)."' and '".convertDateMysql($dataFinal)."'
			group by produto order by p.dataVencimento");

		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[] = $row;
			}
		}
		$Q->free_result();
		return $data;
	}
	

	function buscarCategoriasMes($dataInicial, $dataFinal, $login_id){
		$data = array();
		$this->db->select(" distinct descricao, produto_id from custo c
		join produto prod on prod.produto_id = c.idCategoriaGasto
		join parcelas p on p.idCusto = c.idCusto where
			c.login_id=".$login_id." and
			p.dataVencimento between '".convertDateMysql($dataInicial)."' and '".convertDateMysql($dataFinal)."'
     	 order by descricao", false);

		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[] = $row;
			}
		}

		$Q->free_result();
		return $data;
	}

	function buscarGastosCategoriaMensal($dataInicial, $dataFinal, $login_id, $produto_id){
		$data = array();
		$this->db->select(" descricao, date_format(p.dataVencimento, '%c/%Y') AS mes, sum(p.valorParcela) as total from custo c
		join produto prod on prod.produto_id = c.idCategoriaGasto
		join parcelas p on p.idCusto = c.idCusto where
			c.login_id=".$login_id." and
			prod.produto_id = ".$produto_id." and
			p.dataVencimento between '".convertDateMysql($dataInicial)."' and '".convertDateMysql($dataFinal)."'
			group by descricao, mes
			order by p.dataVencimento", false);

		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
				$data[] = $row;
			}
		}
		$Q->free_result();
		return $data;
	}
	

	/**
	 * Retorna a somatoria de custo e entradas agrupado por mes
	 * Enter description here ...
	 * @param $dataInicial
	 * @param $dataFinal
	 * @param $login_id
	 */
	function buscarCustosEntradaAgrupadosMes($dataInicial, $dataFinal, $login_id){
		$data = array();
		$this->db->select(" sum(valorParcela) custoSoma, 
		       (select sum(valorEntrada) from entrada where date_format(dataEntrada, '%c/%Y') = date_format(dataVencimento, '%c/%Y')
		        and login_id = 1) as entradaSoma, 
		       date_format(dataVencimento, '%c/%Y') as mes
		from custo join parcelas on(custo.idCusto = parcelas.idCusto) 
		where custo.login_id=".$login_id." and
		dataVencimento between '".convertDateMysql($dataInicial)."' and '".convertDateMysql($dataFinal)."'
		group by mes
		order by dataVencimento", false);

		$Q = $this->db->get();
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