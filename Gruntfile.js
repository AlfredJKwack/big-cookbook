module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    bower: {
        dev: {
            base: 'bower_components', /* the path to the bower_components directory */
            dest: 'web/bower_components',
            options: {
                checkExistence: true,
                debugging: true,
                paths: {
                    bowerDirectory: 'bower_components',
                    bowerrc: '.bowerrc',
                    bowerJson: 'bower.json'
                }
            }
        },
        flat: { /* flat folder/file structure */
            dest: 'lib/vendor',
            options: {
                debugging: true
            }
        }
    }
  });

  // Load the plugins that provide the tasks.
  //grunt.loadNpmTasks('grunt-contrib-uglify');
  //grunt.loadNpmTasks('grunt-contrib-watch');
  //grunt.loadNpmTasks('grunt-contrib-concat');
  //grunt.loadNpmTasks('grunt-contrib-copy');
  //grunt.loadNpmTasks('grunt-bower-task');
  grunt.loadNpmTasks('main-bower-files');

  // Default task(s).
  //grunt.registerTask('default', ['copy']);

};
