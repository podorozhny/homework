var config   = require('./config.json'),
    del      = require('del'),
    gulp     = require('gulp'),
    newer    = require('gulp-newer'),
    concat   = require('gulp-concat'),
    less     = require('gulp-less'),
    csso     = require('gulp-csso'),
    imagemin = require('gulp-imagemin'),
    uglify   = require('gulp-uglify'),
    order    = require('gulp-order'),
    csscomb  = require('gulp-csscomb'),
    rename   = require('gulp-rename'),
    gutil    = require('gulp-util'),
    wrapper  = require('gulp-wrapper');

handleError = function (err) {
    gutil.log(err);
    gutil.beep();
};

gulp.task('clean', function () {
    del([
        'web/css/*.css',
        'web/js/*.js',
        'web/img/*.png',
        'web/img/*.gif',
        'web/img/*.jpg',
        'web/img/*.jpeg',
        'web/fonts/*.otf',
        'web/fonts/*.ttf',
        'web/fonts/*.eot',
        'web/fonts/*.svg',
        'web/fonts/*.woff',
        'web/fonts/*.woff2'
    ], function () {
        console.log('Files deleted');
    });
});

gulp.task('css-app', function () {
    return gulp.src(config.build.src.css.app)
        .pipe(less())
        .on('error', handleError)
        .pipe(csso())
        .pipe(wrapper({header: '\n/* ${filename} */\n\n'}))
        .pipe(concat('app.css'))
        .pipe(gulp.dest(config.build.dest.css));
});

gulp.task('css-auth', function () {
    return gulp.src(config.build.src.css.auth)
        .pipe(less())
        .on('error', handleError)
        .pipe(csso())
        .pipe(wrapper({header: '\n/* ${filename} */\n\n'}))
        .pipe(concat('auth.css'))
        .pipe(gulp.dest(config.build.dest.css));
});

gulp.task('css', ['css-app', 'css-auth']);

gulp.task('js-app', function () {
    return gulp.src(config.build.src.js.app)
        .pipe(uglify())
        .pipe(wrapper({header: '\n// ${filename}\n\n'}))
        .pipe(concat('app.js'))
        .pipe(gulp.dest(config.build.dest.js));
});

gulp.task('js-clients-client-list', function () {
    return gulp.src(config.build.src.js.clients_client_list)
        .pipe(uglify())
        .pipe(wrapper({header: '\n// ${filename}\n\n'}))
        .pipe(concat('clients_client_list.js'))
        .pipe(gulp.dest(config.build.dest.js));
});

gulp.task('js-clients-client-form', function () {
    return gulp.src(config.build.src.js.clients_client_form)
        .pipe(uglify())
        .pipe(wrapper({header: '\n// ${filename}\n\n'}))
        .pipe(concat('clients_client_form.js'))
        .pipe(gulp.dest(config.build.dest.js));
});

gulp.task('js', ['js-app', 'js-clients-client-list', 'js-clients-client-form']);

gulp.task('images', function () {
    return gulp.src(config.build.src.img)
        .pipe(newer(config.build.dest.img))
        .pipe(gulp.dest(config.build.dest.img));
});

gulp.task('fonts', function () {
    return gulp.src(config.build.src.fonts)
        .pipe(newer(config.build.dest.fonts))
        .pipe(gulp.dest(config.build.dest.fonts));
});

gulp.task('build', ['clean', 'images', 'fonts'], function () {
    gulp.start(['css', 'js']);
});

gulp.task('default', ['build']);