"use strict";
jQuery(function($) {
    //Modelos
	window.Album = Backbone.Model.extend({
		urlRoot: '/tm/api/fotoalbum',
        defaults: {
		    nombre : '',
		    url : '',
            thumb: ''
		}
	});

    //Colecciones
	window.AlbumCollection = Backbone.Collection.extend({
	    model : Album,
        url: '/tm/api/fotoalbum'
	});

    //Helpers
    var template = function(id){
        return _.template( $('#' + id).html() );
    };

    //Vistas
    window.AlbumListView = Backbone.View.extend({
        tagName: 'ul',
        initialize:function () {
            this.model.bind("reset", this.render, this);
            var self = this;
            this.model.bind("add", function (album) {
                $(self.el).append(new AlbumListItemView({model:album}).render().el);
            });
        },
     
        render:function (eventName) {
            _.each(this.model.models, function (album) {
                $(this.el).append(new AlbumListItemView({model:album}).render().el);
            }, this);
            return this;
        }
    });

    window.AlbumListItemView = Backbone.View.extend({
        tagName:"li",
        template: template('albumListItemViewTemplate'),
     
        render:function (eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        },
        close:function () {
            $(this.el).unbind();
            $(this.el).remove();
        }
     
    });

    window.AlbumView = Backbone.View.extend({
 
        template: template('albumViewTemplate'),
        initialize:function () {
            this.model.bind("change", this.render, this);
        },
        render:function (eventName) {
            $(this.el).html(this.template(this.model.toJSON()));
            return this;
        },
        events:{
            "change input":"change",
            //"click .save":"saveWine",
            //"click .delete":"deleteWine"
        },
        change:function (event) {
            var target = event.target;
            alert('changing ' + target.id + ' from: ' + target.defaultValue + ' to: ' + target.value);
        },
        close:function () {
            $(this.el).unbind();
            $(this.el).empty();
        }
     
    });

    //Rutas
    var AppRouter = Backbone.Router.extend({
        routes: {
            "":                     "listAlbum",
            "imagenes/:id":     "detailAlbum"
            //"search/:query":        "search",  // #search/kiwis
            //"search/:query/p:page": "search"   // #search/kiwis/p7
        },
        listAlbum: function() {
            this.albumList = new AlbumCollection();
            this.albumListView = new AlbumListView({model:this.albumList});
            this.albumList.fetch();
            $('#container').html(this.albumListView.render().el);
        },
        detailAlbum:function (id) {
            if (this.albumList) {
                this.album = this.albumList.get(id);
                if (this.albumView) app.albumView.close();
                this.albumView = new AlbumView({model:this.album});
                $('#container').html(this.albumView.render().el);
            } else {
                this.requestedId = id;
                this.list();
            }
        }
    });

    var app = new AppRouter();
    Backbone.history.start();


  $(document).on('click', '.in_fancy', link_fancy);
});

function modificar_url(pagina, nombre){
	if(!nombre) nombre = null;
	if(Modernizr.history){
		var stateObj = { pagina: nombre };
		window.history.pushState( stateObj, null, pagina );
	}
}
function link_fancy(e){
	console.log('Hola');
	modificar_url(e.target.href);
	console.log(e.target.href);
	e.preventDefault();
}