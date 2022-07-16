// Load Gulp...of course
var gulp         = require( 'gulp' );

// CSS related plugins
var sass         = require( 'gulp-sass' ) (require( 'sass' ) );
var autoprefixer = require( 'gulp-autoprefixer' );

// JS related plugins
var uglify       = require( 'gulp-uglify' );
var babelify     = require( 'babelify' );
var browserify   = require( 'browserify' );
var source       = require( 'vinyl-source-stream' );
var buffer       = require( 'vinyl-buffer' );
var stripDebug   = require( 'gulp-strip-debug' );

// Utility plugins
var rename       = require( 'gulp-rename' );
var sourcemaps   = require( 'gulp-sourcemaps' );
var notify       = require( 'gulp-notify' );
var options      = require( 'gulp-options' );
var gulpif       = require( 'gulp-if' );

// Browers related plugins
var browserSync  = require( 'browser-sync' ).create();

// Project related variables
var styleSRC     = 'src/scss/mystyles.scss';
var styleURL     = './assets/';
var mapURL       = './';

var jsSRC        = 'src/js/myscript.js';
var jsURL        = './assets/';

var styleWatch   = 'src/scss/**/*.scss';
var jsWatch      = 'src/js/**/*.js';
var phpWatch     = '**/*.php';

// Tasks
function browser_sync() {
	browserSync.init({
		server: {
			baseDir: "./"
		}
	});
};

function css(done) {
	gulp.src( styleSRC )
		.pipe( sourcemaps.init() )
		.pipe( sass({
			errLogToConsole: true,
			outputStyle: 'compressed'
		}) )
		.on( 'error', console.error.bind( console ) )
		.pipe( autoprefixer() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( sourcemaps.write( mapURL ) )
		.pipe( gulp.dest( styleURL ) )
		.pipe( browserSync.stream() );
	done();
};

function js() {
	return browserify({
		entries: [jsSRC]
	})
	.transform( babelify, { presets: [ '@babel/preset-env' ] } )
	.bundle()
	.pipe( source( 'myscript.js' ) )
	.pipe( rename( { extname: '.min.js' } ) )
	.pipe( buffer() )
	.pipe( gulpif( options.has( 'production' ), stripDebug() ) )
	.pipe( sourcemaps.init({ loadMaps: true }) )
	.pipe( uglify() )
	.pipe( sourcemaps.write( '.' ) )
	.pipe( gulp.dest( jsURL ) )
	.pipe( browserSync.stream() );
 };

function reload(done) {
	browserSync.reload();
	done();
}

function watch() {
	gulp.watch( styleWatch, gulp.series( css, reload ) ); 
	gulp.watch( jsWatch, gulp.series( js, reload ) ); 
	gulp.watch( phpWatch, reload ); 
	gulp.src( jsURL + 'myscript.min.js')
		.pipe( notify({ message: 'Gulp is Watching, Happy Coding!' }) );
}

 gulp.task( "css", css );
 gulp.task( "js", js );
 gulp.task( "default", gulp.parallel( css, js ) );
 gulp.task( "watch", gulp.parallel( browser_sync, watch ) );