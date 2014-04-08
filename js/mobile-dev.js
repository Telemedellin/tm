function abrir_multimedia(hash) {
	var nombre = "Álbumes", 
		pagina = '#'+hash, 
		destino= '/telemedellin/popup#' + hash;

	if($('.no-history').length == 0) {
		var stateObj = { state: nombre };
		window.history.pushState( stateObj, nombre, pagina );
	}else{
		var hashito = pagina.indexOf('#');
		hashito = pagina.substr(hashito).substr(1);
		window.location.hash = hashito;
	}

	$.ajax(destino, {complete: recibir});
	function recibir(respuesta)
	{
		var micrositio = $('#micrositio'), 
		old_content = micrositio.html();
		micrositio.html(respuesta.responseText);
	}
}
function accentsTidy(s){
  var r = s.toLowerCase();
  r = r.replace(new RegExp("[àáâãäå]", 'gi'),"a");
  r = r.replace(new RegExp("æ", 'gi'),"ae");
  r = r.replace(new RegExp("ç", 'gi'),"c");
  r = r.replace(new RegExp("[èéêë]", 'gi'),"e");
  r = r.replace(new RegExp("[ìíîï]", 'gi'),"i");
  r = r.replace(new RegExp("ñ", 'gi'),"n");                            
  r = r.replace(new RegExp("[òóôõö]", 'gi'),"o");
  r = r.replace(new RegExp("œ", 'gi'),"oe");
  r = r.replace(new RegExp("[ùúûü]", 'gi'),"u");
  r = r.replace(new RegExp("[ýÿ]", 'gi'),"y");
  return r;
};
function nav(event)
{
	var c 	= $('#container'), 
		n 	= $('body > nav');
	if(n.css('right') != '0px'){
		n.css('right', -(n.width()));
		c.animate( {'left': -($(window).width() / 2)+"px"}, 300);
		n.animate( {right: -(n.width())}, 300, function(){n.css('right', 0)} );
	}else
	{
		n.animate( {right: -(n.width())}, 300, function(){n.css('right', '-=300')} );
		c.animate( {left: '0px'}, 300);
	}
}
function set_moment()
{
	moment.lang('es');
	$('time').each(function(i){
		var t = $(this);
		t.text( moment(t.attr('datetime')).calendar() );
	});
}
function submenu(event)
{
	event.preventDefault();
	$(event.target).parent().children('ul').toggle();
}
function verificar_hash() {
	if(window.location.hash) {
		var hash_value = window.location.hash.replace('#', '');
		hash_value = $.trim(hash_value);
		if( hash_value.indexOf('imagenes') >= 0 || hash_value.indexOf('videos') >= 0)
			abrir_multimedia(hash_value);
	}
}
jQuery(function($) {
	var w 		= $(window), 
		body 	= $('body'), 
		micro 	= $('#micrositio'), 
		pro 	= $('#programacion'),
		snav	= $('.slides-navigation'),
		mLink 	= $('#menu-link'), 
		content = $('#content'), 
		vh 		= w.height(), 
		alto	= vh - pro.height() - mLink.height();
	
	//FitText
	$('#programacion h3').fitText(1, { minFontSize: '12px'});
	$('#programacion a').fitText(1, { minFontSize: '10px', maxFontSize: '16px' });
	mLink.fitText(1, { minFontSize: '18px'});
	$('body > nav > ul > li > a').fitText(1, { minFontSize: '16px', maxFontSize: '23px' });

	//Nav
	$(mLink).on('click', nav);
	$('.ajax > a').on('click', submenu);

	//Home
	if(body.hasClass('home')){

		//Novedades
		var elementos = [], 
		novedades = $("#novedades");

		$(".novedad").each(function(index){
			var img = $(this).children("img");
			elementos.push(img);
			img.css({"display":"none", "visibility": "hidden"});
		});
		
		novedades.superslides({
			animation: "slide",
			//play: 15000,
			play: 0,
			hashchange: true,
			pagination: false, 
			animation_speed: 200
		});
		novedades.on("animated.slides", cambio_slide);
		function cambio_slide(event)
		{
			var current   = novedades.superslides("current");
			$.backstretch(elementos[current].attr('src'), {
				centeredY: false, 
				fade: 'fast'
			});
		}
		
		//Espacio para que se vea la imagen de fondo
		$(window).on('orientationchange', cambio_orientacion);
		function cambio_orientacion(event)
		{
			snav.css('top', ((alto / 3) - 45) + 'px' );	
		}
		cambio_orientacion();

		//Noticias
		var url 			= $('#yii-feeds-widget-url').val(), 
			limit 			= $('#yii-feeds-widget-limit').val(), 
			layout 			= $('#yii-feeds-widget-layout').val(), 
			widgetActionUrl = $('#yii-feeds-widget-action-url').val(), 
			yfContainer 	= $('#yii-feed-container'), 
			noticias 		= $(".noticias");
		
		$.get(widgetActionUrl, {url:url, limit:limit, layout:layout}, function(html){
			yfContainer.html(html);
			noticias.bxSlider({
				slideWidth: 215,
				pager: false,
				slideMargin: 20, 
				vaMaxWidth: "100%",
				minSlides: 2, 
				maxSlides: 6, 
				onSliderLoad: set_moment
			});
		});
	}//home

	//Micrositio
	if(micro[0]){
		var bg = body.css('background-image').substr(4);
		body.css('background-image', 'none');
		$.backstretch(bg.substr(0, bg.length-1), {
			centeredY: false, 
			fade: 'fast'
		});
		//Espacio para la imagen
		if(!micro.hasClass('senal-en-vivo'))
			content.css('margin-top', (vh/3) + 'px');

		$("#menu_micrositio").mCustomScrollbar({
			scrollType: "pixels",
			contentTouchScroll: true, 
			scrollInertia: 0, 
			advanced:
			{
				updateOnContentResize: true, 
				horizontalScroll: true, 
			}, 
			scrollButtons: {
				enable: true
			}
		});
		window.updateScrollbar = function() {
			$("#menu_micrositio").mCustomScrollbar("update");
		}

		//Multimedia
		$("a.fancybox").each(function() {
			$(this).on('click', function(event){
				event.preventDefault();
				//Capturo el elemento al que se hizo clic
				var element 	= this,
					//Capturo la url que está en la barra del navegador
					current_url = window.location.href,
					//Capturo el hash de la url actual
					current_hash= window.location.hash.substr(1),
					//Capturo la url del elemento al que se hizo clic           
					el_url 		= element.href,
					hash_p 		= el_url.indexOf('#'), 
					hash   		= el_url.substr(hash_p).substr(1);
				abrir_multimedia(hash);
			})
			
		});
		verificar_hash();
		var dp = $('#dia_programacion');
		if(dp[0])
		{
			dp.change(function () {
				var dia = dp.val();
				window.location = dia;
			});
		}

		$('#micrositio #txtFiltro').on('keyup', filtrar_lista);
		$('#micrositio #txtFiltro').on('change', filtrar_lista);
	    $('#micrositio .listado .nivel-1 > li > span').on('click', open_close_list);
	    $('#micrositio .listado .filtrable > span').on('click', open_close_list);

	    function filtrar_lista(){
			var table = $(".inner"), 
				value = accentsTidy(this.value),
				filtrable = table.find('.filtrable');
			filtrable.parent().parent().removeClass('open');
			filtrable.parent().parent().addClass('hidden');
			filtrable.each(function(index, row) {
			var row = $(row),
			    allCells = row.children('span'),
			    regExp = new RegExp(value, "i"), 
			    text = allCells.text();

			if(text != '' && value != '') {
				var t = accentsTidy(text);
				if(regExp.test(t)) {
					row.addClass('open');
					row.parent().parent().addClass('open');
					row.removeClass('hidden');
					row.parent().parent().removeClass('hidden');
				}else
				{
				row.removeClass('open');
				row.addClass('hidden');
				}
			}else
			{
				row.removeClass('open')
				row.parent().parent().removeClass('open');
				row.removeClass('hidden');
				row.parent().parent().removeClass('hidden');
			}
			});
			//micro.mCustomScrollbar("update");
	    }//filtrar_lista

	    function open_close_list(event)
	    {
			$(event.currentTarget).parent().toggleClass('open');
			micro.mCustomScrollbar("update");
	    }//open_close_list
	}//micro
	
});