Ext.ns("principal");

principal.main = function() {
	var viewport, loginWindow, panelCusto, panelRelGastosPeriodo, categoriaManager, panelUsuario, dashboard, panelCategoria, winContato, pnlGastosEntradaMes, pnlGastosCategoriaMes;

	return {
		init : function() {
			if (!idUsrLgd || idUsrLgd == -1) {
				if (!loginWindow) {
					loginWindow = this.buildLoginWindow();
				}
				loginWindow.show();
			} else {
				this.buildViewport();
			}
		},

		buildLoginWindow : function() {
			return new login.LoginWindow({
				scope : this,
				handler : this.onLogin
			});
		},

		buildViewport : function() {
			viewport = new Ext.Viewport(
					{
						layout : 'border',
						renderTo : Ext.getBody(),
						items : [
								{
									region : "north",
									xtype : 'toolbar',
									height : 28,
									items : [ {
										xtype : 'tbbutton',
										text : 'Cadastros',
										iconCls : 'form-adicionar',
										menu : [ {
											text : 'Encomenda',
											iconCls : 'icone-pacote',
											handler : this.manterCusto
										}, {
											text : 'Produto',
											iconCls : 'icone-produto',
											handler : this.manterCategoria
										}, {
											text : 'Solicitacao',
											iconCls : 'icone-solicitacao',
											handler : this.manterCategoria
										}, {
											text : 'Motorista',
											iconCls : 'icone-motorista',
											handler : this.manterCategoria
										}, {
											text : 'Veiculo',
											iconCls : 'icone-veiculo',
											handler : this.manterCategoria
										}, {
											text : 'Rota',
											iconCls : 'icone-rota',
											handler : this.manterCategoria
										}, {
											text : 'Transportadora',
											iconCls : 'icone-transportadora',
											handler : this.manterCategoria
										},{
											text : 'Usu&aacute;rio',
											iconCls : 'icone-usuario',
											handler : this.manterUsuario
										}, {
											text : 'Filial',
											iconCls : 'icone-empresa',
											handler : this.manterUsuario
										} ]
									}, {
										xtype : 'tbseparator'
									}, {
										xtype : 'tbbutton',
										text : 'Relat&oacute;rios',
										iconCls : 'icone-relatorio',
										menu : [ {
											text : 'Encomendas Entregues',
											iconCls : 'relatorio-ir',
											handler : this.relGastosPeriodo
										}, {
											text : 'Encomendas Atrasadas',
											iconCls : 'relatorio-ir',
											handler : this.relatorioGastosEntradasMes
										}, {
											text : 'Todas Encomendas',
											iconCls : 'relatorio-ir',
											handler : this.relatorioGastosCategoriaMes
										}, {
											text : 'Produtos',
											iconCls : 'relatorio-ir',
											handler : this.relatorioGastosCategoriaMes
										} , {
											text : 'Funcionarios',
											iconCls : 'relatorio-ir',
											handler : this.relatorioGastosCategoriaMes
										}, {
											text : 'Veiculos',
											iconCls : 'relatorio-ir',
											handler : this.relatorioGastosCategoriaMes
										} , {
											text : 'Todas Encomendas',
											iconCls : 'relatorio-ir',
											handler : this.relatorioGastosCategoriaMes
										}   ]
									}, {
										xtype : 'tbseparator'
									}, {
										xtype : 'tbbutton',
										text : 'Ajuda',
										iconCls : 'icone-ajuda',
										menu : [ {
											text : 'Manual do Sistema',
											iconCls : 'icone-email-enviar',
											handler : function() {
												this.winContato = new contato.ContatoWindow({});
												this.winContato.show();
											}
										}, {
											text : 'Sobre o Sigenc',
											iconCls : 'icone-sifrao',
											handler : function() {
												new Ext.Window({
													title : 'Sigenc',
													width : 320,
													height : 200,
													iconCls : 'icone-sifrao',
													bodyStyle : 'padding : 2px;',
													modal : true,
													items : [ {
														vtype : 'component',
														layout : {
															type : 'vbox',
															align : 'left'
														},
														height : 200,
														bodyStyle : 'background:url(./img/logo_alpha.png) no-repeat center center;',
														items : [ {
															xtype : 'label',
															text : 'Sigenc Beta',
															cls : 'textAjuda'
														}, {
															xtype : 'label',
															text : 'Desenvolvido por: ADS 2011-ADS 2013',
															cls : 'textAjuda'
														}, {
															xtype : 'label',
															text : 'Email: sigenc@gmail.com',
															cls : 'textAjuda'
														} ]
													} ]
												}).show();
											}
										} ]
									}, '->', {
										text : 'Sair',
										iconCls : 'porta-fora',
										scope : this,
										handler : this.onLogOut
									} ]
								},
								{
									region : 'center',
									xtype : 'tabpanel',
									id : 'tabPanelForms',
									border : false
								},
								{
									region : 'south',
									xtype : 'panel',
									id : 'statusBar',
									html : '<p align="center" class="fonte10px">Sigenc Beta</p>',
									frame : true
								} ]
					});
			Ext.getBody().unmask();
			this.criarDash();
		},
		onLogin : function() {
			var form = loginWindow.get(0);
			if (form.getForm().isValid()) {
				loginWindow.el.mask('Por favor aguarde...', 'x-mask-loading');

				form.getForm().submit({
					success : this.onLoginSuccess,
					failure : this.onLoginFailure,
					scope : this
				});
			}
		},

		onLoginSuccess : function() {
			if (!Ext.isIE) {
				var cookie = Ext.util.Cookies.get('login_id');
				idUsrLgd = cookie;
				if (idUsrLgd) {
					todasCategoriasStore.load();
					this.buildViewport();
					loginWindow.destroy();
					loginWindow = null;
				} else {
					loginWindow.el.unmask();
					exibeErro('Seu navegador est&aacute; com os Cookies desabilitados, por favor habilite!'
							+ '\nSe voc&ecirc; estiver utilizando internet explorer, utilize outro browser que funciona!');
				}
			} else {
				location.reload(true);
			}

		},

		onLoginFailure : function(form, action) {
			loginWindow.el.unmask();
			switch (action.failureType) {
			case Ext.form.Action.CLIENT_INVALID:
				exibeErro('Os campos do formul�rio est�o inv�lidos.');
				break;
			case Ext.form.Action.CONNECT_FAILURE:
				exibeErro('Ocorreu um erro de comunica��o com o servidor.');
				break;
			case Ext.form.Action.SERVER_INVALID:
				exibeErro(action.result.msg);
			default:
				exibeErro("Login ou senha inv&aacute;lidos, tente novamente!");
			}
		},

		onLogOut : function() {
			Ext.MessageBox.confirm('Por favor confirme!', 'Tem certeza que deseja sair do sistema?', function(btn) {
				if (btn === 'yes') {
					this.doLogOut();
				}
			}, this);
		},
		doLogOut : function() {
			Ext.getBody().mask('Saindo do sistema...', 'x-mask-loading');

			Ext.Ajax.request({
				url : 'app/logout',
				method : 'POST',
				scope : this,
				success : this.aposLogout
			});
		},
		aposLogout : function() {
			this.destroy();
		},

		destroy : function() {
			viewport.destroy();
			viewport = null;
			panelCusto = null;
			panelRelGastosPeriodo = null;
			dashboard = null;
			window.location = urlApp;
		},

		criarDash : function() {
			dashboard = new Ext.ux.Portal(
					{
						xtype : 'portal',
						id : 'dashPortal',
						itemId : 'dashPortal',
						title : 'Visao Geral',
						margins : '35 5 5 0',
						items : [
								{
									columnWidth : .99,
									style : 'padding:10px 0 10px 10px',
									items : [
											{
												title : 'Encomendas',
												items : [ {
													xtype : 'custosDiaGridPanel',
													id : 'custosDiaGridPanel',
													plugins : new Ext.ux.grid.GridSummary(),
													height : 242
												} ]
											},
										//	{
										//		title : 'Download do Sistema Para Celular',
										//		html : '<div align="center" style="cursor: pointer;" onclick="window.open(urlApp+\'distappme/dist.zip\');"><img alt="Download do Aplicativo para Celular" src="./img/celularDownload.png" align="middle"/></div>'
										//	}
											]

								}, {
									columnWidth : .33,
									style : 'padding:10px 0 10px 10px',
									items : [ {
										id : 'entradaCustoGraf',
										title : 'Encomendas Entregues',
										height : 260,
										html : '<div id="divGraf"></div>'
									} ]
								}, {
									columnWidth : .33,
									style : 'padding:10px 0 10px 10px',
									items : [ {
										id : 'grafCustosCategoriaMes',
										title : 'Encomenda Atrasadas',
										height : 260,
										html : '<div id="divGrafGastosCategoria"></div>'
									}]
									}, {
										columnWidth : .33,
										style : 'padding:10px 0 10px 10px',
										id : 'custosCatMesPanel',
										height : 270,
										items : [ {
											xtype : 'custosCatMesGridPanel',
											id : 'custosCatMesGridPanel',
											title : 'Encomendas do M&ecirc;s: Clique no Gr&aacute;fico',
											plugins : new Ext.ux.grid.GridSummary(),
											height : 260
										}] 
									} 
								 ]

					});
			Ext.getCmp('tabPanelForms').add(dashboard);
			Ext.getCmp('tabPanelForms').activate(dashboard);

			// montar os gr�ficos
			this.montaGrafico();
			this.montaGraficoCustosCategoria();

		},

		montaGrafico : function() {
			var chartEntCust = new NeoCharts(urlApp
					+ "charts/Column3D.swf?ChartNoDataText=Nenhum Gasto ou Entrada para visualiza&ccedil;&atilde;o.", "chart1Id", "100%",
					"100%", "0", "1");
			chartEntCust.setDataURL("in/ccusto/geraGraficoEntradasCustos");
			chartEntCust.render("divGraf");
		},

		montaGraficoCustosCategoria : function() {
			var chartEntCust = new NeoCharts(urlApp + "charts/Column3D.swf?ChartNoDataText=Nenhum gasto lan&ccedil;ado este m&ecirc;s.",
					"chart2Id", "100%", "100%", "0", "1");
			chartEntCust.setDataURL("in/ccusto/geraGraficoCustosCategoria");
			chartEntCust.render("divGrafGastosCategoria");
		},

		relGastosPeriodo : function() {
			Ext.require([ 'relatorios/gastosperiodo/GridGastosPeriodo', 'relatorios/gastosperiodo/GraficoGastosPeriodo',
					'relatorios/gastosperiodo/GastosPeriodo' ], function() {
				if (Ext.getCmp('tabPanelForms').get('pnlGastosPeriodo') == null) {
					panelRelGastosPeriodo = new relatorio.PnlGastosPeriodo({});
					Ext.getCmp('tabPanelForms').add(panelRelGastosPeriodo);
					Ext.getCmp('tabPanelForms').activate(panelRelGastosPeriodo);
				} else {
					Ext.getCmp('tabPanelForms').activate(panelRelGastosPeriodo);
				}
			});
		},

		manterCategoria : function() {
			Ext.require([ 'categoria/CategoriaFormPanel', 'categoria/CategoriaGridPanel',
			              'categoria/CategoriaManagerPanel'], function() {
				if (Ext.getCmp('tabPanelForms').get('pnlManterCategoria') == null) {
					categoriaManager = new categoria.CategoriaManagerPanel({});
					Ext.getCmp('tabPanelForms').add(categoriaManager);
					Ext.getCmp('tabPanelForms').activate(categoriaManager);
				} else {
					Ext.getCmp('tabPanelForms').activate(categoriaManager);
				}
			});
		},

		manterUsuario : function() {
			Ext.require([ 'usuario/UsuarioFormPanel', 'usuario/UsuarioManagerPanel' ], function() {
				if (Ext.getCmp('tabPanelForms').get('formCadUsu') == null) {
					panelUsuario = new usuario.UsuarioManagerPanel({});
					Ext.getCmp('tabPanelForms').add(panelUsuario);
					Ext.getCmp('tabPanelForms').activate(panelUsuario);
				} else {
					Ext.getCmp('tabPanelForms').activate(panelUsuario);
				}
			});
		},

		manterCusto : function() {
			Ext.require([ 'custo/CustoGridPanel', 'custo/FiltroCustoFormPanel', 'custo/CustoManagerPanel' ], function() {
				if (Ext.getCmp('tabPanelForms').get('pnlManterCusto') == null) {
					panelCusto = new custo.CustoManagerPanel({});
					Ext.getCmp('tabPanelForms').add(panelCusto);
					Ext.getCmp('tabPanelForms').activate(panelCusto);
				} else {
					Ext.getCmp('tabPanelForms').activate(panelCusto);
				}
			});
		},

		manterEntrada : function() {
			Ext.require([ 'entrada/EntradaFormPanel', 'entrada/EntradaGridPanel', 'entrada/EntradaManagerPanel' ], function() {
				if (Ext.getCmp('tabPanelForms').get('pnlManterEntrada') == null) {
					panelCategoria = new entrada.EntradaManagerPanel({});
					Ext.getCmp('tabPanelForms').add(panelCategoria);
					Ext.getCmp('tabPanelForms').activate(panelCategoria);
				} else {
					Ext.getCmp('tabPanelForms').activate(panelCategoria);
				}
			});
		},
		relatorioGastosEntradasMes : function() {
			Ext.require([ 'relatorios/gastosmensalagrupado/GraficoGastosEntradaMes', 'relatorios/gastosmensalagrupado/GastosEntradasMes' ],
					function() {
						if (Ext.getCmp('tabPanelForms').get('pnlGastosEntradaMes') == null) {
							pnlGastosEntradaMes = new relatorio.PnlGastosEntradaMes({});
							Ext.getCmp('tabPanelForms').add(pnlGastosEntradaMes);
							Ext.getCmp('tabPanelForms').activate(pnlGastosEntradaMes);
						} else {
							Ext.getCmp('tabPanelForms').activate(pnlGastosEntradaMes);
						}
					});
		},
		relatorioGastosCategoriaMes : function() {
			Ext.require([ 'relatorios/gastoscategoriamensal/GraficoGastosCategoriaMes',
					'relatorios/gastoscategoriamensal/GastosCategoriaMes' ], function() {
				if (Ext.getCmp('tabPanelForms').get('pnlGastosCategoriaMes') == null) {
					pnlGastosCategoriaMes = new relatorio.PnlGastosCategoriaMes({});
					Ext.getCmp('tabPanelForms').add(pnlGastosCategoriaMes);
					Ext.getCmp('tabPanelForms').activate(pnlGastosCategoriaMes);
				} else {
					Ext.getCmp('tabPanelForms').activate(pnlGastosCategoriaMes);
				}
			});
		}
	};
}();
