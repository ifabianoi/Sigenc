Ext.ns("custo");

custo.EditCustoFormPanel = Ext.extend(form.FormularioBase, {
			initComponent : function() {
				Ext.apply(this, {
							id : 'formCustosEdit',
							itemId : 'formCustosEdit',
							frame : true,
							labelAlign : 'right',
							labelWidth : 120,
							width : 340,
							layout : 'form',
							title: 'Dados do custo',
							defaultType : 'textfield',
							items : [{
										fieldLabel : 'C&oacute;digo',
										name : 'idCusto',
										id : 'idCusto',
										width : 50,
										readOnly : true,
										cls: 'readonly'
									}, {
										fieldLabel : 'Descri&ccedil;&atilde;o',
										name : 'descricaoGasto',
										id : 'descricaoGasto',
										width : 200,
										allowBlank : false
									}, new Ext.form.ComboBox({
												store : todasCategoriasStore,
												displayField : 'descricao',
												valueField : 'produto_id',
												mode : 'local',
												hiddenName : 'idCategoriaGasto',
												valueField : 'produto_id',
												forceSelection : false,
												triggerAction : 'all',
												fieldLabel : 'Produto',
												name : 'idCategoriaGasto',
												allowBlank : false
											}), new Ext.form.DateField({
												fieldLabel : 'Vencimento',
												name : 'dataVencimento',
												id : 'dataVencimento',
												width : 100,
												allowBlank : false
											}), {
										xtype : 'moneyfield',
										fieldLabel : 'Valor',
										id : 'valorParcela',
										name : 'valorParcela',
										width : 80,
										readOnly : true,
										allowBlank : false,
										tabIndex : 5,
										listeners : {
											render: function(cmp){
												cmp.setValue(formataMoeda(cmp.value));
											}
										}
									},{
										xtype : 'hidden',
										id : 'numeroParcela',
										name : 'numeroParcela',
										allowBlank : false
									}]
						});
				custo.EditCustoFormPanel.superclass.initComponent.call(this);
			}
		});

Ext.reg('editCustoFormPanel', custo.EditCustoFormPanel);