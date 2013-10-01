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
        src: ['js/libs/*.js', 'js/libs/jquery.bxslider/*.js', 'js/libs/mustache/*.js'],
        dest: 'js/libs.js',
      },
      iframe: {
        src: ['js/libs/bootstrap.min.js', 'js/libs/iframe/backbone-min.js', 'js/libs/iframe/underscore-min.js'],
        dest: 'js/iframe.libs.js',
      },
      css: {
        src: ['css/libs/*.css', 'css/ie.css', 'css/main.css'],
        dest: 'css/styles.css'
      }
    },
    removelogging: {
      app: {
        src: "js/app-dev.js",
        dest: "js/app.min.js",
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
      }
    },
    uglify: {
      app: {
        src: 'js/app.min.js',
        dest: 'js/app.min.js'
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
      }
    },
    cssmin: {
      minify: {
        expand: true,
        cwd: 'css/',
        src: ['styles.css'],
        dest: 'css/',
        ext: '.min.css'
      }
    },
    clean: ['js/libs.js', 'css/styles.css', 'js/iframe.libs.js'],
    watch : {
      scripts: {
        files: ['js/app-dev.js'],
        tasks: ['app'],
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
  grunt.registerTask('app', ['removelogging:app', 'uglify:app']); 
  grunt.registerTask('iframe-app', ['removelogging:iframe_app', 'uglify:iframe_app']); 
  grunt.registerTask('file-app', ['removelogging:file_app', 'uglify:file_app']); 
  grunt.registerTask('css', ['concat:css', 'cssmin', 'clean']);

};