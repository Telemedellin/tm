"use strict";
jQuery(function($) {
    //Modelos
	window.Carpeta = Backbone.Model.extend({
		urlRoot: '/tm/api/carpeta',
        defaults: {
		    id: '', 
		    url : '',
            pagina : '',
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

    window.Pagina = Backbone.Model.extend({
       urlRoot: '/tm/api/pagina',
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
        events:{
            "click a": "ver"
        },
        close:function () {
            $(this.el).unbind();
            $(this.el).remove();
        },
        ver: function (e) {
            if(e.currentTarget.dataset !== undefined) {
                var carpeta = e.currentTarget.dataset.carpeta;
                var archivo = e.currentTarget.dataset.archivo;
                var nombre = e.currentTarget.dataset.nombre;
            } else {
                var carpeta = e.currentTarget.getAttribute('data-carpeta');
                var archivo = e.currentTarget.getAttribute('data-archivo');
                var nombre = e.currentTarget.getAttribute('data-nombre');
            }
            var url_archivo = '/tm/archivos/' + carpeta + '/' + archivo;
            var aiv = new ArchivoItemView( {model: this.model} );
            $('#ccontainer').html('<a href="#archivos" class="back">Volver</a>');
            $('#ccontainer').append( aiv.render().el );
            modificar_url(e.currentTarget.href, nombre);
            window.open(url_archivo);
            e.preventDefault();
        }
    });
    window.ArchivoItemView = Backbone.View.extend({
        className: 'detalle_archivo',
        template: template('archivoItemViewTemplate'),
        render: function(eventName) {
            $(this.el).html( this.template(this.model.toJSON()) );
            return this;
        }
    });
    //Rutas
    var AppRouter = Backbone.Router.extend({
        routes: {
            "archivos": "listar",
            "archivos/:a1(/:a2)(/:a3)(/:a4)(/:a5)": "listarCarpeta",
        },
        initialize: function(){
            var re = new RegExp("(\/)+$", "g");
            /*jshint regexp: false*/
            this.route(/(.*)\/+$/, "trailFix", function (id) {
                // remove all trailing slashes if more than one
                id = id.replace(re, '');
                this.navigate(id, true);
            });
            this.pagina = new Pagina();
            this.pagina_id = $('#micrositio').data('pagina-id');
            this.pagina.fetch({data: {id: this.pagina_id} });
            if(window.location.hash == '') window.location.hash = 'archivos';
        },
        listar: function() {
            console.log('listar');
            this.carpetaList = new CarpetaCollection();
            this.carpetaList.fetch({data: {pagina_id: this.pagina_id} });
            this.carpetaListView = new CarpetaListView({collection:this.carpetaList, model: this.pagina});
            $('#ccontainer').html(this.carpetaListView.render().el);
        },
        listarCarpeta: function (a1, a2, a3, a4, a5) {
            console.log('listarCarpeta');
            $('#container').append('<div id="loading"><span class="spinner"></span></div>').fadeIn('slow');
            this.carpetaList = new CarpetaCollection();
            this.carpetaList.fetch( {data: {hash: window.location.hash} });
            this.archivoList = new ArchivoCollection();
            this.archivoList.fetch( {data: {hash: window.location.hash}, success: function(){$('#loading').remove()} } );
            console.dir(this.carpetaList);
            console.dir(this.archivoList);
            this.carpetaListView = new CarpetaListView( {collection:this.carpetaList, model: this.pagina} );
            this.archivoListView = new ArchivoListView( {collection:this.archivoList, model: this.pagina} );
            if ($("#archivos").length == 0){
                $('#ccontainer').html('<a href="#archivos" class="back">Volver</a>');
            }else{
                console.log('Ya estaba el back');
            }
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
function back(e){
    window.history.back();
    e.preventDefault();
}