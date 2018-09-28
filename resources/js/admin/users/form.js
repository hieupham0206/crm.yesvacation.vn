$(function() {
	let $usersForm = $('#users_form')
	let isConfirm = $usersForm.data('confirm')

	$usersForm.validate({
		// define validation rules
		rules: {
			password: {
				required: function(element) {
					let val = $(element).data('value')
					return val === ''
				},
				pwCheck: function(element) {
					let val = $(element).data('value')
					return val === ''
				}
			},
			password_confirmation: {
				required: function() {
					return $('#txt_password').val() !== ''
				},
				equalTo: '#txt_password',
			},
		},
		submitHandler: isConfirm && function(form, e) {
			window.blockPage()
			e.preventDefault()
			$(form).confirmation(result => {
				if (result && (typeof result === 'object' && result.value)) {
					$(form).submitForm({
						data: {
							'isConfirm': isConfirm,
						},
					}).then(() => {
						location.href = route('users.index')
					})
				} else {
					window.unblock()
				}
			})
		},
	})

	$('.chk_all_permission').on('click', function() {
		if ($(this).is(':checked')) {
			$(this).parents('tr').find('.chk_permission').prop('checked', true)
		} else {
			$(this).parents('tr').find('.chk_permission').prop('checked', false)
		}
	})
	$('.chk_permission').on('click', function() {
		const tr = $(this).parents('tr')
		if (tr.find('.chk_permission:checked').length >= tr.find('.chk_permission').length) {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', true)
		} else {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', false)
		}
	})

	//Check trang edit
	$('.chk_all_permission').each(function() {
		const tr = $(this).parents('tr')
		if (tr.find('.chk_permission:checked').length >= tr.find('.chk_permission').length) {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', true)
		} else {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', false)
		}
	})
})