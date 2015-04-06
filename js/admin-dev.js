jQuery(function($) {   

    var limitado = $('.texto-limitado'),
        form = $('form'),  
        limitnum, 
        PUBLIC_PATH = $("#PUBLIC_PATH").val();
    if(limitado[0])
    {
        limitado.after('<div class="counter"><span>0</span> caracteres</div>');
        limitnum = 200; // set your int limit for max number of characters
        if(limitado.data('limite'))
            limitnum = limitado.data('limite');
        limitado.keyup(function(){
            limiting($(this), limitnum);
        });
        limiting(limitado, limitnum);
    }//if(limitado[0])

    //Detección de cambios en formulario para confirmar salida
    if(form.length > 0 && form.id != 'login-form')
    {
        var isEdit  = false;  
        $('input').change(function() {  
            isEdit = true;  
        });
        $('select').change(function() {  
            isEdit = true;  
        });
        form.submit(function(){isEdit = false;});
        
        window.onbeforeunload = function (e) 
        {
            if(isEdit)
            {
                var message = "¿Seguro que deseas salir sin guardar los cambios?",
                    e       = e || window.event;
                if (e) 
                    e.returnValue = message; // For IE and Firefox
                return message; // For Safari
            }
        };
    }
    
    $('.chosen').chosen();

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
    $('#imagen_mobile').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/novedades/imagen_mobile',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagenMobile', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenMobileH').attr('value', data.result.archivoImagenMobile[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#imagen_mobile').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_mobile').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#miniatura').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/novedades/miniatura',
        maxNumberOfFiles: 0,
        previewMaxWidth: 50,
        previewMaxHeight: 35,
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
    $('#imagen_mobile_concurso').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/concursos/imagen_mobile',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagenMobile', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenMobileH').attr('value', data.result.archivoImagenMobile[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#imagen_mobile_concurso').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_mobile_concurso').addClass('fileupload-processing');

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
    $('#imagen_mobile_programa').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/programas/imagen_mobile',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagenMobile', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenMobileH').attr('value', data.result.archivoImagenMobile[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#imagen_mobile_programa').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_mobile_programa').addClass('fileupload-processing');

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
    $('#imagen_mobile_documental').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/documentales/imagen_mobile',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagenMobile', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenMobileH').attr('value', data.result.archivoImagenMobile[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#imagen_mobile_documental').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_mobile_documental').addClass('fileupload-processing');

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
    $('#imagen_mobile_especial').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/especiales/imagen_mobile',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagenMobile', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenMobileH').attr('value', data.result.archivoImagenMobile[0].name);
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
    $('#imagen_mobile_especial').addClass('fileupload-processing');

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
    $('#imagen_telemedellin').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/telemedellin/imagen',
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
    $('#imagen_telemedellin').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_telemedellin').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#imagen_mobile_telemedellin').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/telemedellin/imagen_mobile',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagenMobile', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenMobileH').attr('value', data.result.archivoImagenMobile[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#imagen_mobile_telemedellin').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_mobile_telemedellin').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#miniatura_telemedellin').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/telemedellin/miniatura',
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
    $('#miniatura_telemedellin').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#miniatura_telemedellin').addClass('fileupload-processing');

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


    // Initialize the jQuery File Upload widget:
    $('#background_pagina').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/pagina/imagen',
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
    $('#background_pagina').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );
    // Load existing files:
    $('#background_pagina').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#background_mobile_pagina').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/pagina/imagen_mobile',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagenMobile', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenMobileH').attr('value', data.result.archivoImagenMobile[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#background_mobile_pagina').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );
    // Load existing files:
    $('#background_mobile_pagina').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#miniatura_pagina').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/pagina/miniatura',
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
    $('#miniatura_pagina').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );
    // Load existing files:
    $('#miniatura_pagina').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#imagen_banner').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/novedades/imagen_banner',
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
    $('#imagen_banner').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_banner').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#imagen_mobile_banner').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/novedades/imagen_mobile_banner',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagenMobile', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenMobileH').attr('value', data.result.archivoImagenMobile[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#imagen_mobile_banner').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#imagen_mobile_banner').addClass('fileupload-processing');

     // Initialize the jQuery File Upload widget:
    $('#guino_guino').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/guino/guino',
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
    $('#guino_guino').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#guino_guino').addClass('fileupload-processing');

    // Initialize the jQuery File Upload widget:
    $('#guino_mobile_guino').fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: PUBLIC_PATH + '/administrador/guino/guino_mobile',
        maxNumberOfFiles: 0,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        paramName: 'archivoImagenMobile', 
        messages: {
            maxNumberOfFiles: 'Solo se permite una imagen',
            acceptFileTypes: 'No se acepta este tipo de archivo',
            maxFileSize: 'El archivo es muy pesado',
            minFileSize: 'El archivo no tiene peso suficiente'
        },
    }).bind('fileuploaddone', function(e, data){
        $('#archivoImagenMobileH').attr('value', data.result.archivoImagenMobile[0].name);
    });
    // Enable iframe cross-domain access via redirect option:
    $('#guino_mobile_guino').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#guino_mobile_guino').addClass('fileupload-processing');
});
function limiting(obj, limit) {
    var cnt = $(".counter > span"),
        txt = $(obj).val(),
        len = txt.length;

    // check if the current length is over the limit
    if(len > limit){
        $(obj).val(txt.substr(0,limit));
        $(cnt).html(len-1);
    } 
    else { 
        $(cnt).html(len);
    }

    // check if user has less than 20 chars left
    if(limit-len <= 20) {
        $(cnt).addClass("warning");
    }else
    {
        $(cnt).removeClass("warning");
    }

}