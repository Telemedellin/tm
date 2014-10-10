module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        //separator: ';',
        stripBanners: false
      },
      js: {
        src: [
          'js/libs/*.js', 
          'js/libs/jquery.bxslider/*.js', 
          'js/libs/mustache/*.js'
        ],
        dest: 'js/libs.js',
      },
      iframe: {
        src: ['js/libs/bootstrap.min.js', 'js/libs/iframe/backbone-min.js', 'js/libs/iframe/underscore-min.js'],
        dest: 'js/iframe.libs.js'
      },
      admin: {
        src: [
          'js/libs/jquery.fancybox.pack.js', 
          'js/libs/admin/jstree.min.js',
          'js/libs/admin/jquery.fileupload/vendor/*.js', 
          'js/libs/admin/jquery.fileupload/tmpl.min.js',
          'js/libs/admin/jquery.fileupload/load-image.min.js',
          'js/libs/admin/jquery.fileupload/canvas-to-blob.min.js',
          'js/libs/admin/jquery.fileupload/jquery.iframe-transport.js',
          'js/libs/admin/jquery.fileupload/jquery.fileupload.js',
          'js/libs/admin/jquery.fileupload/jquery.fileupload-process.js',
          'js/libs/admin/jquery.fileupload/jquery.fileupload-resize.js',
          'js/libs/admin/jquery.fileupload/jquery.fileupload-validate.js',
          'js/libs/admin/jquery.fileupload/jquery.fileupload-ui.js',
          'js/libs/admin/chosen.jquery.js',
          ],
        dest: 'js/admin.libs.js'
      },
      adminlte: {
        src: [
          'js/libs/jquery.fancybox.pack.js', 
          'js/libs/admin/jstree.min.js',
          'js/libs/admin/jquery.fileupload/vendor/*.js', 
          'js/libs/admin/jquery.fileupload/tmpl.min.js',
          'js/libs/admin/jquery.fileupload/load-image.min.js',
          'js/libs/admin/jquery.fileupload/canvas-to-blob.min.js',
          'js/libs/admin/jquery.fileupload/jquery.iframe-transport.js',
          'js/libs/admin/jquery.fileupload/jquery.fileupload.js',
          'js/libs/admin/jquery.fileupload/jquery.fileupload-process.js',
          'js/libs/admin/jquery.fileupload/jquery.fileupload-resize.js',
          'js/libs/admin/jquery.fileupload/jquery.fileupload-validate.js',
          'js/libs/admin/jquery.fileupload/jquery.fileupload-ui.js',
          'js/libs/admin/chosen.jquery.js',
          ],
        dest: 'themes/adminlte/assets/js/admin.libs.js'
      },
      mobile: {
        src: [
          'js/libs/modernizr.custom.30163.js',
          'js/libs/mobile/jquery.fittext.js', 
          'js/libs/jquery.animate-enhanced.min.js',
          'js/libs/jquery.superslides.js',
          'js/libs/jquery.bxslider/*.js', 
          'js/libs/moment-with-langs.js', 
          'js/libs/jquery.mCustomScrollbar.concat.min.js', 
          'js/libs/mobile/jquery.backstretch.min.js',
          'js/libs/modernizr.custom.30163.js',
          'js/libs/mobile/bootstrap.min.js', 
          ],
        dest: 'js/mobile.libs.js'
      },
      css: {
        src: ['css/libs/*.css', 'css/main.css'],
        dest: 'css/styles.css'
      },
      admin_css: {
        src: ['css/libs/admin/*.css', 'css/libs/jquery.fancybox.css', 'css/main_admin.css'],
        dest: 'css/styles.admin.css'
      },
      adminlte_css: {
        src: ['css/libs/admin/*.css', 'css/libs/jquery.fancybox.css', 'themes/adminlte/assets/css/AdminLTE.css', 'css/main_admin.css'],
        dest: 'themes/adminlte/assets/css/styles.admin.css'
      },
      mobile_css: {
        src: ['css/libs/mobile/*.css', 'css/main_mobile.css'],
        dest: 'css/mobile.css'
      }
    },
    removelogging: {
      app: {
        src: "js/app-dev.js",
        dest: "js/app.min.js",
      },
      admin_app: {
        src: "js/admin-dev.js",
        dest: "js/admin.min.js",
      },
      mobile_app: {
        src: "js/mobile-dev.js",
        dest: "js/mobile.min.js",
      },
      iframe_app: {
        src: "js/iframe.app-dev.js",
        dest: "js/iframe.app.min.js",
      },
      file_app: {
        src: "js/file.app-dev.js",
        dest: "js/file.app.min.js",
      },
      libs: {
        src: "js/libs.js",
        dest: "js/libs.js",
      },
      iframe: {
        src: "js/iframe.libs.js",
        dest: "js/iframe.libs.js",
      },
      admin: {
        src: "js/admin.libs.js",
        dest: "js/admin.libs.js",
      },
      adminlte: {
        src: "themes/adminlte/assets/js/admin.libs.js",
        dest: "themes/adminlte/assets/js/admin.libs.js",
      },
      mobile: {
        src: "js/mobile.libs.js",
        dest: "js/mobile.libs.js",
      }
    },
    uglify: {
      app: {
        src: 'js/app.min.js',
        dest: 'js/app.min.js'
      },
      admin_app: {
        src: 'js/admin.min.js',
        dest: 'js/admin.min.js'
      },
      mobile_app: {
        src: 'js/mobile.min.js',
        dest: 'js/mobile.min.js'
      },
      iframe_app: {
        src: 'js/iframe.app.min.js',
        dest: 'js/iframe.app.min.js'
      },
      file_app: {
        src: 'js/file.app.min.js',
        dest: 'js/file.app.min.js'
      },
      libs: {
        src: 'js/libs.js',
        dest: 'js/libs.min.js'
      },
      iframe: {
        src: 'js/iframe.libs.js',
        dest: 'js/iframe.libs.min.js'
      },
      admin: {
        src: 'js/admin.libs.js',
        dest: 'js/admin.libs.min.js'
      },
      adminlte: {
        src: 'themes/adminlte/assets/js/admin.libs.js',
        dest: 'themes/adminlte/assets/js/admin.libs.min.js'
      },
      mobile: {
        src: 'js/mobile.libs.js',
        dest: 'js/mobile.libs.min.js'
      }
    },
    cssmin: {
      minify: {
        expand: true,
        cwd: 'css/',
        src: ['styles.css'],
        dest: 'css/',
        ext: '.min.css'
      },
      aminify: {
        expand: true,
        cwd: 'css/',
        src: ['styles.admin.css'],
        dest: 'css/',
        ext: '.admin.min.css'
      },
      alteminify: {
        expand: true,
        cwd: 'themes/adminlte/assets/css/',
        src: ['styles.admin.css'],
        dest: 'themes/adminlte/assets/css/',
        ext: '.admin.min.css'
      },
      mminify: {
        expand: true,
        cwd: 'css/',
        src: ['mobile.css'],
        dest: 'css/',
        ext: '.min.css'
      }
    },
    clean: ['js/libs.js', 'css/styles.css', 'css/styles.admin.css', 'css/mobile.css', 'js/iframe.libs.js', 'js/admin.libs.js', 'js/mobile.libs.js', 'themes/adminlte/assets/css/styles.admin.css', 'themes/adminlte/assets/js/admin.libs.js'],
    watch : {
      scripts: {
        files: ['js/app-dev.js'],
        tasks: ['app'],
        options: {
          spawn: false
        },
      },
      admin: {
        files: ['js/admin-dev.js'],
        tasks: ['admin', 'admin-app'],
        options: {
          spawn: false
        },
      },
      mobile: {
        files: ['js/mobile-dev.js'],
        tasks: ['mobile', 'mobile-app'],
        options: {
          spawn: false
        },
      },
      iframe: {
        files: ['js/iframe.app-dev.js'],
        tasks: ['iframe-app'],
        options: {
          spawn: false
        },
      },
      file: {
        files: ['js/file.app-dev.js'],
        tasks: ['file-app'],
        options: {
          spawn: false
        },
      },
      styles: {
        files: ['css/*.css', 'css/libs/*.css'] ,
        tasks: ['css'],
        options: {
          spawn: false
        },
      },
      styles_admin: {
        files: ['css/main_admin.css', 'css/libs/admin/*.css'] ,
        tasks: ['css_admin'],
        options: {
          spawn: false
        },
      },
      styles_adminlte: {
        files: ['css/main_admin.css', 'css/libs/admin/*.css', 'themes/adminlte/assets/css/AdminLTE.css' ] ,
        tasks: ['css_adminlte'],
        options: {
          spawn: false
        },
      },
      styles_mobile: {
        files: ['css/main_mobile.css', 'css/libs/mobile/*.css'] ,
        tasks: ['css_mobile'],
        options: {
          spawn: false
        },
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-remove-logging');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-cssmin');

  // Default task(s).
  grunt.registerTask('default', ['concat:js', 'removelogging:libs', 'uglify:libs', 'clean']);
  grunt.registerTask('iframe', ['concat:iframe', 'removelogging:iframe', 'uglify:iframe', 'clean']);
  grunt.registerTask('admin', ['concat:admin', 'removelogging:admin', 'uglify:admin', 'clean']);
  grunt.registerTask('adminlte', ['concat:adminlte', 'removelogging:adminlte', 'uglify:adminlte', 'clean']);
  grunt.registerTask('mobile', ['concat:mobile', 'removelogging:mobile', 'uglify:mobile', 'clean']);
  grunt.registerTask('app', ['removelogging:app', 'uglify:app']); 
  grunt.registerTask('admin-app', ['removelogging:admin_app', 'uglify:admin_app']); 
  grunt.registerTask('mobile-app', ['removelogging:mobile_app', 'uglify:mobile_app']); 
  grunt.registerTask('iframe-app', ['removelogging:iframe_app', 'uglify:iframe_app']); 
  grunt.registerTask('file-app', ['removelogging:file_app', 'uglify:file_app']); 
  grunt.registerTask('css', ['concat:css', 'cssmin:minify', 'clean']);
  grunt.registerTask('css_admin', ['concat:admin_css', 'cssmin:aminify', 'clean']);
  grunt.registerTask('css_adminlte', ['concat:adminlte_css', 'cssmin:alteminify', 'clean']);
  grunt.registerTask('css_mobile', ['concat:mobile_css', 'cssmin:mminify', 'clean']);
};