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
          'js/libs/admin/i18n/jquery.ui.datepicker-es.js',
          'js/libs/admin/jquery-ui-timepicker-addon.js',
          ],
        dest: 'js/admin.libs.js'
      },
      css: {
        src: ['css/libs/*.css', 'css/main.css'],
        dest: 'css/styles.css'
      },
      admin_css: {
        src: ['css/libs/admin/*.css', 'css/main_admin.css'],
        dest: 'css/styles.admin.css'
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
      }
    },
    clean: ['js/libs.js', 'css/styles.css', 'css/styles.admin.css', 'js/iframe.libs.js', 'js/admin.libs.js'],
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
        tasks: ['admin'],
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
  grunt.registerTask('app', ['removelogging:app', 'uglify:app']); 
  grunt.registerTask('admin-app', ['removelogging:admin_app', 'uglify:admin_app']); 
  grunt.registerTask('iframe-app', ['removelogging:iframe_app', 'uglify:iframe_app']); 
  grunt.registerTask('file-app', ['removelogging:file_app', 'uglify:file_app']); 
  grunt.registerTask('css', ['concat:css', 'cssmin:minify', 'clean']);
  grunt.registerTask('css_admin', ['concat:admin_css', 'cssmin:aminify', 'clean']);
};