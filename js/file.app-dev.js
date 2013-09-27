"use strict";
jQuery(function($) {
    //Modelos
	window.Carpeta = Backbone.Model.extend({
		urlRoot: '/tm/api/carpeta',
        defaults: {
		    id: '', 
		    url : '',
            micrositio : '',
            carpeta: '',
            ruta: '', 
            hijos: ''
		}
	});

    window.Archivo = Backbone.Model.extend({
       urlRoot: '/tm/api/archivo',
        defaults: {
            id: '', 
            url: '', 
            tipo_archivo: '', 
            carpeta: '', 
            nombre : '', 
            archivo: ''
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
	window.CarpetaCollection = Backbone.Collection.extend({
	    model : Carpeta,
        url: '/tm/api/carpeta'
	});

    window.ArchivoCollection = Backbone.Collection.extend({
        model : Archivo,
        url: '/tm/api/archivo'
    });

    //Helpers
    var template = function(id){
        return _.template( $('#' + id).html() );
    };

    //Vistas
    window.CarpetaListView = Backbone.View.extend({
        template: template('carpetaListViewTemplate'),
        initialize:function () {
            this.collection.bind("reset", this.render, this);
            this.collection.bind("add", this.render, this);
            this.render;
        },
        render:function (eventName) {
            $(this.el).html( this.template( this.model.toJSON() ) );
            _.each(this.collection.models, function (album) {
                $('.carpeta').append(new CarpetaListItemView({model:album}).render().el).fadeIn('slow');
            }, this);
            return this;
        }
    });

    window.CarpetaListItemView = Backbone.View.extend({
        tagName:"li",
        className: 'carpeta', 
        template: template('carpetaListItemViewTemplate'),
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

    window.ArchivoListView = Backbone.View.extend({
        className: 'archivos',
        template: template('archivoListViewTemplate'),
        initialize:function () {
            this.collection.bind("reset", this.render, this);
            var self = this;
            this.render();
            this.collection.bind("add", this.add, this);
        },
        render:function (eventName) {
            $(this.el).html( this.template( this.model ) );
            return this;
        },
        add: function(archivo){
            var fliv = new ArchivoListItemView({model:archivo});
            $('.archivos').append(fliv.render().el).fadeIn('slow');
        }
    });

    window.ArchivoListItemView = Backbone.View.extend({
        tagName:"li",
        className:'archivo',
        template: template('archivoListItemViewTemplate'),
        render:function (eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        },
        close:function () {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });

    //Rutas  /***************************PENDIENTE****************************/
    var AppRouter = Backbone.Router.extend({
        routes: {
            "archivos(/:a1)(/:a2)(/:a3)(/:a4)(/:a5)": "listar",
        },
        initialize: function(){
            this.micrositio = new Micrositio();
            this.micrositio_id = $('#micrositio').data('micrositio-id');
            this.micrositio.fetch({data: {id: this.micrositio_id} });
        },
        listar: function() {
            this.carpetaList = new CarpetaCollection();
            this.carpetaList.fetch({data: {micrositio_id: this.micrositio_id} });
            this.carpetaListView = new AlbumListView({collection:this.carpetaList, model: this.micrositio});
            $('#ccontainer').html(this.carpetaListView.render().el);
        },
        listarFotos: function (album, foto) {
            this.fotoList = new FotoCollection();
            this.fotoList.fetch( {data: {hash: window.location.hash, micrositio: this.micrositio_id} } );
            var fl = album.charAt(0).toUpperCase();
            album = fl + album.substring(1);
            album = makeTitle(album);
            console.log(album);
            console.dir(this.fotoList);
            this.fotoListView = new FotoListView({collection:this.fotoList, model: {nombre: album, foto_activa: foto} });
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
function makeTitle(slug) {
    var words = slug.split('-');

    for(var i = 0; i < words.length; i++) {
      var word = words[i];
      words[i] = word.charAt(0).toUpperCase() + word.slice(1);
    }

    return words.join(' ');
}