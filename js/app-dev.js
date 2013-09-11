"use strict";
function click_popup(e)
{
	var url   = e.target.href;
	cargar_popup(url);
	e.preventDefault();
}

function cargar_popup(url)
{
	$.getJSON(url, success_popup);
	$('#container').append('<div id="loading">Cargando...</div>');
}

function success_popup(data)
{
	switch(data.seccion){
		case 'Telemedellín':
			var plantilla = 'telemedellin.tmpl.html';
			break;
		case 'Programas':
			var plantilla = 'programas.tmpl.html';
			break;
		case 'Documentales':
		case 'Especiales':
			var plantilla = 'documentales.tmpl.html';
			break;
		default:
			var plantilla = 'seccion.tmpl.html';
			break;
	}
	$.get('/tm/js/libs/mustache/views/' + plantilla, function(vista){
		var current_url = window.location.href;
		modificar_url(data.url, data.seccion);
		var output = Mustache.render(vista, data);
		$('#loading').remove();
		$('#container').append(output);
		$('.close').attr('href', current_url);
	});
}

function cerrar_popup(e)
{
	if(Modernizr.history){
		var old_url = $('.close').attr('href');
		console.log(old_url + ' ' + window.location.href);
		if(old_url != window.location.href)
		{
			modificar_url(old_url);
		}else
		{
			modificar_url('/tm', 'Inicio');
		}
	}
	$('#overlay').remove();
	e.preventDefault();
}

function abrir_multimedia(tipo){
	if(tipo != '')
		$('a.fancybox.'+tipo).trigger('click');
}

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
	$(document).on('click', '.ajax a', click_popup);
	$(document).on('click', '#overlay a.close', cerrar_popup);
	$(document).on('click', '.in_fancy', link_fancy);

	$("a.fancybox").each(function() {
	    var element = this;
	    var old_url = window.location.href;
	    var destino = element.href;
	    $(this).fancybox({
	    	type: "iframe",
	    	href: destino + '&ajax=true',
	    	afterLoad: function(current, previous){
	    		modificar_url(destino, "Álbumes");
	    	},
	    	afterClose: function(){
	    		modificar_url(old_url, null);
	    	},
	    	beforeShow: function(){
	    		if (this.title) {
	                this.title += '<br />';
	            }else{
	            	this.title = '';
	            }
                this.title += '<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="' + this.href + '">Tweet</a> ';
                this.title += '<iframe src="//www.facebook.com/plugins/like.php?href=' + this.href + '&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:23px;" allowTransparency="true"></iframe>';
	    	},
	    	afterShow: function() {
	            // Render tweet button
	            twttr.widgets.load();
	        },
	    	helpers : {
		        overlay : {
		            css : {
		                "background" : "rgba(0, 0, 0, .7)"
		            }
		        },
		        title : {
	                type: 'inside'
	            }
		    }
	    });
	});
});
