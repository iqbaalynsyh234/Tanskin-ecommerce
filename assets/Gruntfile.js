module.exports = function(grunt) {

    'use strict';

    var config = {
        pkg: grunt.file.readJSON('package.json'),
        sass: {
            options: {
                sourceMap: true,
                //outputStyle: 'compact'
                outputStyle: 'compressed'
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: 'scss',
                    src: ['*.scss'],
                    dest: 'css/',
                    ext: '.css'
                }]
            }
        },
        watch: {
            css: {
                files: 'scss/*.scss',
                tasks: ['sass'],
                options: {
                    spawn: true,
                    reload: true,
                }
            },
        },     
    };

    //grunt.loadNpmTasks('grunt-browser-sync');
    grunt.loadNpmTasks('grunt-contrib-watch');
    //grunt.loadNpmTasks('grunt-cssbeautifier');
    grunt.loadNpmTasks('grunt-sass');
    //grunt.loadNpmTasks('grunt-newer');

    // Register tasks
    grunt.initConfig(config);

    grunt.registerTask('default', ['sass','watch']);

};
