module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    concat: {
      options: {
        separator: ';',
      },
      dist: {
        src: ['js/libs/*.js', 'js/libs/jquery.bxslider/*.js', 'js/libs/mustache/*.js'],
        dest: 'js/libs.js',
      },
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
      }
    },
    clean: ['js/libs.js'],
    watch : {
      scripts: {
        files: ['js/app-dev.js'],
        tasks: ['app'],
        options: {
          spawn: false
        },
      },
    }
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-remove-logging');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-clean');

  // Default task(s).
  grunt.registerTask('default', ['concat', 'removelogging:libs', 'uglify:libs', 'clean']);
  grunt.registerTask('app', ['removelogging:app', 'uglify:app']);

};