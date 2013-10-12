Ext.ns('dashboard');

dashboard.CustosDiaGridPanel = Ext.extend(Ext.grid.GridPanel, {
			url : 'in/ccusto/buscarCustosDia',
			viewConfig : {
				forceFit : true,
				emptyText : '<center>Nenhuma Encomenda para a data de Hoje('
						+ getDataAtual() + ')</center>'
			},
			tbar : [{
						text : 'Nova Encomenda',
						iconCls : 'icone-adicionar',
						scope : this,
						handler : function() {
							winCusto = new custo.CustoWindow({});
							winCusto.show();
						}
					}],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			columns : [{
				header : 'Descri&ccedil;&atilde;o',
				dataIndex : 'descricaoGasto',
				sortable : true,
				summaryType : 'count',
				width: 230,
				summaryRenderer : function(v, params, data) {
					return ((v === 0 || v > 1)
							? '(' + v + ' Encomenda)'
							: '(1 Custo)');
				}
			}, {
				header : 'Produto',
				dataIndex : 'descricao',
				sortable : true
			}, {
				header : 'Rota',
				dataIndex : 'numeroParcela',
				sortable : false,
				width: 60
			}, {
				header : 'Motorista',
				dataIndex : 'valorParcela',
				sortable : true,
				renderer : 'brMoney',
				summaryType : ''
			},{
				header : 'Envio',
				dataIndex : 'valorParcela',
				sortable : true,
				renderer : 'brMoney',
				summaryType : ''
			},{
				header : 'Recebimento',
				dataIndex : 'valorParcela',
				sortable : true,
				renderer : 'brMoney',
				summaryType : ''
			},{
				header : 'Status',
				dataIndex : 'valorParcela',
				sortable : true,
				renderer : 'brMoney',
				summaryType : ''
			}],

			initComponent : function() {
				this.store = this.buildStore();
				dashboard.CustosDiaGridPanel.superclass.initComponent
						.call(this);
			},

			buildStore : function() {
				return {
					xtype : 'jsonstore',
					root : 'custos',
					autoLoad : true,
					proxy : new Ext.data.HttpProxy({
								method : 'POST',
								scope : this,
								prettyUrls : false,
								url : this.url
							}),
					fields : ['descricaoGasto', 'descricao',
							'numeroParcela', 'valorParcela'],
					sortInfo : {
						field : 'descricaoGasto',
						dir : 'ASC'
					}
				};
			}
		});

Ext.reg('custosDiaGridPanel', dashboard.CustosDiaGridPanel)