gulp = require('gulp')
$ = require('gulp-load-plugins')()
runSequence = require('run-sequence')
spritesmith = require('gulp.spritesmith')
supported = [
  'ios >= 7',
  'android >= 4',
  'ie >= 10',
]

# Events
errorHandler = (error) ->
  notifier.notify
    message: error.message
    title: error.plugin
    sound: 'Glass'
  return

# Tasks
## Sass
gulp.task 'sass', ->
  gulp
    .src 'sass/**'
    .pipe $.plumber({
      errorHandler: $.notify.onError('<%= error.message %>')
    })
    .pipe $.sass({outputStyle: 'compressed'})
    .pipe $.autoprefixer({browsers: supported, add: true})
    .pipe gulp.dest 'stylesheets/'

## JavsScript
## Babel
gulp.task 'babel', ->
  gulp
    .src 'javascripts/es6/*.js'
    .pipe $.plumber({
      errorHandler: $.notify.onError('<%= error.message %>')
    })
    .pipe $.babel({presets: ['es2015']})
    .pipe gulp.dest 'javascripts/compile/'


# Concat
gulp.task 'concatjs', ->
  gulp
    .src ['javascripts/compile/*.js']
    .pipe $.plumber()
    .pipe $.concat 'app.js'
    .pipe $.uglify({
      preserveComments: 'license',
    })
    .pipe gulp.dest 'dist/scripts/'

gulp.task 'concat_vendor_js', ->
  gulp
    .src ['javascripts/vendor/*.js']
    .pipe $.plumber()
    .pipe $.uglify({
      preserveComments: 'license',
    })
    .pipe $.concat 'libs.js'
    .pipe gulp.dest 'dist/scripts/'

# Watch
gulp.task 'watch', ->
  gulp.watch 'javascripts/es6/**', ['babel']
  gulp.watch 'javascripts/compile/**', ['concatjs']
  gulp.watch 'javascripts/vendor/**', ['concat_vendor_js']
  gulp.watch 'sass/**', ['sass']

# Default -> Watch
gulp.task 'default', (callback) -> runSequence(
  'watch',
  callback
)
