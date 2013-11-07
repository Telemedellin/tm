//"use strict";
var old_title = '';  
var redes = "<div><!--Facebook--><div id='fb-root'></div><div class='fb-like' data-send='false' data-layout='button_count' data-width='120' data-show-faces='false'></div>";
redes += "<div><!--Twitter--><a href='https://twitter.com/share' class='twitter-share-button' data-text='#telemedellin' data-lang='es'>Twittear</a><script>!function(d,s,id) {var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)) {js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></div>";
redes += "<div><!--G+--><div class='g-plusone' data-size='medium'></div></div>";
redes += "<div><!--Pinterest--><a href='//pinterest.com/pin/create/button/' data-pin-do='buttonBookmark' ><img src='//assets.pinterest.com/images/pidgets/pin_it_button.png' /></a><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = '//connect.facebook.net/es_LA/all.js#xfbml=1&appId=26028648916';fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script><script type='text/javascript'>window.___gcfg = {lang: 'es'};(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();</script><script type='text/javascript' src='//assets.pinterest.com/js/pinit.js'></script></div></div>";
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
    $(document).attr('title', data.seccion + ' - Telemedellín');
    
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
function cerrar_popup(e) {
  if(Modernizr.history) {
    var old_url = $('.close').attr('href');
    if(old_url != window.location.href)
    {
      modificar_url(old_url);
    }else
    {
      modificar_url('/');
    }
  }
  $(document).attr('title', old_title);
  $('#overlay').remove();
  e.preventDefault();
}
function abrir_multimedia(tipo) {
  if(tipo != ''){
    //$('a.fancybox.'+tipo).trigger('click');
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
          this.title += '<br />';
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
      destino_url,
      hash;
    //if(!current_hash || !current_hash.indexOf('/')) {
    //Si no existe el hash en la url actual, tomo el hash del enlace
      var hash_p = el_url.indexOf('#');
      hash = el_url.substr(hash_p).substr(1);
    //Asigno la url del elemento a la nueva
      destino_url = el_url;
    //}else{
    //  hash = current_hash;
    //  destino_url = current_url;
    //}
    var destino = '/telemedellin/popup#' + hash;
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
          this.title += '<br />';
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
});
