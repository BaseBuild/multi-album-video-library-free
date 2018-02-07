'use strict';

var gulp    = require('gulp'),
	plugins = require('gulp-load-plugins')({ camelize: true });
var browserSync = require('browser-sync').create();

var paths = {
	src: {
		php: '../**/*.php',
		img: 'src/images/**/*.{png,jpg,gif,svg}',
		js: 'src/js/*.js',
		scss: 'src/scss/app.scss',
		scssWatch: 'src/scss/**/*.scss'
	},
	dest: {
		img: '../assets/images/',
		js: '../assets/js/',
		scss: '../assets/css/'
	}
}

function errorLog(error) {
    console.log(error.message);
    this.emit('end');
}

gulp.task('browser-sync', function() {
    browserSync.init( {
        proxy: "localhost",
    } );
});

gulp.task('browser-reload', function() {
	browserSync.reload();
});

gulp.task('sass', function() {
	return gulp.src( paths.src.scss )
		.pipe( plugins.sass( { outputStyle: 'compressed' } ) )
		.on('error', errorLog)
        .pipe( plugins.autoprefixer( 'last 4 versions' ) )
		.pipe( gulp.dest( paths.dest.scss ) )
		.pipe( browserSync.stream() )
		.pipe( plugins.notify( { message: 'Styles task complete' } ) );
});

gulp.task('js', function() {
	return gulp.src( paths.src.js )
		.pipe( plugins.concat( 'app.min.js' ) )
		.pipe( plugins.uglify() )
		.on('error', errorLog)
		.pipe( gulp.dest( paths.dest.js ) )
		.pipe( plugins.notify( { message: 'JS task complete' } ) );
});

gulp.task('img', function() {
	return gulp.src( paths.src.img )
		.pipe( plugins.cache( plugins.imagemin( { optimizationLevel: 7, progressive: true, interlaced: true } ) ) )
		.on('error', errorLog)
		.pipe( gulp.dest( paths.dest.img ) )
		.pipe( browserSync.stream() )
		.pipe( plugins.notify( { message: 'Images task complete' } ) );
});

gulp.task('clearCache', function(done) {
	return plugins.cache.clearAll(done);
});

gulp.task('watch', function(){
	gulp.watch( paths.src.php, ['browser-reload']);
	gulp.watch( paths.src.scssWatch, ['sass']);
	gulp.watch( paths.src.js, ['js']);
	gulp.watch( paths.src.img, ['img', 'browser-reload']);
});

gulp.task('default', ['sass', 'js', 'img', 'watch', 'browser-sync']);
