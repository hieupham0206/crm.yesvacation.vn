/* eslint-disable linebreak-style,no-console */
try {
	//CORE JS
	window.Popper = require('popper.js').default
	window.$ = window.jQuery = require('jquery')
	require('bootstrap')
	//END CORE

	//todo: chuyển bootbox qua theme vendor khi release v5
	window.bootbox = require('../../plugins/bootbox/bootbox')
} catch (e) {
	console.log(e)
}

window._ = require('lodash')
window.axios = require('axios')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
	console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}
require('./dev-console')