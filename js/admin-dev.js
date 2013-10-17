jQuery(function($) {    
    var PUBLIC_PATH = $("#PUBLIC_PATH").val();
    var numPerfil = $("#fotoPerfil .template-download:not('.ui-state-error')").length;

    // Initialize the jQuery File Upload widget:
    $('#imagen').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/novedades/imagen',
        maxNumberOfFiles: 1,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        }
    });
    // Enable iframe cross-domain access via redirect option:
    $('#imagen').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen').addClass('fileupload-processing');

    $.ajax({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: $('#imagen').fileupload('option', 'url'),
        dataType: 'json',
        context: $('#imagen')[0]
    }).always(function (result) {
        $(this).removeClass('fileupload-processing');
    }).done(function (result) {
        $(this).fileupload('option', 'done')
            .call(this, null, {result: result}); 
    });

    // Initialize the jQuery File Upload widget:
    $('#miniatura').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/novedades/miniatura',
        maxNumberOfFiles: 1,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        }
    });
    // Enable iframe cross-domain access via redirect option:
    $('#miniatura').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#miniatura').addClass('fileupload-processing');

    $.ajax({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: $('#miniatura').fileupload('option', 'url'),
        dataType: 'json',
        context: $('#miniatura')[0]
    }).always(function (result) {
        $(this).removeClass('fileupload-processing');
    }).done(function (result) {
        $(this).fileupload('option', 'done')
            .call(this, null, {result: result}); 
    });  

});