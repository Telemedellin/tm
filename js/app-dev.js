//"use strict";
var old_title = '';  
var redes = "<div><!--Facebook--><div class='fb-share-button' data-type='button_count' data-width='120'></div>";
redes += "<div><!--Twitter--><a href='https://twitter.com/share' class='twitter-share-button' data-text='#telemedellin' data-lang='es'>Twittear</a></div>";
redes += "<div><!--G+--><div class='g-plusone' data-size='medium'></div></div>";
redes += "<div><!--Pinterest--><a href='//pinterest.com/pin/create/button/' data-pin-do='buttonBookmark' ><img src='//assets.pinterest.com/images/pidgets/pin_it_button.png' /></a><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = '//connect.facebook.net/es_LA/all.js#xfbml=1&appId=26028648916';fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script><script type='text/javascript'>window.___gcfg = {lang: 'es'};(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();FB.XFBML.parse();window.twttr.widgets.load();</script><script type='text/javascript' src='//assets.pinterest.com/js/pinit.js'></script></div></div>";
function success_popup(data) {
  switch(data.seccion) {
    case 'Telemedellín':
        var plantilla = 'telemedellin.tmpl.html';
        break;
    case 'Programas':
        var plantilla = 'programas.tmpl.html';
        break;
    case 'Documentales':
        var plantilla = 'documentales.tmpl.html';
        break;
    case 'Especiales':
        var plantilla = 'especiales.tmpl.html';
        break;
    default:
        var plantilla = 'seccion.tmpl.html';
        break;
  }
  $.get('/js/libs/mustache/views/' + plantilla, function(vista) {
    var current_url = window.location.href, 
        output = Mustache.render(vista, data);
    modificar_url(data.url, data.seccion);
    old_title = $(document).attr('title');
    $(document).attr('title', data.seccion + ' - Telemedellín, aquí te ves');
    
    $('#loading').remove();
    $('#container').append(output).fadeIn('slow');
    $('.close').attr('href', current_url);
    if(!Modernizr.input.placeholder){
      $('[placeholder]').focus(function() { 
       var input = $(this); 
       if (input.val() == input.attr('placeholder')) { 
           input.val(''); 
           input.removeClass('placeholder'); 
        } 
      }).blur(function() { 
        var input = $(this); 
        if (input.val() == '' || input.val() == input.attr('placeholder')) { 
           input.addClass('placeholder').val(input.attr('placeholder')); 
        } 
      }).blur(); 
      $('[placeholder]').parents('form').submit(function() { 
        $(this).find('[placeholder]').each(function() { 
          var input = $(this); 
          if (input.val() == input.attr('placeholder')) { 
             input.val(''); 
          } 
        }) 
      });
    }
  });
}
function cargar_popup(url) {
  $.getJSON(url, success_popup);
  $('#container').append('<div id="loading"><span class="spinner"></span></div>').fadeIn('slow');
}
function click_popup(e) {
  var url = e.target.href + '?ajax=true';
  cargar_popup(url);
  e.preventDefault();
}
function v_cerrar_popup(e) {
  if(e.target == $('#overlay')[0])
    $('#overlay a.close').trigger('click');  
  ga('send', 'event', 'Popup', 'Cerrar', location.pathname + '/' + location.hash);  
}

function cerrar_popup(e) {
  if(Modernizr.history) {
    var old_url = $('.close').attr('href');
    if(old_url != window.location.href)
    {
      modificar_url(old_url);
    }else
    {
      modificar_url('');
    }
  }
  $(document).attr('title', old_title);
  $('#overlay').remove();
  ga('send', 'event', 'Popup', 'Cerrar', location.pathname + '/' + location.hash);
  e.preventDefault();
}
function ga_track(){
    //_gaq.push(['_trackEvent', 'Popup', 'Click', location.pathname + '/' + location.hash]);
    ga('send', 'event', 'Popup', 'Click', location.pathname + '/' + location.hash);
}
function abrir_multimedia(tipo) {
  if(tipo != ''){
    var hash = window.location.hash.substr(1),
        destino = '/telemedellin/popup#' + hash;
    $.fancybox.open({
      type: "ajax",
      href: destino,
      autoSize: false,
      height: $( window ).height() - ($( window ).height() * 0.10),
      padding: [9, 20, 9, 20],
      afterLoad: function(current, previous) {
          var nombre = "Álbumes";
          var pagina = '#'+hash;
          if(!nombre) nombre = null;
          if($('.no-history').length == 0) {
            var stateObj = { state: nombre };
            window.history.pushState( stateObj, nombre, pagina );
          }else{
            var hashito = pagina.indexOf('#');
            hashito = pagina.substr(hashito).substr(1);
            window.location.hash = hashito;
          }
      },
      afterClose: function() {
        if($('.no-history').length > 0)
          window.location.hash = '';
        modificar_url('#', "Álbumes");
      },
      beforeLoad: function() {
        this.width  = '80%';
      },
      beforeShow: function() {
        if (this.title) {
          this.title = '';
        }else{
          this.title = '';
        }
        this.title += redes;
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
  }
}
function modificar_url(pagina, nombre) {
  if(!nombre) nombre = null;
  if($('.no-history').length == 0) {
    var stateObj = { state: nombre };
    window.history.pushState( stateObj, nombre, pagina );
  }else{
    if(pagina.indexOf('#') != -1){
      var hashito = pagina.indexOf('#');
      hashito = pagina.substr(hashito).substr(1);
      window.location.hash = hashito;
    }
  }
  ga_track();
}
function verificar_hash() {
  if(window.location.hash) {
    var hash_value = window.location.hash.replace('#', '');
    hash_value = $.trim(hash_value);
    if( hash_value.indexOf('imagenes') >= 0 ) {
      abrir_multimedia('imagenes');
    }else if( hash_value.indexOf('videos') >= 0 ) {
      abrir_multimedia('videos');
    }
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

jQuery(function($) {
  var doc   = $(document), 
      body  = $('body'), 
      micro = $('#micrositio');

  doc.on('click', '.ajax a', click_popup);
  doc.on('click', '#overlay a.close', cerrar_popup);
  doc.on('click', '#overlay', v_cerrar_popup);
  doc.on('keyup', '#seccion #txtFiltro', filtrar_seccion);
  doc.on('click', '#banner a', function(){
    ga('send', 'event', 'Banner', 'Click', location.pathname + '/' + location.hash);
  });
  doc.on('click', '.slides-pagination a', function(){
    ga('send', 'event', 'Slider home', 'Navegar', location.pathname + '/' + location.hash, {'nonInteraction': 1});
  });
  doc.on('click', '.bx-controls-direction a', function(){
    ga( 'send', 'event', 'Slider noticias', 'Navegar', $(this).attr('class'), {'nonInteraction': 1} );
  });
  doc.on('click', '.noticia a', function(){
    ga( 'send', 'event', 'Noticia', 'Click', $(this).attr('href') );
  });
  doc.on('click', '.marquesina a', function(){
    ga( 'send', 'event', 'Twitter ticker', 'Click', $(this).attr('href') );
  });
  //{'page': '/my-new-page'}  

  function filtrar_seccion(){
    var table = $(".inner");
    var value = accentsTidy(this.value);
    var filtrable = table.find("h2");
    filtrable.each(function(index, row) {
      var allCells = $(row).find("a");
      if(allCells.length > 0) {
        var found = false;
        allCells.each(function(index, a) {
          var regExp = new RegExp(value, "i");
          var t = accentsTidy($(a).text());
          if(regExp.test(t)) {
            found = true;
            return false;
          }
        });
        if (found == true) $(row).show();
        else $(row).hide();
      }
    });
  }//filtrar_seccion
  
  var cf = 0;
  if(micro[0]){
    micro.mCustomScrollbar({
      scrollType: "pixels",
      updateOnContentResize: true, 
      scrollButtons: {
        enable: true
      }
    });
    window.updateScrollbar = function() {
      micro.mCustomScrollbar("update");
    }
    $(".fancybox a, a.fancybox").each(function() {
      //Capturo el elemento al que se hizo clic
      var element     = this,
        //Capturo la url que está en la barra del navegador
        current_url   = window.location.href,
        //Capturo el hash de la url actual
        current_hash  = window.location.hash.substr(1),
        //Capturo la url del elemento al que se hizo clic           
        el_url        = element.href,
        hash_p        = el_url.indexOf('#'),
        hash          = el_url.substr(hash_p).substr(1),
      //Asigno la url del elemento a la nueva
        destino_url   = el_url;
      var destino     = '/telemedellin/popup#' + hash;
      $(this).fancybox({
        type: "ajax",
        href: destino,
        autoSize: false,
        height: $( window ).height() - ($( window ).height() * 0.10),
        padding: [9, 20, 9, 20],
        afterLoad: function(current, previous) {
            var nombre = "Álbumes";
            //var pagina = destino_url;
            var pagina = '#'+hash;
            //modificar_url(pagina, nombre);
            if(!nombre) nombre = null;
            if($('.no-history').length == 0) {
              var stateObj = { state: nombre };
              window.history.pushState( stateObj, nombre, pagina );
            }else{
              var hashito = pagina.indexOf('#');
              hashito = pagina.substr(hashito).substr(1);
              window.location.hash = hashito;
            }
        },
        afterClose: function() {
          if($('.no-history').length > 0)
            window.location.hash = '';
          modificar_url('#', "Álbumes");
        },
        beforeLoad: function() {
          this.width  = '80%';
        },
        beforeShow: function() {
          if (this.title) {
            this.title = '';
          }else{
            this.title = '';
          }
          this.title += redes;
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
      micro.mCustomScrollbar("update");
    }//filtrar_lista

    function open_close_list(event)
    {
      $(event.currentTarget).parent().toggleClass('open');
      micro.mCustomScrollbar("update");
    }//open_close_list

    var table_programacion = $('#table_programacion tbody tr'), 
        fecha_programacion = $('#fecha_programacion')

    table_programacion.hide();
    $('#table_programacion tbody tr.'+fecha_programacion.val()).show();
    fecha_programacion.on('change', function(){
      table_programacion.hide();
      $('#table_programacion tbody tr.'+$(this).val()).show();
    });

    if(window.location.hash == '#correo')
    {
      $('#correo').show();
      micro.mCustomScrollbar("update");
    }

    //Elimina el target _blank de los enlaces con ajax
    $('.fancybox a[target="_blank"], a.fancybox[target="_blank"]').removeAttr('target');

  }//if micro[0]

  if(body.hasClass('home')){
    var novedades = $("#novedades");
    novedades.superslides({
      animation: "fade",
      play: 15000,
      hashchange: true,
      pagination: false
    });
    set_current();
    novedades.on("started.slides", function(){
      set_current();
    });
    novedades.on("animated.slides", function(){
      set_current();
    });
    function set_current()
    {
      var current = novedades.superslides("current");
      $( ".slides-pagination a" ).each(function( index ) {
        $(this).removeClass("current");
      });
      $(".slides-pagination ." + current).addClass("current");
    }
    var url       = $('#yii-feeds-widget-url').val(), 
      limit       = $('#yii-feeds-widget-limit').val(), 
      widgetActionUrl = $('#yii-feeds-widget-action-url').val(), 
      yfContainer   = $('#yii-feed-container'), 
      noticias    = $(".noticias");
    $.get(widgetActionUrl, {url:url, limit:limit}, function(html){
        yfContainer.html(html);
        noticias.bxSlider({
        slideWidth: 255,
        pager: false,
        minSlides: 2, 
        maxSlides: 5, 
        vaMaxWidth: "85%"
      });
    });

    var Count, 
        Today     = new Date(), 
        contador  = $('#contador'),
        txt_conta = $('.txt_conta'), 
        EDate     = (contador.data('fin')*1000),
        TDay      = new Date(EDate),
        txt       = 'días';
        //TDay  = new Date(2014, 5, 11, 21, 30);
    

    Count  = (TDay-Today)/(1000*60*60*24);//días
    if(Count <= 1)
    {
      Count  = (TDay-Today)/(1000*60*60);//horas
      txt = 'horas';
    }
    if(Count <= 1)
    {
      Count  = (TDay-Today)/(1000*60);//minutos
      txt = 'minutos';
    }
    
    Count      = Math.round(Count); 
    if(Count > 0)
    {
      if(Count.toString().length == 1) Count = '0'+Count;
      contador.text(Count);
      txt_conta.text(txt);
    }else
    {
      contador.hide();
    }
    
  }//if body.hasClass('home')
});
