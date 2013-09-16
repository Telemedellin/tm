"use strict";
jQuery(function($) {
    //Modelos
	window.Album = Backbone.Model.extend({
		urlRoot: '/tm/api/fotoalbum',
        defaults: {
		    id: '', 
            nombre : '',
		    url : '',
            thumb: ''
		}
	});

    window.Foto = Backbone.Model.extend({
       urlRoot: '/tm/api/foto',
        defaults: {
            id: '', 
            nombre : '', 
            album_foto : '',
            src : '',
            thumb: '',
            ancho: '',
            alto: ''
        } 
    });

    //Colecciones
	window.AlbumCollection = Backbone.Collection.extend({
	    model : Album,
        url: '/tm/api/fotoalbum'
	});

    window.FotoCollection = Backbone.Collection.extend({
        model : Foto,
        url: '/tm/api/foto'
    });

    //Helpers
    var template = function(id){
        return _.template( $('#' + id).html() );
    };

    //Vistas
    window.AlbumListView = Backbone.View.extend({
        tagName: 'ul',
        className: 'albumes', 
        initialize:function () {
            this.collection.bind("reset", this.render, this);
            var self = this;
            this.collection.bind("add", function (album) {
                $(self.el).append(new AlbumListItemView({model:album}).render().el);
            });
        },
     
        render:function (eventName) {
            _.each(this.collection.models, function (album) {
                $(this.el).append(new AlbumListItemView({model:album}).render().el);
            }, this);
            return this;
        }
    });

    window.AlbumListItemView = Backbone.View.extend({
        tagName:"li",
        className: 'album', 
        template: template('albumListItemViewTemplate'),
        render:function (eventName) {
            console.log(this.model);
            $(this.el).html( this.template( this.model.toJSON() ) );
            return this;
        },
        close:function () {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });

    window.FotoListView = Backbone.View.extend({
        tagName: 'ul',
        template: template('fotoListViewTemplate'),
        initialize:function () {
            this.collection.bind("reset", this.render, this);
            var self = this;
            this.collection.bind("add", function (foto) {
                $(self.el).append(new FotoListItemView({model:foto}).render().el);
            });
        },
        events:{
            "click a.back": "back"
        },
        render:function (eventName) {
           _.each(this.collection.models, function (foto) {
                $(this.el).append(new FotoListItemView({model:foto}).render().el);
            }, this);
            return this;
        },
        back: function(e){
            e.preventDefault();
            window.history.back();
        }
    });

    window.FotoListItemView = Backbone.View.extend({
        tagName:"li",
        template: template('fotoListItemViewTemplate'),
        render:function (eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        },
        events:{
            "click a": "ver"
        },
        close:function () {
            $(this.el).unbind();
            $(this.el).remove();
        },
        ver: function (e) {
            e.preventDefault();
            console.log('prevented default');
        }
    });

    //Rutas
    var AppRouter = Backbone.Router.extend({
        routes: {
            "imagenes":                 "listarAlbumes",
            "imagenes/:album(/:foto)":  "listarFotos",
            //"search/:query":        "search",  // #search/kiwis
            //"search/:query/p:page": "search"   // #search/kiwis/p7
        },
        initialize: function(){
            this.albumList = new AlbumCollection();
            this.fotoList = new FotoCollection();
            this.micrositio_id = $('#micrositio').data('micrositio-id');
            console.log(this.micrositio_id);
        },
        listarAlbumes: function() {
            console.log('listarAlbumes');
            this.albumList.fetch({data: {micrositio_id: this.micrositio_id} });
            this.albumListView = new AlbumListView({collection:this.albumList});
            $('#icontainer').html(this.albumListView.render().el);
        },
        listarFotos: function (album) {
            /*
            *
            *
            *
            *
            *
            PENDIENTE: Parsear el parámetro de la foto que es opcional
            En caso de que esté seleccionada la foto, se pone más grande.
            *
            *
            *
            *
            *
            *
            */
            console.log('detail ' + album);
            this.fotoList.fetch( {data: {nombre: album} } );
            var fl = album.charAt(0).toUpperCase();
            album = fl + album.substring(1);
            console.log(album);
            this.foto = this.fotoList.where({album_foto: album});
            console.dir(this.fotoList);
            this.fotoListView = new FotoListView({collection:this.fotoList});
            $('#icontainer').html(this.fotoListView.render().el);
        }
    });
    var app = new AppRouter();
    Backbone.history.start();
});
function modificar_url(pagina, nombre){
	if(!nombre) nombre = null;
	if(Modernizr.history){
		var stateObj = { pagina: nombre };
		window.history.pushState( stateObj, null, pagina );
	}
}