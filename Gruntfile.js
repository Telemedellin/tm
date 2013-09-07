module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        //separator: ';',
        stripBanners: true
      },
      js: {
        src: ['js/libs/*.js', 'js/libs/jquery.bxslider/*.js', 'js/libs/mustache/*.js'],
        dest: 'js/libs.js',
      },
      css: {
        src: ['css/libs/*', 'css/ie.css', 'css/main.css'],
        dest: 'css/styles.css'
      }
    },
    removelogging: {
      app: {
        src: "js/app-dev.js",
        dest: "js/app.min.js",
      },
      libs: {
        src: "js/libs.js",
        dest: "js/libs.js",
      }
    },
    uglify: {
      app: {
        src: 'js/app.min.js',
        dest: 'js/app.min.js'
      },
      libs: {
        src: 'js/libs.js',
        dest: 'js/libs.min.js'
      },
      css: {
        src: 'css/styles.css',
        dest: 'css/styles.min.css'
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
    clean: ['js/libs.js', 'css/styles.css'],
    watch : {
      scripts: {
        files: ['js/app-dev.js'],
        tasks: ['app'],
        options: {
          spawn: false
        },
      },
      styles: {
        files: ['css/*', 'css/libs/*'] ,
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
  grunt.registerTask('app', ['removelogging:app', 'uglify:app']); 
  grunt.registerTask('css', ['concat:css', /*'cssmin', 'clean'*/]);

};