var gulp         = require('gulp'),
    gulpSass     = require('gulp-sass'),
    watch        = require('gulp-watch'),
    uglifycss    = require('gulp-uglifycss'),
    autoprefixer = require('gulp-autoprefixer');
    // minify       = require('gulp-minify'),
    // concat       = require('gulp-concat'),
    // bro          = require('gulp-bro');

function sass(done) {
    gulp.src('./sass/**/*.scss')
      .pipe(watch('sass/*.scss'))
      .pipe(gulpSass().on('error', gulpSass.logError))
      .pipe(gulp.dest('./css'));
    done();
};

function css(done) {
    gulp.src('./css/**/*.css')
        .pipe(autoprefixer({
          cascade: false
        }))
        .pipe(uglifycss({
          "uglyComments": true
        }))
        .pipe(gulp.dest('./dist/'));

    done();
};

// function js (done) {
//   gulp.src('js/*.js')
//       .pipe(bro())
//       .pipe(minify({
//           ext:{
//               min:'.min.js',
//           },
//           noSource: true,
//       }))
//       .pipe(gulp.dest('./dist'));
//   done();
// }

function watchFiles() {
    gulp.watch('sass/**/*.scss', sass);
    gulp.watch('css/**/*.css', css);
    // gulp.watch('js/**/*.js', js);
}

gulp.task("sass", sass);

gulp.task("css", css);

// gulp.task("js", js);

gulp.task("default", gulp.parallel(sass,css,watchFiles));

gulp.task('run', gulp.parallel(sass,css));

gulp.task('watch', gulp.series(watchFiles));