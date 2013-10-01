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
                $('.carpetas').append(new CarpetaListItemView({model:album}).render().el).fadeIn('slow');
            }, this);
            return this;
        }
    });

    window.CarpetaListItemView = Backbone.View.extend({
        tagName:"li",
        className: 'carpeta', 
        template: template('carpetaListItemViewTemplate'),
        render:function (eventName) {
            $(this.el).html( this.template( this.model.toJSON() ) );
            return this;
        },
        close:function () {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });

    window.ArchivoListView = Backbone.View.extend({
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

    //Rutas
    var AppRouter = Backbone.Router.extend({
        routes: {
            "archivos": "listar",
            "archivos/:a1(/:a2)(/:a3)(/:a4)(/:a5)": "listarCarpeta",
        },
        initialize: function(){
            this.micrositio = new Micrositio();
            this.micrositio_id = $('#micrositio').data('micrositio-id');
            this.micrositio.fetch({data: {id: this.micrositio_id} });
            if(window.location.hash == '') window.location.hash = 'archivos';
        },
        listar: function() {
            console.log('listar');
            this.carpetaList = new CarpetaCollection();
            this.carpetaList.fetch({data: {micrositio_id: this.micrositio_id} });
            this.carpetaListView = new CarpetaListView({collection:this.carpetaList, model: this.micrositio});
            $('#ccontainer').html(this.carpetaListView.render().el);
        },
        listarCarpeta: function (a1, a2, a3, a4, a5) {
            console.log('listarCarpeta');
            this.carpetaList = new CarpetaCollection();
            this.carpetaList.fetch( {data: {hash: window.location.hash} } );
            this.archivoList = new ArchivoCollection();
            this.archivoList.fetch( {data: {hash: window.location.hash} } );
            console.dir(this.carpetaList);
            console.dir(this.archivoList);
            this.carpetaListView = new CarpetaListView( {collection:this.carpetaList, model: this.micrositio} );
            this.archivoListView = new ArchivoListView( {collection:this.archivoList, model: this.micrositio} );
            $('#ccontainer').html('<a href="#archivos" class="back">Volver</a>');
            $('#ccontainer').append(this.carpetaListView.render().el);
            $('#ccontainer').append(this.archivoListView.render().el);
        }
    });
    var app = new AppRouter();
    Backbone.history.start();

    $(document).on('click', '.back', back);
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
function back(){
    //window.history.back();
}