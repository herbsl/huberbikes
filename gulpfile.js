var gulp = require('gulp'),
	jshint = require('gulp-jshint'),
	concat = require('gulp-concat'),
	rename = require('gulp-rename'),
	uglify = require('gulp-uglify'),
	gzip = require('gulp-gzip'),
	util = require('gulp-util'),
	clean = require('gulp-clean'),
	cache = require('gulp-cache'),
	imagemin = require('gulp-imagemin'),
	rev = require('gulp-rev'),
	mincss = require('gulp-minify-css');

gulp.task('img:clean', function() {
	return gulp.src('public/img', {
		read: false
	})
	.pipe(clean())
});

gulp.task('img:main', function() {
	return gulp.src([
		'assets/img/**/*'
	])
	.pipe(cache(
		imagemin({
			optimizationLevel: 3,
			progressive: true,
			interlaced: true
		})
	))
	.pipe(gulp.dest('public/img'))
});

gulp.task('fonts:clean', function() {
	return gulp.src('public/fonts', {
		read: false
	})
	.pipe(clean())
});

gulp.task('fonts:main', function() {
	return gulp.src([
		'assets/bower/bootstrap/dist/fonts/*'
	])
	.pipe(gulp.dest('public/fonts'))
	.on('error', util.log)
});


gulp.task('css:clean', function() {
	return gulp.src('public/css', {
		read: false
	})
	.pipe(clean())
});

gulp.task('css:main', function(file) {
	var dest = 'public/css';

	return gulp.src([
		'assets/bower/bootstrap/dist/css/bootstrap.css',
		'assets/css/*.css'
	])
	.pipe(concat('main.css'))
	.pipe(gulp.dest(dest))
	.pipe(rename({
		suffix: '.min'
	}))
	.pipe(mincss())
	.pipe(gulp.dest(dest))
	.pipe(rev())
	.pipe(gulp.dest(dest))
	.pipe(rev.manifest())
	.pipe(gulp.dest(dest))
	.on('error', util.log)
});

gulp.task('css:addons', function() {
	var dest = 'public/css/addons';

	return gulp.src([
		'assets/bower/typeahead.js-bootstrap3.less/typeahead.css',
	])
	.pipe(gulp.dest(dest))
	.pipe(rename({
		suffix: '.min'
	}))
	.pipe(mincss())
	.pipe(gulp.dest(dest))
	.pipe(rev())
	.pipe(gulp.dest(dest))
	.pipe(rev.manifest())
	.pipe(gulp.dest(dest))
	.pipe(rename('rev-manifest-css.blade.php'))
	.pipe(gulp.dest('app/views'))
	.on('error', util.log)
});

gulp.task('js:clean', function() {
	return gulp.src('public/js', {
		read: false
	})
	.pipe(clean())
});

gulp.task('js:main', function() {
	var dest = 'public/js';

	return gulp.src([
		'assets/bower/modernizr/modernizr.js',
		'assets/bower/jquery/dist/jquery.js',
		'assets/bower/bootstrap/dist/js/bootstrap.js',
		'assets/js/*.js'
	])
	.pipe(jshint('.jshintrc'))
	//.pipe(jshint.reporter('default'))
	.pipe(concat('main.js'))
	.pipe(gulp.dest(dest))
	.pipe(rename({
		suffix: '.min'
	}))
	.pipe(uglify())
	.pipe(gulp.dest(dest))
	.pipe(rev())
	.pipe(gulp.dest(dest))
	.pipe(rev.manifest())
	.pipe(gulp.dest(dest))
	.on('error', util.log)
});

gulp.task('js:addons', function() {
	var dest = 'public/js/addons';

	return gulp.src([
		'assets/bower/typeahead.js/dist/typeahead.bundle.js',
		'assets/bower/fastclick/lib/fastclick.js',
	])
	.pipe(jshint('.jshintrc'))
	//.pipe(jshint.reporter('default'))
	.pipe(gulp.dest(dest))
	.pipe(rename({
		suffix: '.min'
	}))
	.pipe(uglify())
	.pipe(gulp.dest(dest))
	.pipe(rev())
	.pipe(gulp.dest(dest))
	.pipe(rev.manifest())
	.pipe(gulp.dest(dest))
	.pipe(rename('rev-manifest-js.blade.php'))
	.pipe(gulp.dest('app/views'))
	.on('error', util.log)
});

var compress = function(dirs) {
	return function() {
		return gulp.src(dirs)
		.pipe(gzip({
 			gzipOptions: {
				level: 9
			}
		}))
		.pipe(gulp.dest('public'))
	};
};

gulp.task('clean', [ 'img:clean', 'fonts:clean', 'css:clean', 'js:clean' ]);
gulp.task('img', [ 'img:main' ]);
gulp.task('fonts', [ 'fonts:main' ],
	compress('public/**/*.{eot,svg,ttf,woff}')
);
gulp.task('css', [ 'css:clean', 'css:main', 'css:addons' ],
	compress('public/**/*.css')
);
gulp.task('js', [ 'js:clean', 'js:main', 'js:addons' ],
	compress('public/**/*.js')
);

gulp.task('default', [ 'img', 'fonts', 'css', 'js' ] );
