<script type="text/javascript">

function novo(){
	$("#produto_id").val('');
	$("#descricaoProduto").val('');
}

function cadastrar(){
	var descCateg = $("#descricaoProduto").val();
	//var descCompCateg = $("#descCompletaCategoria").val();
	var url = urlApp+'in/ccategoria/cadastrar';
	$("#appCorpo").mask("Gravando categoria, aguarde...");
	$.post(url, {descricao:descCateg}, cadastrarApos, "json");
}

function cadastrarApos(data, result){
	if(data.success){
		$("#produto_id").val(data.produto_id);
		$("#appCorpo").unmask();
		alert('Cadastro efetuado com sucesso!');
	}else{
		$("#appCorpo").unmask();
		alert('Erro ao cadastrar gasto!');
	}
}
</script>

<div id="divCategoria">
	<table border="0" id="tblCategoria">
		<tr>
			<td> <label>C&oacute;digo</label> </td>
			<td> <input id="produto_id" name="produto_id" type="text" readonly="readonly" size="4" class="DISABLED"> </td>
		</tr>
		<tr>
			<td> <label>Descri&ccedil;&atilde;o</label> </td>
			<td> <input id="descricao" name="descricao" type="text" > </td>
		</tr>
	</table>
</div>

<div id="divPesquisa">
	<table border="0" id="tblPesquisa">

	</table>
</div>

