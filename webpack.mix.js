const mix = require('laravel-mix')
const ImageminPlugin = require('imagemin-webpack-plugin').default
const imageminMozjpeg = require('imagemin-mozjpeg')
const CopyWebpackPlugin  = require('copy-webpack-plugin');

require('dotenv').config()
const fs = require('fs')
const theme = process.env.APP_THEME !== undefined ? process.env.APP_THEME : 'default'
const resourcePath = 'resources/'

mix.webpackConfig({
	node: {
		fs: 'empty',
	},
	plugins: [
		//Compress images
		new CopyWebpackPlugin([{
			from: `${resourcePath}/images`, // FROM
			to: 'images/', // TO
		}]),
		new ImageminPlugin({
			test: /\.(jpe?g|png|gif|svg)$/i,
			pngquant: {
				quality: '65-80'
			},
			plugins: [
				imageminMozjpeg({
					quality: 65,
					//Set the maximum memory to use in kbytes
					maxMemory: 1000 * 512
				})
			]
		})
	],
})

mix.combine([
		`${resourcePath}/themes/vendors/vendors.bundle.js`,
		`${resourcePath}/plugins/datatables/datatables.bundle.js`,
		`${resourcePath}/themes/${theme}/base/scripts.bundle.js`,
	],
	`public/${theme}/js/merged.js`)
mix.combine([
		`${resourcePath}/themes/vendors/vendors.bundle.css`,
		`${resourcePath}/plugins/datatables/datatables.bundle.css`,
		`${resourcePath}/themes/${theme}/base/style.bundle.css`,
	],
	`public/${theme}/css/merged.css`)

mix.js(`${resourcePath}/js/app/bootstrap.js`, 'public/js').js(`${resourcePath}/js/app/app.js`, 'public/js').
	js(`${resourcePath}/js/auth/otp.js`, 'public/js/auth').js(`${resourcePath}/js/home.js`, 'public/js').js(`${resourcePath}/js/reception.js`, 'public/js').
	sass(`${resourcePath}/sass/themes/${theme}/app.scss`, `public/${theme}/css`).
	sass(`${resourcePath}/sass/login.scss`, 'public/css')

let routesObj = JSON.parse(fs.readFileSync('./routes/routes.json', 'utf8'))
let getFiles = function(dir) {
	if (fs.existsSync(dir)) {
		return fs.readdirSync(dir).filter(file => {
			return fs.statSync(`${dir}/${file}`).isFile()
		})
	}

	return []
}

for (let namespace of Object.keys(routesObj)) {
	let folderNames = routesObj[namespace]
	for (let folderName of folderNames) {
		getFiles(`resources/js/${namespace}/${folderName}`).forEach(function(filepath) {
			mix.js(`resources/js/${namespace}/${folderName}/` + filepath, `public/js/${namespace}/${folderName}`)
		})
	}
}

mix.browserSync({
	proxy: 'http://127.0.0.1:8002',
	host: '192.168.68.26',
	open: 'external',
	browser: [],
	reloadDelay: 2000,
	injectChanges: false, // Don't try to inject, just do a page refresh
	ghostMode: true,
	notify: false,
})