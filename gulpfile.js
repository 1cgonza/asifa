'use strict';

const gulp         = require('gulp');
const concat       = require('gulp-concat');
const uglify       = require('gulp-uglify');
const sourcemaps   = require('gulp-sourcemaps');
const scss         = require('gulp-sass');
const rename       = require('gulp-rename');
const autoprefixer = require('gulp-autoprefixer');
const browserSync  = require('browser-sync').create();

var paths = {
  scripts: ['./dev/js/**/*.js'],
  styles: ['./dev/scss/**/*.scss'],
  templates: ['./**/*.php']
};

gulp.task('scripts', function() {
  return gulp.src(paths.scripts)
    .pipe(sourcemaps.init())
      .pipe(uglify())
      .pipe(concat('scripts.min.js'))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./js'));
});

gulp.task('styles', function() {
  return gulp.src(paths.styles)
    .pipe(sourcemaps.init())
      .pipe(scss({outputStyle: 'compressed'}).on('error', scss.logError))
      .pipe(autoprefixer({
        browsers: ['last 2 versions'],
        cascade: false
      }))
      .pipe(rename('style.min.css'))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./css'));
});

gulp.task('sync', function() {
  browserSync.init({
    proxy: 'asifacolombia.dev',
    notify: false
  });
});

gulp.task('watch', ['sync'], function() {
  gulp.watch(paths.scripts, ['scripts', browserSync.reload]);
  gulp.watch(paths.styles, ['styles', browserSync.reload]);
  gulp.watch(paths.templates, [browserSync.reload]);
});

gulp.task('default', ['scripts', 'styles', 'watch']);
