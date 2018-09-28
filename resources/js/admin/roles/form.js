$(function () {
	$('#role_form').validate({
		//display error alert on form submit
		invalidHandler: function (event, validator) {
			let msg = validator.errorList.length + lang[' field(s) are invalid']
			flash(msg, 'danger', false)
			mUtil.scrollTop()
		}
	})

	$('.chk_all_permission').on('click', function () {
		if ($(this).is(':checked')) {
			$(this).parents('tr').find('.chk_permission').prop('checked', true)
		} else {
			$(this).parents('tr').find('.chk_permission').prop('checked', false)
		}
	})
	$('.chk_permission').on('click', function () {
		let tr = $(this).parents('tr')
		if (tr.find('.chk_permission:checked').length >= tr.find('.chk_permission').length) {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', true)
		} else {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', false)
		}
	})

	//Check trang edit
	$('.chk_all_permission').each(function () {
		let tr = $(this).parents('tr')
		if (tr.find('.chk_permission:checked').length >= tr.find('.chk_permission').length) {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', true)
		} else {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', false)
		}
	})
})