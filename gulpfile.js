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

gulp.task('js-graph', function () {
    return gulp.src(config.build.src.js.graph)
        .pipe(uglify())
        .pipe(wrapper({header: '\n// ${filename}\n\n'}))
        .pipe(concat('graph.js'))
        .pipe(gulp.dest(config.build.dest.js));
});

gulp.task('js-list-delete-popover', function () {
    return gulp.src(config.build.src.js.list_delete_popover)
        .pipe(uglify())
        .pipe(wrapper({header: '\n// ${filename}\n\n'}))
        .pipe(concat('list-delete-popover.js'))
        .pipe(gulp.dest(config.build.dest.js));
});

gulp.task('js-clients-client-form', function () {
    return gulp.src(config.build.src.js.clients_client_form)
        .pipe(uglify())
        .pipe(wrapper({header: '\n// ${filename}\n\n'}))
        .pipe(concat('clients-client-form.js'))
        .pipe(gulp.dest(config.build.dest.js));
});

gulp.task('js-finance-transaction-form', function () {
    return gulp.src(config.build.src.js.finance_transaction_form)
        .pipe(uglify())
        .pipe(wrapper({header: '\n// ${filename}\n\n'}))
        .pipe(concat('finance-transaction-form.js'))
        .pipe(gulp.dest(config.build.dest.js));
});

gulp.task('js-warehouse-good-form', function () {
    return gulp.src(config.build.src.js.warehouse_good_form)
        .pipe(uglify())
        .pipe(wrapper({header: '\n// ${filename}\n\n'}))
        .pipe(concat('warehouse-good-form.js'))
        .pipe(gulp.dest(config.build.dest.js));
});

gulp.task('js', ['js-app', 'js-graph', 'js-list-delete-popover', 'js-clients-client-form', 'js-finance-transaction-form', 'js-warehouse-good-form']);

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

gulp.task('build', ['images', 'fonts'], function () {
    gulp.start(['css', 'js']);
});

gulp.task('default', ['build']);