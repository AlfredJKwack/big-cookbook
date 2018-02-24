module.exports = function( grunt ) {

  // Project configuration.
  grunt.initConfig({
    copy: {
      main: {
        files: [
          { src:'node_modules/jquery-focuspoint/css/focuspoint.css',      dest:'lib/vendor/focuspoint.css' },
          { src:'node_modules/normalize-css/normalize.css',               dest:'lib/vendor/normalize.css' },
          { src:'node_modules/jquery/dist/jquery.min.js',                 dest:'lib/vendor/jquery.min.js' },
          { src:'node_modules/jquery-focuspoint/js/jquery.focuspoint.js', dest:'lib/vendor/jquery-focuspoint.js' },
          { src:'node_modules/smartcrop/smartcrop.js',                    dest:'lib/vendor/smartcrop.js' },
          { src:'node_modules/background-check/background-check.min.js',  dest:'lib/vendor/background-check.min.js' }
        ]
      }
    },
    cssmin: {
      target: {
        files: [{
          expand: true,
          cwd: 'lib/vendor/',
          src: ['*.css', '!*.min.css'],
          dest: 'lib/vendor/',
          ext: '.min.css'
        }]
      }
    },
    uglify: {
      my_target: {
        files: [{
          expand: true,
          cwd: 'lib/vendor/',
          src: ['*.js', '!*.min.js'],
          dest: 'lib/vendor/',
          ext: '.min.js'
        }]
      }
    },
    clean: {
      css: ['lib/vendor/*.css', '!lib/vendor/*.min.css'],
      js: ['lib/vendor/*.js', '!lib/vendor/*.min.js']
    }
  });

  // Load the plugins that provide the tasks.
  //grunt.loadNpmTasks('grunt-contrib-watch');
  //grunt.loadNpmTasks('grunt-contrib-concat');

  grunt.loadNpmTasks( 'grunt-contrib-uglify' );
  grunt.loadNpmTasks( 'grunt-contrib-copy' );
  grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
  grunt.loadNpmTasks( 'grunt-contrib-clean' );

  // Default task(s).
  grunt.registerTask(
    'default',
    [
      'copy',
      'cssmin',
      'uglify',
      'clean'
    ]
  );
};
