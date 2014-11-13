module.exports = function(grunt) {

  grunt.initConfig({
    // Cleans everything on public assets folder
    clean: {
      main: ['./public/assets/js', './public/assets/css'],
      css: ['./public/assets/css/main.css'],
      js: ['./public/assets/js']
    },
    /**
     * All javascripts are concatenated in one main.js file
     * Vendor files must be added by hand to src array
     */
    concat: {
      options: {
        separator: ';'
      },
      // Modules ;)
      frontpage: {
        src: [
          './frontend/js/frontpage/*.js',
        ],
        dest: './public/assets/js/frontpage.js'
      },
      devices: {
        src: ['./frontend/js/devices/**/*.js'],
        dest: './public/assets/js/devices.js'
      },
      templates: {
        src: ['./frontend/js/templates/**/*.js'],
        dest: './public/assets/js/templates.js'
      },
      // upload: {
      //   src: [
      //     './frontend/js/upload/jquery.ui.widget.js',
      //     './frontend/js/upload/jquery.iframe-transport.js',
      //     './frontend/js/upload/jquery.fileupload.js',
      //   ],
      //   dest: './public/assets/js/upload  .js'
      // }
    },
    /**
     * Compiles all stylesheets in different files in public/assets/css
     */
    compass: {
      options: {
        noLineComments: true,
        sassDir: './frontend/css',
        cssDir: './public/assets/css'
      },
      dist: {}
    },
    /**
     * Generates two stylesheet files:
     * The first one that concats all compiled
     * files by compass along with vendors (they must be added manually)
     * The second one that only have a vendor concatenation
     */
    cssmin: {
      add_banner: {
        options: {
          banner: '/* Beehive */'
        },
        files: {
          './public/assets/css/main.css': [
            './public/assets/css/**/*.css'
          ],
          // './public/assets/css/vendors.css': [
          //   './frontend/vendor/css/bootstrap.min.css',
          //   './frontend/vendor/css/font-awesome.min.css',
          //   './frontend/vendor/css/summernote.css'
          // ]
        }
      }
    },
    /**
     * Uglifies or minifies file main.js so it can be lesser size
     */
    uglify: {
      options: {
        mangled: false
      },
      modules: {
        files: [{
          expand: true,
          cwd: './public/assets/js',
          src: '**/*.js',
          dest: './public/assets/js',
          ext: '.min.js'
        }]
      }
    },
    /**
     * Watchs for changes in vendors (manually added)
     * and all js files in ./frontend/js
     * It also compiles and concatenates css files
     */
    watch: {
      javascript: {
        files: [
          './frontend/js/**/*.js'
        ],
        // as this is not a single page application, I prefer to only copy files
        tasks: ['clean:js','concat',
                'uglify:modules'],
        options: {
          livereload: false
        }
      },
      compass: {
        files: [
          './frontend/css/**/*.{scss,sass}'
        ],
        tasks: ['compass', 'clean:css', 'cssmin']
      }
    },
  });


  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('build', [
    'clean:main',
    'compass',
    'cssmin',
    'concat',
    'uglify:modules'
  ]);
  grunt.registerTask('default', ['build', 'watch']);
};
