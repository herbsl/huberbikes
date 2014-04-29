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
	mincss = require('gulp-minify-css'),
	livereload = require('gulp-livereload');

gulp.task('img:clean', function() {
	return gulp.src('public/img', {
		read: false
	})
	.pipe(clean())
});

gulp.task('img', function() {
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

gulp.task('font:clean', function() {
	return gulp.src('public/fonts', {
		read: false
	})
	.pipe(clean())
});

gulp.task('font', function() {
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

var cssMain = function(fast) {
	return function() {
		var dest = 'public/css';

		var ret = gulp.src([
			'assets/bower/bootstrap/dist/css/bootstrap.css',
			'assets/css/*.css'
		])
		.pipe(concat('main.css'))
		.pipe(gulp.dest(dest));

		if (! fast) {
	 		ret.pipe(rename({
				suffix: '.min'
			}))
			.pipe(mincss())
			.pipe(gulp.dest(dest));
		}
	
		ret.on('error', util.log);

		return ret;
	};
};

gulp.task('css:main', cssMain(false));
gulp.task('css:main:fast', cssMain(true));

gulp.task('css:addons', function() {
	var dest = 'public/css';

	return gulp.src([
		'assets/bower/typeahead.js-bootstrap3.less/typeahead.css',
	])
	.pipe(gulp.dest(dest))
	.pipe(rename({
		suffix: '.min'
	}))
	.pipe(mincss())
	.pipe(gulp.dest(dest))
	.on('error', util.log)
});

gulp.task('js:clean', function() {
	return gulp.src('public/js', {
		read: false
	})
	.pipe(clean())
});

gulp.task('js:main:cache', function() {
	return gulp.src([
		'assets/bower/modernizr/modernizr.js',
		'assets/bower/jquery/dist/jquery.js',
		'assets/bower/bootstrap/dist/js/bootstrap.js'
	])
	.pipe(concat('cache.js'))
	.pipe(gulp.dest('assets/tmp'))
	.on('error', util.log);
});


var jsMain = function(fast) {
	var dest = 'public/js';

	return function() {
		var ret = gulp.src([
			'assets/tmp/cache.js',
			'assets/js/*.js'
		]);

		/*if (! fast) {
			ret.pipe(jshint('.jshintrc'))
			.pipe(jshint.reporter('default'));
		}*/

		ret.pipe(concat('main.js'))
		.pipe(gulp.dest(dest));

		if (! fast) {
			ret.pipe(rename({
				suffix: '.min'
			}))
 			.pipe(uglify())
	 		.pipe(gulp.dest(dest));
		}

		ret.on('error', util.log);
		return ret;
	}
};

gulp.task('js:main', [ 'js:main:cache' ], jsMain(false));
gulp.task('js:main:fast', jsMain(true));

gulp.task('js:addons', function() {
	var dest = 'public/js';

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
	.on('error', util.log)
});

gulp.task('default', [ 'gzip', 'img' ]);
gulp.task('clean', [ 'font:clean', 'css:clean', 'js:clean', 'rev:clean' ]);
gulp.task('css', [ 'css:main', 'css:addons' ]);
gulp.task('js', [ 'js:main', 'js:addons' ]);

var _rev = function(src, reload) {
	return function() {
		var ret = gulp.src(src)
		.pipe(rev())
		.pipe(gulp.dest('public'))
		.pipe(rev.manifest())
		.pipe(gulp.dest('public'))
		.pipe(rename('rev-manifest.blade.php'))
		.pipe(gulp.dest('app/views'));

		if (reload) {
			ret.pipe(livereload());
		}

		return ret;
	};
};

gulp.task('rev:fast', [ 'js:main:fast', 'css:main:fast' ], _rev([
	'public/**/main.js',
	'public/**/main.css'
], true)); 
gulp.task('rev', [ 'js', 'css' ], _rev([
	'public/**/*.js',
	'public/**/*.css'
])); 

gulp.task('rev:clean', function() {
	return gulp.src('public/rev-manifest.json', {
		read: false
	})
	.pipe(clean())
});

gulp.task('gzip', [ 'rev', 'font' ], function() {
	return gulp.src([
		'public/**/*.js',
		'public/**/*.css',
		'public/**/*.{eot,svg,ttf,woff}'
	])
	.pipe(gzip({
 		gzipOptions: {
			level: 9
		}
	}))
	.pipe(gulp.dest('public'));
});

gulp.task('default', [ 'img', 'gzip' ] );

gulp.task('watch', function() {
	gulp.watch('assets/js/*.js', [ 'rev:fast' ]);
	gulp.watch('assets/css/*.css', [ 'rev:fast' ]);
	gulp.watch('app/views/*.blade.php', function() {
		livereload().changed('');
	});
});
