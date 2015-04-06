//"use strict";
jQuery(function($) {
    var url_base = '/';
    //Modelos
	window.Carpeta = Backbone.Model.extend({
		urlRoot: url_base + 'api/carpeta',
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
       urlRoot: url_base + 'api/archivo',
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
       urlRoot: url_base + 'api/pagina',
        defaults: {
            id: '', 
            nombre : ''
        } 
    });

    //Colecciones
	window.CarpetaCollection = Backbone.Collection.extend({
	    model : Carpeta,
        url: url_base + 'api/carpeta'
	});

    window.ArchivoCollection = Backbone.Collection.extend({
        model : Archivo,
        url: url_base + 'api/archivo'
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
            this.$el.empty();
            $(this.el).html( this.template( this.model.toJSON() ) );
            _.each(this.collection.models, function (carpeta) {
                $('.carpetas').append(new CarpetaListItemView({model:carpeta}).render().el).fadeIn('slow');
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
            if($("#micrositio").hasClass('mCustomScrollbar'))
            {
                window.updateScrollbar();
            }
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
            this.$el.empty();
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
            if($("#micrositio").hasClass('mCustomScrollbar'))
            {
                window.updateScrollbar();
            }
            return this;
        },
        events:{
            "click a": "ver"
        },
        close:function () {
            $(this.el).unbind().remove();
        },
        ver: function (e) {
            var carpeta, 
                archivo, 
                nombre;
            if(e.currentTarget.dataset !== undefined) {
                carpeta = e.currentTarget.dataset.carpeta;
                archivo = e.currentTarget.dataset.archivo;
                nombre = e.currentTarget.dataset.nombre;
            } else {
                carpeta = e.currentTarget.getAttribute('data-carpeta');
                archivo = e.currentTarget.getAttribute('data-archivo');
                nombre = e.currentTarget.getAttribute('data-nombre');
            }
            window.open( url_base + 'archivos/' + carpeta + '/' + archivo );
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
                this.navigate( id.replace(re, ''), true);
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
            ga_track();
        },
        listarCarpeta: function (a1, a2, a3, a4, a5) {
            console.log('listarCarpeta');
            var cc = $('#ccontainer');
            cc.append('<div id="loading"><span class="spinner"></span></div>').fadeIn('slow');
            this.carpetaList = new CarpetaCollection();
            this.carpetaList.fetch( {
                data: {
                    hash: window.location.hash
                }, 
                success: function(){
                    $('#loading').remove();
                } 
            });
            this.archivoList = new ArchivoCollection();
            this.archivoList.fetch( {
                data: {
                    hash: window.location.hash
                }
            } );
            console.dir(this.carpetaList);
            console.dir(this.archivoList);
            this.carpetaListView = new CarpetaListView( {collection:this.carpetaList, model: this.pagina} );
            this.archivoListView = new ArchivoListView( {collection:this.archivoList, model: this.pagina} );
            if ($("#archivos").length == 0){
                cc.html('<a href="#archivos" class="back">Volver</a>');
            }else{
                console.log('Ya estaba el back');
            }
            cc.append(this.carpetaListView.render().el).append(this.archivoListView.render().el);
            ga_track();
        }
    });
    var app = new AppRouter();
    Backbone.history.start();

    $(document).on('click', '.back', back);
    $(document).on('click', '.archivo a', track_file);
    //$('.archivo a').on('click', track_file);
});
function modificar_url(pagina, nombre){
	nombre = nombre || null;
	if(Modernizr.history){
		window.history.pushState( { pagina: nombre }, null, pagina );
	}
}
function makeTitle(slug) {
    var words = slug.split('-'), 
        word;

    for(var i = 0, wl = words.length; i < wl; i++) {
      word = words[i];
      words[i] = word.charAt(0).toUpperCase() + word.slice(1);
    }

    return words.join(' ');
}
function back(e){
    //window.history.back();
    var hasharray = window.location.hash.split('/'),
        newhash = '';
    for (var i=0, hal = hasharray.length-1; i < hal; i++)
        newhash += hasharray[i] + "/";
    newhash = newhash.substring(0, newhash.length-1);
    window.location.hash = newhash;
    //modificar_url(window.location.href + '#' + newhash);
    e.preventDefault();
    ga_track();
}
function ga_track(){
    ga('send', 'event', 'Archivos', 'Click', location.pathname + '/' + location.hash);
}
function track_file(event)
{
    ga_track('send', 'event', 'Archivos', 'Click', event.currentTarget.href);
}