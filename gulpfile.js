// Config
const projectConfig = {
	foldersName: 'goiteens',
};

const jsLibs = [
	// 'wp-content/themes/' + projectConfig.foldersName + '/assets/js/jquery.js',
];

const jsWatch = [
	'wp-content/themes/' + projectConfig.foldersName + '/assets/js/front.js',
	'wp-content/themes/' + projectConfig.foldersName + '/assets/js/admin/*.js',
	'wp-content/themes/' + projectConfig.foldersName + '/assets/js/blocks/*.js',
	'wp-content/themes/' + projectConfig.foldersName + '/assets/js/templates/*.js',
	/** exclude already minified files */
	'!wp-content/themes/' + projectConfig.foldersName + '/assets/js/admin/*.min.js',
];

const jsFilesFront = [
	'wp-content/themes/' + projectConfig.foldersName + '/assets/js/front.js',
	'wp-content/themes/' + projectConfig.foldersName + '/assets/js/blocks/*.js',
	'wp-content/themes/' + projectConfig.foldersName + '/assets/js/templates/*.js',
];

const jsFilesAdmin = [
	'wp-content/themes/' + projectConfig.foldersName + '/assets/js/admin/*.js',
	/** exclude already minified files */
	'!wp-content/themes/' + projectConfig.foldersName + '/assets/js/admin/*.min.js',
];

const scssWatch = [
	'wp-content/themes/' + projectConfig.foldersName + '/assets/scss/*.scss',
	'wp-content/themes/' + projectConfig.foldersName + '/assets/scss/layout/*.scss',
	'wp-content/themes/' + projectConfig.foldersName + '/assets/scss/templates/*.scss',
	'wp-content/themes/' + projectConfig.foldersName + '/assets/scss/blocks/*.scss',
];

const scssFilesFront = [
	'wp-content/themes/' + projectConfig.foldersName + '/assets/scss/app.scss',
	'wp-content/themes/' + projectConfig.foldersName + '/assets/scss/layout/*.scss',
];

const scssTemplatesFiles = [
	'wp-content/themes/' + projectConfig.foldersName + '/assets/scss/templates/*.scss',
];

const scssBlocksFiles = [
	'wp-content/themes/' + projectConfig.foldersName + '/assets/scss/blocks/*.scss',
];

const scssSeparateFiles = [
	'wp-content/themes/' + projectConfig.foldersName + '/assets/scss/admin.scss',
	'wp-content/themes/' + projectConfig.foldersName + '/assets/scss/admin-editor-style.scss',
	'wp-content/themes/' + projectConfig.foldersName + '/assets/scss/critical-css.scss',
];


// Importing specific gulp API functions lets us write them below as series() instead of gulp.series()
const gulp = require('gulp');
const {
	src,
	dest,
	watch,
	series,
	parallel
} = gulp;

// Importing all the Gulp-related packages we want to use
const sourcemaps = require('gulp-sourcemaps'),
	sass = require('gulp-sass'),
	postcss = require('gulp-postcss'),
	cssnano = require('cssnano'),
	babel = require('gulp-babel'),
	rename = require('gulp-rename'),
	minifyjs = require('gulp-uglify-es').default,
	autoPrefixer = require('gulp-autoprefixer'),
	plumber = require('gulp-plumber'),
	concat = require('gulp-concat'),
	merge = require('merge2');


// Sass task: compiles the style.scss file into style.css
function scssTask() {

	const frontFiles = src(scssFilesFront, {
			base: './'
		})
		.pipe(autoPrefixer({
			cascade: false
		}))
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed'
		}))
		.pipe(concat('app.min.css'))
		.pipe(sourcemaps.write('.'))
		.pipe(dest('wp-content/themes/' + projectConfig.foldersName + '/assets/css/'));

	const separateFiles = src(scssSeparateFiles, {
			base: './wp-content/themes/' + projectConfig.foldersName + '/assets/scss/'
		})
		.pipe(autoPrefixer({
			cascade: false
		}))
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed'
		}))
		.pipe(sourcemaps.write('.'))
		.pipe(dest('wp-content/themes/' + projectConfig.foldersName + '/assets/css/'));

	const scssBlocks = src(scssBlocksFiles, {
			base: './wp-content/themes/' + projectConfig.foldersName + '/assets/scss/blocks/'
		})
		.pipe(autoPrefixer({
			cascade: false
		}))
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed'
		}))
		.pipe( sourcemaps.write( '.'))
		.pipe(dest('wp-content/themes/' + projectConfig.foldersName + '/assets/css/blocks/'));

	const scssTemplates = src(scssTemplatesFiles, {
			base: './wp-content/themes/' + projectConfig.foldersName + '/assets/scss/templates/'
		})
		.pipe(autoPrefixer({
			cascade: false
		}))
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed'
		}))
		.pipe( sourcemaps.write( '.'))
		.pipe(dest('wp-content/themes/' + projectConfig.foldersName + '/assets/css/templates/'));


	return merge(frontFiles, separateFiles, scssBlocks, scssTemplates);

}

// JS Task: minify scripts
function jsTask() {

	const libsFiles = src(jsLibs)
		.pipe(concat('libs.min.js'))
		.pipe(dest('wp-content/themes/' + projectConfig.foldersName + '/assets/js/'));

	const frontFiles = src(jsFilesFront, {
			base: './'
		})
		.pipe(babel({
			presets: [
				['@babel/env', {
					modules: 'commonjs'
				}]
			]
		}))
		.pipe(minifyjs())
		.pipe(concat('app.min.js'))
		.pipe(dest('wp-content/themes/' + projectConfig.foldersName + '/assets/js/'));

	const separateFiles = src(jsFilesAdmin, {
			base: './'
		})
		.pipe(babel({
			presets: [
				['@babel/env', {
					modules: 'commonjs'
				}]
			]
		}))
		.pipe(minifyjs())
		.pipe(rename({
			extname: '.min.js'
		}))
		.pipe(dest((file) => {
			return file.base;
		}));

	return merge(libsFiles, frontFiles, separateFiles);

}

// Watch task: watch SCSS and JS files for changes
// If any change, run scss and js tasks simultaneously
function watchTask() {
	watch([...scssWatch], series(parallel(scssTask)));
	// watch([...scssWatch, ...jsWatch], series(parallel(scssTask, jsTask)));
}

// Export the default Gulp task so it can be run
// Runs the scss and js tasks simultaneously
// then runs cacheBust, then watch task
exports.default = series(
	parallel(scssTask),
	// parallel(scssTask, jsTask),
	watchTask
);