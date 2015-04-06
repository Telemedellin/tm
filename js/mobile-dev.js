function abrir_multimedia(hash) {
	var url_base = '/tm/', 
		nombre = "Álbumes", 
		pagina = '#'+hash, 
		destino= url_base + 'telemedellin/popup#' + hash, 
		hashito = pagina.indexOf('#');

	if($('.no-history').length == 0) {
		window.history.pushState( { state: nombre }, nombre, pagina );
	}else{
		window.location.hash = pagina.substr(hashito).substr(1);;
	}

	$.ajax(destino, {complete: recibir});
	function recibir(respuesta)
	{
		$('#micrositio').html(respuesta.responseText);
	}
	ga_track();
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
		n.css('right', -( n.width() )).animate( {right: -( n.width() )}, 300, function() {n.css('right', 0)} );
		c.animate( {'left': -( $(window).width() / 2 )+"px"}, 300);
		ga( 'send', 'event', 'Menú móvil', 'Cerrar', location.pathname + '/' + location.hash );
	}else
	{
		n.animate( {right: -(n.width())}, 300, function(){n.css('right', '-=300')} );
		c.animate( {left: '0px'}, 300);
		ga( 'send', 'event', 'Menú móvil', 'Click', location.pathname + '/' + location.hash );
	}
	event.preventDefault();
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
		var hash_value = $.trim( window.location.hash.replace('#', '') );
		if( hash_value.indexOf('imagenes') >= 0 || hash_value.indexOf('videos') >= 0)
			abrir_multimedia(hash_value);
	}
}
function ga_track(){
    //_gaq.push(['_trackEvent', 'Popup móvil', 'Click', location.pathname + '/' + location.hash]);
    ga('send', 'event', 'Popup móvil', 'Click', location.pathname + '/' + location.hash);
}
jQuery(function($) {
	var w 		= $(window), 
		doc		= $(document), 
		body 	= $('body'), 
		micro 	= $('#micrositio'), 
		pro 	= $('#programacion'),
		snav	= $('.slides-navigation'),
		mLink 	= $('#menu-link'), 
		content = $('#content'), 
		vh 		= w.height(), 
		alto	= vh - pro.height() - mLink.height(), 
		banner  = $('#banner');

	doc.on('click', '.slides-navigation a', function(){
    	ga('send', 'event', 'Slider home móvil', 'Navegar', $(this).attr('class'));
  	});
  	doc.on('click', '.bx-controls-direction a', function(){
		ga( 'send', 'event', 'Slider noticias móvil', 'Navegar', $(this).attr('class') );
	});
	doc.on('click', '.noticia a', function(){
		ga( 'send', 'event', 'Noticia móvil', 'Click', $(this).attr('href') );
	});
	
	//FitText
	$('#programacion h3').fitText(1, { minFontSize: '12px', maxFontSize: '20px'});
	$('#programacion a').fitText(.3);
	$('#programacion a.tmradio').fitText(.37);
	mLink.fitText(.6, { minFontSize: '18px'});
	$('body > nav > ul > li > a').fitText(1.2);

	//Nav
	$(mLink).on('click', nav);
	$('.ajax > a').on('click', submenu);

	//Home
	if(body.hasClass('home')){

		//Novedades
		var elementos = [], 
		novedades = $("#novedades"), 
		img;

		$(".novedad").each(function(index){
			img = $(this).children("img");
			elementos.push(img);
			img.css({"display":"none", "visibility": "hidden"});
		});
		
		novedades.superslides({
			animation: "slide",
			//play: 15000,
			play: 0,
			hashchange: false,
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

	banner.on('click', function(event){
		if( !$(this).hasClass('desplegado') )
		{
			$(this).addClass('desplegado');
			event.preventDefault();
		}
		ga('send', 'event', 'Banner móvil', 'Click', location.pathname + '/' + location.hash);
	});
	$('#banner .close').on('click', function(event){
		banner.removeClass('desplegado');
		event.preventDefault();
		event.stopPropagation();
		ga('send', 'event', 'Banner móvil', 'Close', location.pathname + '/' + location.hash);
	});

	var Count, 
        Today     = new Date(), 
        contador  = $('#contador'),
        EDate     = (contador.data('fin')*1000),
        TDay      = new Date(EDate);
        //TDay  = new Date(2014, 5, 11, 21, 30);
    

    Count  = (TDay-Today)/(1000*60*60*24);//días
    if(Count <= 1)
      Count  = (TDay-Today)/(1000*60*60);//horas
    if(Count <= 1)
      Count  = (TDay-Today)/(1000*60);//minutos
    
    Count      = Math.round(Count); 
    if(Count > 0)
    {
      if(Count.toString().length == 1) Count = '0'+Count;
      contador.text(Count);
    }else
    {
      contador.hide();
    }

	contador.fitText(.18, { minFontSize: '13px', maxFontSize: '140px' });

	//Micrositio
	if(micro[0]){
		var bg = $.trim(body.css('background-image')).substr(4).replace('"', '', 'g'), 
			menu_micrositio = $("#menu_micrositio"), 
			dp = $('#dia_programacion'), 
			txtFiltro = $('#micrositio #txtFiltro'), 
			table_programacion = $('#table_programacion tbody tr'), 
        	fecha_programacion = $('#fecha_programacion');
		bg = bg.substr(0, bg.length-1);
		body.css('background-image', 'none');
		if( bg != '')
			$.backstretch(bg, {
				centeredY: false, 
				fade: 'fast'
			});
		//Espacio para la imagen
		if(!micro.hasClass('senal-en-vivo'))
			content.css('margin-top', (vh/3) + 'px');

		menu_micrositio.mCustomScrollbar({
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
			menu_micrositio.mCustomScrollbar("update");
		}

		//Multimedia
		$(".fancybox a").each(function() {
			$(this).on('click', function(event){
				event.preventDefault();
				//Capturo el elemento al que se hizo clic
				var element 	= this,
					//Capturo la url que está en la barra del navegador
					//current_url = window.location.href,
					//Capturo el hash de la url actual
					//current_hash= window.location.hash.substr(1),
					//Capturo la url del elemento al que se hizo clic           
					el_url 		= element.href,
					hash_p 		= el_url.indexOf('#'), 
					hash   		= el_url.substr(hash_p).substr(1);
				abrir_multimedia(hash);
			})
			
		});

		//Elimina el target _blank de los enlaces con ajax
    	$('.fancybox a[target="_blank"]').removeAttr('target');
		verificar_hash();
		
		if(dp[0])
		{
			dp.change(function () {
				window.location = dp.val();
			});
		}

		txtFiltro.on('keyup', filtrar_lista);
		txtFiltro.on('change', filtrar_lista);
	    $('#micrositio .listado .nivel-1 > li > span').on('click', open_close_list);
	    $('#micrositio .listado .filtrable > span').on('click', open_close_list);

	    function filtrar_lista(){
			var table = $(".inner"), 
				value = accentsTidy(this.value),
				filtrable = table.find('.filtrable');
			filtrable.parent().parent().removeClass('open').addClass('hidden');
			filtrable.each(function(index, row) {
			var row = $(row),
			    allCells = row.children('span'),
			    regExp = new RegExp(value, "i"), 
			    text = allCells.text(), 
			    t = accentsTidy(text);

			if(text != '' && value != '') {
				if(regExp.test(t)) {
					row.addClass('open').removeClass('hidden');
					row.parent().parent().addClass('open').removeClass('hidden');
				}else
				{
				row.addClass('hidden').removeClass('open');
				}
			}else
			{
				row.removeClass('open hidden')
				row.parent().parent().removeClass('open hidden');
			}
			});
			//micro.mCustomScrollbar("update");
	    }//filtrar_lista

	    function open_close_list(event)
	    {
			$(event.currentTarget).parent().toggleClass('open');
			micro.mCustomScrollbar("update");
	    }//open_close_list

	    table_programacion.hide();
	    $('#table_programacion tbody tr.'+fecha_programacion.val()).show();
	    fecha_programacion.on('change', function(){
	      table_programacion.hide();
	      $('#table_programacion tbody tr.'+$(this).val()).show();
	    });
	}//micro
});