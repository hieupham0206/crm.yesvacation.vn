/* eslint-disable no-undef */
require('./utils/utils')
require('./components/quicksearch')
require('./components/activity_log')
window.cloudTeamCore = require('./core')

//VUE
window.Vue = require('vue')

Vue.component('flash', require('../components/Flash.vue'))

window.events = new Vue()

new Vue({
	el: '#app',
})
//END VUE

$(function() {
	cloudTeamCore.init()

	if (mUtil.isMobileDevice()) {
		$('select').on('select2:open', function() {
			$('.select2-search input').prop('focus', 0)
		})
	}

	$('.m-portlet > .portlet-toggle-link').on('click', function() {
		$(this).next().slideToggle()
	})

	$('.modal').on('show.bs.modal', function() {
		$(this).addClass('modal-brand').show().setModalMaxHeight()

		$('select').on('select2:open', function() {
			$('.select2-search input').prop('focus', 0)
		})
	})

	$('body').on('keyup', '.numeric', function() {
		$(this).val(numeral($(this).val()).format('0,00'))
	})

	$('#link_form_change_password').on('click', function() {
		let url = $(this).data('url')

		$('#modal_md').showModal({url: url, method: 'get'})
	})

	$('#modal_md').on('submit', '#form_change_password', function(e) {
		e.preventDefault()

		let url = $(this).attr('action')
		let formData = new FormData($(this)[0])
		mApp.block(this)
		axios({
			method: 'post',
			url: url,
			data: formData,
			config: {headers: {'Content-Type': 'multipart/form-data'}},
		}).then((result) => {
			let obj = result['data']
			flash(obj.message)

			$('#modal_md').modal('hide')
		}).catch(result => {
			let response = result.response
			let errors = response.data.errors
			let message = response.data.message

			if (errors !== undefined) {
				let html = ''
				Object.entries(errors).forEach(
					([key, values]) => {
						for (let value of values) {
							html += `<li>${value}</li>`
						}
					},
				)
				$('#form_change_password .alert').show().find('strong').html(html)
			} else {
				$('#form_change_password .alert').show().find('strong').html(message)
			}

		}).finally(() => {
			mApp.unblock(this)
		})
	})

	// add valid and remove error classes on select2 element if valid
	$('.select2-hidden-accessible').on('change', function() {
		$(this).valid()
	})

	$('body').on('click', '.m-alert .close', function() {
		window.events.$emit('hide')
	})
})