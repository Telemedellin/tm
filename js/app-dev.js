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
	if(data.seccion == 'Programas')
		var plantilla = 'programas.tmpl.html';
	else
		var plantilla = 'seccion.tmpl.html';
	$.get('/tm/js/libs/mustache/views/' + plantilla, function(vista){
		var current_url = window.location.href;
		if(Modernizr.history){
			var stateObj = { pagina: "seccion" };
			window.history.replaceState( stateObj, data.seccion, data.url );
		}
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
			var stateObj = { pagina: "old" };
			window.history.replaceState( stateObj, 'OLD', old_url );
		}else
		{
			var stateObj = { pagina: "home" };
			window.history.replaceState( stateObj, 'OLD', '/tm' );
		}
	}
	$('#overlay').remove();
	e.preventDefault();
}

jQuery(function($) {
	$(document).on('click', '.ajax a', click_popup);
	$(document).on('click', '#overlay a.close', cerrar_popup);
});
