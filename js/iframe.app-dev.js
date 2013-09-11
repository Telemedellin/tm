"use strict";
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
