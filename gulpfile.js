const gulp = require('gulp'),
	sass = require('gulp-sass'),
	scsslint = require('gulp-scss-lint'),
	livereload = require('gulp-livereload');

function compileSass() {
	return gulp
		.src('scss/styles.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest('./css'))
		.pipe(livereload());
}

function sassLint() {
	return gulp.src('scss/styles.scss').pipe(scsslint());
}

function watchSass() {
	livereload.listen();
	gulp.watch(['scss/styles.scss'], gulp.series(compileSass, sassLint));
	gulp.watch(['index.html']).on('change', function() {
		livereload.reload();
	});
}

gulp.task('sass', gulp.series(compileSass));
gulp.task('scss:lint', gulp.series(sassLint));
gulp.task('default', gulp.series(watchSass));
