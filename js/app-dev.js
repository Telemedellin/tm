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
	$('#container').append('<div id="loading">Cargando...</div>').fadeIn('slow');
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
		$('#container').append(output).fadeIn('slow');
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
	console.log('old_url ' + e.target.href);
	e.preventDefault();
}

function verificar_hash(){
	if(window.location.hash){
		var hash_value = window.location.hash.replace('#', '');
		hash_value = $.trim(hash_value);
		if( hash_value.indexOf('imagenes') >= 0 ){
			abrir_multimedia('imagenes');
		}else if( hash_value.indexOf('videos') >= 0 ){
			abrir_multimedia('videos');
		}
		
	}else{
		console.log('NO');
	}

}

jQuery(function($) {
	$(document).on('click', '.ajax a', click_popup);
	$(document).on('click', '#overlay a.close', cerrar_popup);
	var cf = 0;
	$("a.fancybox").each(function() {
	    //Capturo el elemento al que se hizo clic
	    var element = this,
	    	//Capturo la url que está en la barra del navegador
	    	current_url = window.location.href,
	    	//Capturo el hash de la url actual
	    	current_hash = window.location.hash.substr(1),
			//Capturo la url del elemento al que se hizo clic	    	
	    	el_url = element.href,
	    	//Asigno la url vieja a la nueva
	    	destino_url = current_url;
	    console.log('current_url: ' + current_url);
	    console.log('current_hash: ' + current_hash);
	    console.log('el_url: ' + el_url);
	    console.log('destino_url: ' + destino_url);
	    if(!current_hash){
	    //Si no existe el hash en la url actual, tomo el hash del enlace
	    	var hash_p = el_url.indexOf('#'),
	    	    hash = el_url.substr(hash_p).substr(1);
	    	console.log('hash_p: ' + hash_p);
	    	console.log('hash: ' + hash);
	    //Asigno la url del elemento a la nueva
	    	destino_url = el_url;
	    }else{
	    	hash = current_hash;
	    }
	    console.log('destino_url: ' + destino_url);
	    var destino = '/tm/telemedellin/popup#' + hash;
	    console.log('fanybox destino ' + destino);
	    $(this).fancybox({
	    	type: "ajax",
	    	href: destino,
	    	autoSize: false,
	    	padding: [9, 20, 9, 20],
	    	afterLoad: function(current, previous){
	    		console.log(destino_url);
	    		if(cf <= 0)
	    			modificar_url(destino_url, "Álbumes");
	    		else
	    			modificar_url(el_url, "Álbumes");
	    		cf += 1;
	    	},
	    	afterClose: function(){
	    		window.location.hash = '';
	    		//modificar_url(current_url, null);
	    		//$(document).fullScreen(false);
	    	},
	    	beforeLoad: function(){
	    		this.width  = '80%';
	    	},
	    	beforeShow: function(){
	    		if (this.title) {
	                this.title += '<br />';
	            }else{
	            	this.title = '';
	            }
                //this.title += '<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="' + this.href + '">Tweet</a> ';
                //this.title += '<iframe src="//www.facebook.com/plugins/like.php?href=' + this.href + '&amp;layout=button_count&amp;show_faces=true&amp;width=500&amp;action=like&amp;font&amp;colorscheme=light&amp;height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:23px;" allowTransparency="true"></iframe>';
                this.title += "<div><!--Facebook--><div id='fb-root'></div><div class='fb-like' data-send='false' data-layout='button_count' data-width='120' data-show-faces='false'></div>";
                this.title += "<!--Twitter--><a href='https://twitter.com/share' class='twitter-share-button' data-text='#telemedellin' data-lang='es'>Twittear</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";
                this.title += "<!--G+--><div class='g-plusone' data-size='medium'></div>";
                this.title += "<!--Pinterest--><a href='//pinterest.com/pin/create/button/' data-pin-do='buttonBookmark' ><img src='//assets.pinterest.com/images/pidgets/pin_it_button.png' /></a><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = '//connect.facebook.net/es_LA/all.js#xfbml=1&appId=26028648916';fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script><script type='text/javascript'>window.___gcfg = {lang: 'es'};(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();</script><script type='text/javascript' src='//assets.pinterest.com/js/pinit.js'></script></div>";
	    	},
	    	afterShow: function() {
	            // Render tweet button
	            twttr.widgets.load();
	        },
	    	helpers : {
		        overlay:{
		            css:{
		                "background" : "rgba(0, 0, 0, .7)"
		            }
		        },
		        title:{
	                type: 'inside'
	            }
		    }
	    });
	});

	verificar_hash();
	$(document).bind("fullscreenerror", function() {
	    alert("Browser rejected fullscreen change");
	});
});
