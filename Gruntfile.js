module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        separator: ';',
        stripBanners: false
      },
      js: {
        src: [
          'public_html/js/libs/jquery-*.js', 
          'public_html/js/libs/*.js', 
          'public_html/js/libs/jquery.bxslider/*.js', 
          'public_html/js/libs/mustache/*.js',
        ],
        dest: 'public_html/js/libs.js',
      },
      iframe: {
        src: ['public_html/js/libs/bootstrap.min.js', 'public_html/js/libs/iframe/backbone-min.js', 'public_html/js/libs/iframe/underscore-min.js'],
        dest: 'public_html/js/iframe.libs.js'
      },
      admin: {
        src: [
          'public_html/js/libs/jquery.fancybox.pack.js', 
          'public_html/js/libs/admin/jstree.min.js',
          'public_html/js/libs/admin/jquery.fileupload/vendor/*.js', 
          'public_html/js/libs/admin/jquery.fileupload/tmpl.min.js',
          'public_html/js/libs/admin/jquery.fileupload/load-image.min.js',
          'public_html/js/libs/admin/jquery.fileupload/canvas-to-blob.min.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.iframe-transport.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.fileupload.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.fileupload-process.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.fileupload-resize.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.fileupload-validate.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.fileupload-ui.js',
          'public_html/js/libs/admin/chosen.jquery.js',
          ],
        dest: 'public_html/js/admin.libs.js'
      },
      adminlte: {
        src: [
          'public_html/js/libs/jquery.fancybox.pack.js', 
          'public_html/js/libs/admin/jstree.min.js',
          'public_html/js/libs/admin/jquery.fileupload/vendor/*.js', 
          'public_html/js/libs/admin/jquery.fileupload/tmpl.min.js',
          'public_html/js/libs/admin/jquery.fileupload/load-image.min.js',
          'public_html/js/libs/admin/jquery.fileupload/canvas-to-blob.min.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.iframe-transport.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.fileupload.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.fileupload-process.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.fileupload-resize.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.fileupload-validate.js',
          'public_html/js/libs/admin/jquery.fileupload/jquery.fileupload-ui.js',
          'public_html/js/libs/admin/chosen.jquery.js',
          ],
        dest: 'public_html/themes/adminlte/assets/js/admin.libs.js'
      },
      mobile: {
        src: [
          'public_html/js/libs/modernizr.custom.30163.js',
          'public_html/js/libs/mobile/jquery.fittext.js', 
          'public_html/js/libs/jquery.animate-enhanced.min.js',
          'public_html/js/libs/jquery.superslides.js',
          'public_html/js/libs/jquery.bxslider/*.js', 
          'public_html/js/libs/moment-with-langs.js', 
          'public_html/js/libs/jquery.mCustomScrollbar.concat.min.js', 
          'public_html/js/libs/mobile/jquery.backstretch.min.js',
          'public_html/js/libs/mobile/bootstrap.min.js', 
          ],
        dest: 'public_html/js/mobile.libs.js'
      },
      css: {
        src: ['public_html/css/libs/*.css', 'public_html/css/main.css'],
        dest: 'public_html/css/styles.css'
      },
      admin_css: {
        src: ['public_html/css/libs/admin/*.css', 'public_html/css/libs/jquery.fancybox.css', 'public_html/css/main_admin.css'],
        dest: 'public_html/css/styles.admin.css'
      },
      adminlte_css: {
        src: ['public_html/css/libs/admin/*.css', 'public_html/css/libs/jquery.fancybox.css', 'public_html/themes/adminlte/assets/css/AdminLTE.css', 'public_html/css/main_admin.css'],
        dest: 'public_html/themes/adminlte/assets/css/styles.admin.css'
      },
      mobile_css: {
        src: ['public_html/css/libs/mobile/*.css', 'public_html/css/main_mobile.css'],
        dest: 'public_html/css/mobile.css'
      }
    },
    removelogging: {
      app: {
        src: 'public_html/js/app-dev.js',
        dest: 'public_html/js/app.min.js',
      },
      admin_app: {
        src: 'public_html/js/admin-dev.js',
        dest: 'public_html/js/admin.min.js',
      },
      mobile_app: {
        src: 'public_html/js/mobile-dev.js',
        dest: 'public_html/js/mobile.min.js',
      },
      iframe_app: {
        src: 'public_html/js/iframe.app-dev.js',
        dest: 'public_html/js/iframe.app.min.js',
      },
      file_app: {
        src: 'public_html/js/file.app-dev.js',
        dest: 'public_html/js/file.app.min.js',
      },
      libs: {
        src: 'public_html/js/libs.js',
        dest: 'public_html/js/libs.js',
      },
      iframe: {
        src: 'public_html/js/iframe.libs.js',
        dest: 'public_html/js/iframe.libs.js',
      },
      admin: {
        src: 'public_html/js/admin.libs.js',
        dest: 'public_html/js/admin.libs.js',
      },
      adminlte: {
        src: 'public_html/themes/adminlte/assets/js/admin.libs.js',
        dest: 'public_html/themes/adminlte/assets/js/admin.libs.js',
      },
      mobile: {
        src: 'public_html/js/mobile.libs.js',
        dest: 'public_html/js/mobile.libs.js',
      }
    },
    uglify: {
      app: {
        src: 'public_html/js/app.min.js',
        dest: 'public_html/js/app.min.js'
      },
      admin_app: {
        src: 'public_html/js/admin.min.js',
        dest: 'public_html/js/admin.min.js'
      },
      mobile_app: {
        src: 'public_html/js/mobile.min.js',
        dest: 'public_html/js/mobile.min.js'
      },
      iframe_app: {
        src: 'public_html/js/iframe.app.min.js',
        dest: 'public_html/js/iframe.app.min.js'
      },
      file_app: {
        src: 'public_html/js/file.app.min.js',
        dest: 'public_html/js/file.app.min.js'
      },
      libs: {
        src: 'public_html/js/libs.js',
        dest: 'public_html/js/libs.min.js'
      },
      iframe: {
        src: 'public_html/js/iframe.libs.js',
        dest: 'public_html/js/iframe.libs.min.js'
      },
      admin: {
        src: 'public_html/js/admin.libs.js',
        dest: 'public_html/js/admin.libs.min.js'
      },
      adminlte: {
        src: 'public_html/themes/adminlte/assets/js/admin.libs.js',
        dest: 'public_html/themes/adminlte/assets/js/admin.libs.min.js'
      },
      mobile: {
        src: 'public_html/js/mobile.libs.js',
        dest: 'public_html/js/mobile.libs.min.js'
      }
    },
    cssmin: {
      minify: {
        expand: true,
        cwd: 'public_html/css/',
        src: ['styles.css'],
        dest: 'public_html/css/',
        ext: '.min.css'
      },
      aminify: {
        expand: true,
        cwd: 'public_html/css/',
        src: ['styles.admin.css'],
        dest: 'public_html/css/',
        ext: '.admin.min.css'
      },
      alteminify: {
        expand: true,
        cwd: 'public_html/themes/adminlte/assets/css/',
        src: ['styles.admin.css'],
        dest: 'public_html/themes/adminlte/assets/css/',
        ext: '.admin.min.css'
      },
      mminify: {
        expand: true,
        cwd: 'public_html/css/',
        src: ['mobile.css'],
        dest: 'public_html/css/',
        ext: '.min.css'
      }
    },
    clean: ['public_html/js/libs.js', 'public_html/css/styles.css', 'public_html/css/styles.admin.css', 'public_html/css/mobile.css', 'public_html/js/iframe.libs.js', 'public_html/js/admin.libs.js', 'public_html/js/mobile.libs.js', 'public_html/themes/adminlte/assets/css/styles.admin.css', 'public_html/themes/adminlte/assets/js/admin.libs.js'],
    watch : {
      scripts: {
        files: ['public_html/js/app-dev.js'],
        tasks: ['app'],
        options: {
          spawn: false
        },
      },
      admin: {
        files: ['public_html/js/admin-dev.js'],
        tasks: ['adminlte', 'admin-app'],
        options: {
          spawn: false
        },
      },
      mobile: {
        files: ['public_html/js/mobile-dev.js'],
        tasks: ['mobile', 'mobile-app'],
        options: {
          spawn: false
        },
      },
      iframe: {
        files: ['public_html/js/iframe.app-dev.js'],
        tasks: ['iframe-app'],
        options: {
          spawn: false
        },
      },
      file: {
        files: ['public_html/js/file.app-dev.js'],
        tasks: ['file-app'],
        options: {
          spawn: false
        },
      },
      styles: {
        files: ['public_html/css/*.css', 'public_html/css/libs/*.css'] ,
        tasks: ['public_html/css'],
        options: {
          spawn: false
        },
      },
      styles_admin: {
        files: ['public_html/css/main_admin.css', 'public_html/css/libs/admin/*.css'] ,
        tasks: ['public_html/css_admin'],
        options: {
          spawn: false
        },
      },
      styles_adminlte: {
        files: ['public_html/css/main_admin.css', 'public_html/css/libs/admin/*.css', 'public_html/themes/adminlte/assets/css/AdminLTE.css' ] ,
        tasks: ['public_html/css_adminlte'],
        options: {
          spawn: false
        },
      },
      styles_mobile: {
        files: ['public_html/css/main_mobile.css', 'public_html/css/libs/mobile/*.css'] ,
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