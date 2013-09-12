"use strict";
(function($){

	var albumModel = Backbone.Model.extend({
		defaults: {
		    nombre : 'Sin título',
		    url : 'no url'
		}
	});

	var albumesCollection = Backbone.Collection.extend({
	    model : albumModel
	});

	//Llamo el json con los álbumes

	var albumes  = new albumesCollection([
		new albumModel({ nombre : 'Prueba 1', url : 'tal.html'}),
		new albumModel({ nombre : 'Prueba 2', url : 'tal.html'})
	]);

	var albumesView = Backbone.View.extend({
		tagName: 'li',
		initialize: function(){
            this.listenTo(this.model, 'change', this.render);
        },
        render: function(){
        	this.$el.html('<ul><li><a href="'+this.model.get('url')+'" class="in_fancy"><img src="'+this.model.get('url')+'" width="105" height="77" /><h2>'+this.model.get('nombre')+'</h2></li></ul>');
            return this;
        }
	});


	// The main view of the application
    var App = Backbone.View.extend({
        // Base the view on an existing element
        el: $('#container'),
        initialize: function(){
            // Cache these selectors
            //this.total = $('#total span');
            this.list = $('#albumes');

            // Listen for the change event on the collection.
            // This is equivalent to listening on every one of the 
            // service objects in the collection.
            //this.listenTo(services, 'change', this.render);

            // Create views for every one of the services in the
            // collection and add them to the page

            albumes.each(function(albumModel){

                var view = new albumesView({ model: albumModel });
                this.list.append(view.render().el);

            }, this);	// "this" is the context in the callback
        },

        render: function(){

            return this;
        }
    });

    new App();

  /*var ListView = Backbone.View.extend({
    el: $('body'), // attaches `this.el` to an existing element.
    initialize: function(){
      _.bindAll(this, 'render'); // fixes loss of context for 'this' within methods
       this.render(); // not all views are self-rendering. This one is.
    },
    render: function(){
      $(this.el).append("<ul> <li>hello world</li> </ul>");
    }
  });
  var listView = new ListView();*/
})(jQuery);

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

jQuery(function($) {
	$(document).on('click', '.in_fancy', link_fancy);
});
