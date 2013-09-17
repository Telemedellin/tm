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

    window.Micrositio = Backbone.Model.extend({
       urlRoot: '/tm/api/micrositio',
        defaults: {
            id: '', 
            nombre : ''
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
        template: template('albumListViewTemplate'),
        initialize:function () {
            this.collection.bind("reset", this.render, this);
            this.collection.bind("add", this.render, this);
            /*var self = this;
            this.collection.bind("add", function (album) {
                $(self.el).append(new AlbumListItemView({model:album}).render().el);
            }, this);*/
            this.render;
        },
        render:function (eventName) {
            $(this.el).html( this.template( this.model.toJSON() ) );
            _.each(this.collection.models, function (album) {
                console.log('each ' + album);
                $('.albumes').append(new AlbumListItemView({model:album}).render().el);
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
        //tagName: 'ul',
        template: template('fotoListViewTemplate'),
        initialize:function () {
            this.collection.bind("reset", this.render, this);
            var self = this;
            //Pasarle el modelo para que sepa que album es
            //$(this.el).html( this.template( this.model.toJSON() ) );
            this.collection.bind("add", function (foto) {
                $(self.el).append(new FotoListItemView({model:foto}).render().el);
            });
        },
        events:{
            "click a.back": "back"
        },
        render:function (eventName) {
            //$(this.el).html( this.template( this.model.toJSON() ) );
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
        //tagName:"li",
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
            //e.preventDefault();
            console.log('ver ...');
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
            this.micrositio = new Micrositio();
            this.micrositio_id = $('#micrositio').data('micrositio-id');
            this.micrositio.fetch({data: {id: this.micrositio_id} });
        },
        listarAlbumes: function() {
            this.albumList = new AlbumCollection();
            console.log('listarAlbumes');
            this.albumList.fetch({data: {micrositio_id: this.micrositio_id} });
            this.albumListView = new AlbumListView({collection:this.albumList, model: this.micrositio});
            $('#icontainer').html(this.albumListView.render().el);
        },
        listarFotos: function (album, foto) {
            /*
            *
            *
            *
            *
            *
            PENDIENTE: 
            *
            Comprobar no solo el álbum, sino también el micrositio
            *
            Parsear el parámetro de la foto que es opcional
            En caso de que esté seleccionada la foto, se pone más grande.
            *
            *
            *
            *
            *
            */
            this.fotoList = new FotoCollection();
            console.log('detail ' + album + ' ' + foto);
            this.fotoList.fetch( {data: {nombre: album, micrositio: this.micrositio_id} } );
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