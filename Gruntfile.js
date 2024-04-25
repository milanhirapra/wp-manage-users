/* jshint node:true */
/* global module */
module.exports = function(grunt) {

    var sass = require( 'node-sass' ),
        SOURCE_DIR = './';

    require( 'matchdep' ).filterDev(
        [
            'grunt-*'
        ]
    ).forEach( grunt.loadNpmTasks );

    // Project configuration.
    grunt.initConfig(
        {
            pkg: grunt.file.readJSON( 'package.json' ),

            jshint: {
                options: grunt.file.readJSON( '.jshintrc' ),
                grunt: {
                    src: [ 'Gruntfile.js' ]
                },
                core: {
                    expand: true,
                    cwd: SOURCE_DIR,
                    src: [
                        '**/*.js',
                        '!**/*.min.js',
                        '!**/vendor/**/*.js',
                        '!**/lib/*.js',
                        '!**/node_modules/**/*.js',
                    ]
                }
            },

            sass: {
                options: {
                    outputStyle: 'expanded',
                    implementation: sass,
                },
                page: {
                    cwd: SOURCE_DIR,
                    extDot: 'last',
                    expand: true,
                    ext: '.css',
                    flatten: true,
                    src: [ 'assets/sass/*.scss' ],
                    dest: SOURCE_DIR + 'assets/css/'
                },
            },

            checktextdomain: {
                options: {
                    correct_domain: false,
                    text_domain: [ 'wp-manage-users' ],
                    keywords: [
                        '__:1,2d',
                        '_e:1,2d',
                        '_x:1,2c,3d',
                        '_n:1,2,4d',
                        '_ex:1,2c,3d',
                        '_nx:1,2,4c,5d',
                        'esc_attr__:1,2d',
                        'esc_attr_e:1,2d',
                        'esc_attr_x:1,2c,3d',
                        'esc_html__:1,2d',
                        'esc_html_e:1,2d',
                        'esc_html_x:1,2c,3d',
                        '_n_noop:1,2,3d',
                        '_nx_noop:1,2,3c,4d'
                    ]
                },
                files: {
                    cwd: SOURCE_DIR,
                    src: [
                        '**/*.php',
                        '!**/vendor/**/*.php',
                        '!**/node_modules/**/*.php'
                    ],
                    expand: true
                }
            },

            makepot: {
                src: {
                    options: {
                        cwd: SOURCE_DIR,
                        domainPath: 'languages',
                        exclude: [ 'vendor/*', 'node_modules/*' ], // List of files or directories to ignore.
                        mainFile: 'wp-manage-users.php',
                        potFilename: 'wp-manage-users.pot',
                        potHeaders: { // Headers to add to the generated POT file.
                            poedit: true, // Includes common Poedit headers.
                            'Last-Translator': 'Milan Hirapra <milan.hirpara1@gmail.com>',
                            'Language-Team': 'Milan Hirapra <milan.hirpara1@gmail.com>',
                            'report-msgid-bugs-to': 'https://github.com/milanhirapra',
                            'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
                        },
                        processPot: function( pot ) {
                            var translation,
                                excluded_meta = [
                                    'Plugin Name of the plugin/theme',
                                    'Plugin URI of the plugin/theme',
                                    'Author of the plugin/theme',
                                    'Author URI of the plugin/theme',
                                    'Description of the plugin/theme'
                                ];

                            for ( translation in pot.translations[''] ) {
                                if ( 'undefined' !== typeof pot.translations[''][ translation ].comments.extracted ) {
                                    if ( excluded_meta.indexOf( pot.translations[''][ translation ].comments.extracted ) >= 0 ) {
                                        delete pot.translations[''][ translation ];
                                    }
                                }
                            }

                            return pot;
                        },
                        type: 'wp-plugin',
                        updateTimestamp: true, // Whether the POT-Creation-Date should be updated without other changes.
                        updatePoFiles: false // Whether to update PO files in the same directory as the POT file.
                    }
                }
            },

            uglify: {
                all: {
                    files: [
                        {
                            expand: true,
                            cwd: 'assets/js/',
                            src: [
                                '*.js',
                                '!*.min.js',
                            ],
                            dest: 'assets/js/',
                            ext: '.min.js'
                        }
                    ]
                }
            },

            cssmin: {
                all: {
                    files: [
                        {
                            expand: true,
                            cwd: 'assets/css/',
                            src: [ '*.css', '!*.min.css' ],
                            dest: 'assets/css/',
                            ext: '.min.css'
                        }
                    ]
                }
            }
        }
    );

    // SASS, CSS and JS.
    grunt.registerTask( 'minify_js', [ 'jshint', 'uglify' ] );
    grunt.registerTask( 'scss', [ 'sass' ] );
    grunt.registerTask( 'minify_css', [ 'scss', 'cssmin' ] );
    grunt.registerTask( 'minify', [ 'minify_css', 'minify_js' ] );

    // Text Domain.
    grunt.registerTask( 'dist', [ 'minify', 'checktextdomain', 'makepot' ] );

    // Default command.
    grunt.registerTask( 'default', [ 'dist' ] );

};