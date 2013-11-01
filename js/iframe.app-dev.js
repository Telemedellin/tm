//"use strict";
function modificar_url(pagina, nombre){
    if(!nombre) nombre = null;
    if(Modernizr.history){
        var stateObj = { pagina: nombre };
        window.history.pushState( stateObj, null, pagina );
    }
}
function makeTitle(slug) {
    var words = slug.split('-');

    for(var i = 0; i < words.length; i++) {
      var word = words[i];
      words[i] = word.charAt(0).toUpperCase() + word.slice(1);
    }

    return words.join(' ');
}
jQuery(function($) {
    window.cv = 0;
    window.cva = 0;
    window.slider;
    //Modelos
	window.Album = Backbone.Model.extend({
		urlRoot: '/api/fotoalbum',
        defaults: {
		    id: '', 
            nombre : '',
		    url : '',
            thumb: ''
		}
	});

    window.Foto = Backbone.Model.extend({
       urlRoot: '/api/foto',
        defaults: {
            id: '', 
            nombre : '', 
            album_foto : '',
            url:'',
            src : '',
            thumb: '',
            ancho: '',
            alto: ''
        } 
    });

    window.VideoAlbum = Backbone.Model.extend({
        urlRoot: '/api/videoalbum',
        defaults: {
            id: '', 
            nombre : '',
            url : '',
            thumb: ''
        }
    });

    window.Video = Backbone.Model.extend({
       urlRoot: '/api/video',
        defaults: {
            id: '', 
            nombre : '', 
            descripcion : '',
            album_video : '',
            proveedor_video : '',
            url_video:'',
            id_video:'',
            url:'',
            duracion : '',
            thumbnail: ''
        } 
    });

    window.Micrositio = Backbone.Model.extend({
       urlRoot: '/api/micrositio',
        defaults: {
            id: '', 
            nombre : ''
        } 
    });

    //Colecciones
	window.AlbumCollection = Backbone.Collection.extend({
	    model : Album,
        url: '/api/fotoalbum'
	});

    window.FotoCollection = Backbone.Collection.extend({
        model : Foto,
        url: '/api/foto'
    });

    window.VideoAlbumCollection = Backbone.Collection.extend({
        model : VideoAlbum,
        url: '/api/videoalbum'
    });

    window.VideoCollection = Backbone.Collection.extend({
        model : Video,
        url: '/api/video'
    });

    //Helpers
    var template = function(id){
        return _.template( $('#' + id).html() );
    };

    //Vistas
    window.AlbumListView = Backbone.View.extend({
        template: template('albumListViewTemplate'),
        initialize:function () {
            this.collection.bind("reset", this.render, this);
            this.collection.bind("add", this.render, this);
            this.render;
        },
        render:function (eventName) {
            $(this.el).html( this.template( this.model.toJSON() ) );
            _.each(this.collection.models, function (album) {
                $('.albumes').append(new AlbumListItemView({model:album}).render().el).fadeIn('fast');
            }, this);
            return this;
        }
    });

    window.AlbumListItemView = Backbone.View.extend({
        tagName:"li",
        className: 'album', 
        template: template('albumListItemViewTemplate'),
        render:function (eventName) {
            console.log(this.model);
            $(this.el).html( this.template( this.model.toJSON() ) );
            return this;
        },
        close:function () {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });

    window.FotoListView = Backbone.View.extend({
        className: 'galeria',
        template: template('fotoListViewTemplate'),
        initialize:function () {
            this.collection.bind("reset", this.render, this);
            var self = this;
            this.render();
            this.collection.bind("add", this.add, this);
        },
        render:function (eventName) {
            $(this.el).html( this.template( this.model ) );
            window.c = 0;
            return this;
        },
        add: function(foto){
            var fliv = new FotoListItemView({model:foto});
            $('.fotos').append(fliv.render().el);
            if(foto.attributes.url == '#'+Backbone.history.fragment){
                $('.foto a.' + foto.attributes.id).trigger('click');
            }
            
            if(window.c <= 0){
                console.log(window.c);
                $('.foto a.' + foto.attributes.id).trigger('click').addClass('current');;
            }
            window.c += 1;
        }
    });

    window.FotoListItemView = Backbone.View.extend({
        tagName:"li",
        className:'foto',
        template: template('fotoListItemViewTemplate'),
        render:function (eventName) {
            $(this.el).html(this.template(this.model.toJSON())).fadeIn('fast');
            return this;
        },
        events:{
            "click a": "ver"
        },
        close:function () {
            $(this.el).unbind();
            $(this.el).remove();
        },
        ver: function (e) {
            if(e.currentTarget.dataset !== undefined) {
                var src = e.currentTarget.dataset.src;
                var nombre = e.currentTarget.dataset.nombre;
            } else {
                var src = e.currentTarget.getAttribute('data-src');
                var nombre = e.currentTarget.getAttribute('data-nombre');
            }
            $('.foto a').removeClass('current');
            $(e.currentTarget).addClass('current');
            $('.full').fadeOut('fast', function(){
                $('.full').html('<img src="' + src + '" /><h2>'+nombre+'</h2>').fadeIn('fast');
            });
            modificar_url(e.currentTarget.href, nombre);
            $('<div class="expander"></div>').appendTo('.full').fadeIn('slow').click(function() {
                if (screenfull.enabled) {
                    screenfull.toggle( $('.fancybox-outer')[0] );
                    $('.fancybox-outer').toggleClass('fullscreen');
                }
            });
            e.preventDefault();
        }
    });

    window.VideoAlbumListView = Backbone.View.extend({
        template: template('videoalbumListViewTemplate'),
        initialize:function () {
            this.collection.bind("reset", this.render, this);
            //this.collection.bind("add", this.render, this);
            this.collection.bind("add", this.add, this);
            //this.render();
        },
        render:function (eventName) {
            $(this.el).html( this.template( this.model.toJSON() ) ).fadeIn('fast');
            _.each(this.collection.models, function (album) {
                $('.videoalbumes').append(new VideoAlbumListItemView({model:album}).render().el);
            }, this);    
            return this;
        },
        add: function (videoAlbum){
            this.render();
        }
    });

    window.VideoAlbumListItemView = Backbone.View.extend({
        tagName:"li",
        className: 'videoalbum', 
        template: template('videoalbumListItemViewTemplate'),
        render:function (eventName) {
            $(this.el).html( this.template( this.model.toJSON() ) ).fadeIn('fast');
            return this;
        },
        close:function () {
            $(this.el).unbind();
            $(this.el).remove();
        }
    });

    window.VideoListView = Backbone.View.extend({
        className: 'videogaleria',
        template: template('videoListViewTemplate'),
        initialize:function () {
            this.collection.bind("reset", this.render, this);
            var self = this;
            this.render();
            this.collection.bind("add", this.add, this);
        },
        render:function (eventName) {
            $(this.el).html( this.template( this.model ) ).fadeIn('fast');
            window.c = 0;
            return this;
        },
        add: function(video){
            var vliv = new VideoListItemView({model:video});
            $('.ivideos').append(vliv.render().el).fadeIn('slow');
            if(video.attributes.url == '#'+Backbone.history.fragment){
                $('.video a.' + video.attributes.id).trigger('click');
            }
            if(window.cv <= 0){
                $('.video a.' + video.attributes.id).trigger('click');
                console.log('disparado el video ' + video.attributes.id);
            }
            window.cv += 1;
        }
    });

    window.VideoListItemView = Backbone.View.extend({
        tagName:"li",
        className:'video',
        template: template('videoListItemViewTemplate'),
        render:function (eventName) {
            $(this.el).html(this.template(this.model.toJSON())).fadeIn('fast');
            return this;
        },
        events:{
            "click a": "ver"
        },
        close:function () {
            $(this.el).unbind();
            $(this.el).remove();
        },
        ver: function (e) {
            if(e.currentTarget.dataset !== undefined) {
                var pv = e.currentTarget.dataset.pv,
                    id_video = e.currentTarget.dataset.id_video,
                    nombre = e.currentTarget.dataset.nombre;
            } else {
                var pv = e.currentTarget.getAttribute('data-pv'),
                    id_video = e.currentTarget.getAttribute('data-id_video'),
                    nombre = e.currentTarget.getAttribute('data-nombre');
            }
            var full = $('.full');
            if(pv == 'Youtube'){
                full.fadeOut('fast', function(){
                    full.html('<iframe type="text/html" height="80%" width="90%" src="http://www.youtube.com/embed/'+id_video+'?rel=0" frameborder="0"></iframe><h2>'+nombre+'</h2>').fadeIn('fast');
                });
            }else if(pv == 'Vimeo'){
                full.fadeOut('fast', function(){
                    full.html('<iframe src="http://player.vimeo.com/video/'+id_video+'" height="80%" width="90%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe><h2>'+nombre+'</h2>').fadeIn('fast');
                });
            }
            modificar_url(e.currentTarget.href, nombre);
            e.preventDefault();
        }
    });

    //Rutas
    var AppRouter = Backbone.Router.extend({
        routes: {
            "imagenes":                 "listarAlbumes",
            "imagenes/:album(/:foto)":  "listarFotos",
            "videos":                   "listarVideoAlbumes",
            "videos/:videoalbum(/:video)":"listarVideos"
        },
        initialize: function(){
            this.micrositio = new Micrositio();
            this.micrositio_id = $('#micrositio').data('micrositio-id');
            this.micrositio.fetch({data: {id: this.micrositio_id} });
            var re = new RegExp("(\/)+$", "g");
                this.route(/(.*)\/+$/, "trailFix", function (id) {
                // remove all trailing slashes if more than one
                id = id.replace(re, '');
                this.navigate(id, true);
            });
        },
        listarAlbumes: function() {
            this.albumList = new AlbumCollection();
            this.albumList.fetch({data: {micrositio_id: this.micrositio_id} });
            this.albumListView = new AlbumListView({collection:this.albumList, model: this.micrositio});
            $('#icontainer').html(this.albumListView.render().el);
        },
        listarFotos: function (album, foto) {
            this.fotoList = new FotoCollection();
            this.fotoList.fetch( 
                {
                    data: {
                        hash: window.location.hash, 
                        micrositio: this.micrositio_id
                    }, 
                    success: function(){
                        var full = $('.full'),
                            alto = $('.fancybox-inner').height();
                        full.css('height', (alto - 180) );
                        $('#icontainer .galeria .full img').css('max-height', (alto - 228));
                        if($(".fotos li").length > 8){
                            window.slider = $('.fotos').bxSlider({
                                pager: false,
                                minSlides: 1,
                                maxSlides: 15,
                                slideWidth: 100,
                                slideMargin: 8,
                                viewportWidth: '94%'
                            });
                        }
                    }
                } 
            );
            var fl = album.charAt(0).toUpperCase();
            album = fl + album.substring(1);
            album = makeTitle(album);
            console.log(album);
            console.dir(this.fotoList);
            this.fotoListView = new FotoListView({collection:this.fotoList, model: {nombre: album, foto_activa: foto} });
            $('#icontainer').html(this.fotoListView.render().el);
        },
        listarVideoAlbumes: function() {
            this.videoalbumList = new VideoAlbumCollection();
            this.videoalbumList.fetch({data: {micrositio_id: this.micrositio_id} });
            this.videoalbumListView = new VideoAlbumListView({collection:this.videoalbumList, model: this.micrositio});
            $('#icontainer').html(this.videoalbumListView.render().el);
        },
        listarVideos: function (videoalbum, video) {
            this.videolist = new VideoCollection();
            this.videolist.fetch( 
                {
                    data: {
                        hash: window.location.hash, 
                        micrositio: this.micrositio_id
                    },
                    success: function(){
                        
                        var full = $('.full'),
                            alto = $('.fancybox-inner').height();
                        full.css('height', (alto/1.6) );
                        $(".ivideos").wrap('<div id="scroll" style="height: '+(alto/4)+'px;"/>');
                        $("#scroll").mCustomScrollbar({
                            scrollType: "pixels",
                            scrollButtons: {
                                enable: true
                            }
                        });
                        console.log('Success');
                    }
                }
            );
            var fl = videoalbum.charAt(0).toUpperCase();
            videoalbum = fl + videoalbum.substring(1);
            videoalbum = makeTitle(videoalbum);
            console.log(videoalbum);
            console.dir(this.videolist);
            this.videolistView = new VideoListView({collection:this.videolist, model: {nombre: videoalbum, video_activo: video} });
            $('#icontainer').html(this.videolistView.render().el);
        }
    });
    var app = new AppRouter();
    Backbone.history.start();
});