jQuery(function($) {    
    var PUBLIC_PATH = $("#PUBLIC_PATH").val();
    var numPerfil = $("#fotoPerfil .template-download:not('.ui-state-error')").length;

    // Initialize the jQuery File Upload widget:
    $('#imagen').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/novedades/imagen',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagen', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenH').attr('value', data.result.archivoImagen[0].name);
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

    // Initialize the jQuery File Upload widget:
    $('#miniatura').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/novedades/miniatura',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoMiniatura', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        }
    }).bind('fileuploaddone', function(e, data){
        $('#archivoMiniaturaH').attr('value', 'thumbnail/'+data.result.archivoMiniatura[0].name);
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

    // Initialize the jQuery File Upload widget:
    $('#imagen_concurso').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/concursos/imagen',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagen', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenH').attr('value', data.result.archivoImagen[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#imagen_concurso').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_concurso').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#miniatura_concurso').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/concursos/miniatura',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoMiniatura', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        }
    }).bind('fileuploaddone', function(e, data){
        $('#archivoMiniaturaH').attr('value', 'thumbnail/'+data.result.archivoMiniatura[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#miniatura_concurso').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#miniatura_concurso').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#imagen_programa').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/programas/imagen',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagen', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenH').attr('value', data.result.archivoImagen[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#imagen_programa').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_programa').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#miniatura_programa').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/programas/miniatura',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoMiniatura', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        }
    }).bind('fileuploaddone', function(e, data){
        $('#archivoMiniaturaH').attr('value', 'thumbnail/'+data.result.archivoMiniatura[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#miniatura_programa').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#miniatura_programa').addClass('fileupload-processing');



    // Initialize the jQuery File Upload widget:
    $('#imagen_documental').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/documentales/imagen',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagen', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenH').attr('value', data.result.archivoImagen[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#imagen_documental').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_documental').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#miniatura_documental').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/documentales/miniatura',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoMiniatura', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        }
    }).bind('fileuploaddone', function(e, data){
        $('#archivoMiniaturaH').attr('value', 'thumbnail/'+data.result.archivoMiniatura[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#miniatura_documental').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#miniatura_documental').addClass('fileupload-processing');

     // Initialize the jQuery File Upload widget:
    $('#imagen_especial').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/especiales/imagen',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagen', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenH').attr('value', data.result.archivoImagen[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#imagen_especial').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_especial').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#miniatura_especial').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/especiales/miniatura',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoMiniatura', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        }
    }).bind('fileuploaddone', function(e, data){
        $('#archivoMiniaturaH').attr('value', 'thumbnail/'+data.result.archivoMiniatura[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#miniatura_especial').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#miniatura_especial').addClass('fileupload-processing');


    // Initialize the jQuery File Upload widget:
    $('#thumb_albumvideo').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/albumvideo/miniatura',
        maxNumberOfFiles: 0,
        previewMaxWidth: 240,
        previewMaxHeight: 180,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoMiniatura', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        }
    }).bind('fileuploaddone', function(e, data){
        $('#archivoMiniaturaH').attr('value', data.result.archivoMiniatura[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#thumb_albumvideo').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#thumb_albumvideo').addClass('fileupload-processing');
});