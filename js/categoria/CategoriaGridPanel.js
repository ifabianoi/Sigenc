Ext.ns('categoria');

categoria.CategoriaGridPanel = Ext.extend(Ext.grid.GridPanel, {
			url : 'in/ccategoria/getCategorias',
			viewConfig : {
				forceFit : true
			},
			selModel : new Ext.grid.RowSelectionModel({singleSelect: true}),
			columns : [{
						header : 'C&oacute;digo',
						dataIndex : 'produto_id',
						sortable : true
					}, {
						header : 'Descri&ccedil;&atilde;o',
						dataIndex : 'descricao',
						sortable : true
					}],

			initComponent : function() {
				this.store = this.buildStore();
				categoria.CategoriaGridPanel.superclass.initComponent
						.call(this);
			},

			buildStore : function() {
				return {
					xtype : 'jsonstore',
					autoLoad : true,
					root : 'produtos',
					proxy : new Ext.data.HttpProxy({
								method : 'POST',
								scope : this,
								prettyUrls : false,
								url : this.url
							}),
					fields : ['produto_id', 'descricao'],
					sortInfo : {
						field : 'produto_id',
						dir : 'ASC'
					}
				};
			},

			add : function(rec) {
				var store = this.store;
				var sortInfo = store.sortInfo;

				if (Ext.isArray(rec)) {
					Ext.each(rec, function(rObj, ind) {
								if (!(rObj instanceof Ext.data.Record)) {
									rec[ind] = new this.store.recordType(rObj);
								}
							});
				} else if (Ext.isObject(rec)
						&& !(rec instanceof Ext.data.Record)) {
					rec = new this.store.recordType(rec);
				}

				store.add(rec);
				store.sort(sortInfo.field, sortInfo.direction);
			},
			loadData : function(d) {
				return this.store.loadData(d);
			},
			load : function(o) {
				return this.store.load(o);
			},
			removeAll : function() {
				return this.store.removeAll();
			},

			remove : function(r) {
				return this.store.remove(r);
			},
			getSelected : function() {
				return this.selModel.getSelections()[0];
			},
			createAndSelectRecord : function(o) {
				var record = new this.store.recordType(o);
				this.store.addSorted(record);
				var index = this.store.indexOf(record);
				this.getSelectionModel().selectRow(index);
				return record;
			}
		});

Ext.reg('categoriaGridPanel', categoria.CategoriaGridPanel)