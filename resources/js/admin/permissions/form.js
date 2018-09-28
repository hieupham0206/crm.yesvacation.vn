$(function () {
	$('#permission_form').validate({
		//display error alert on form submit
		invalidHandler: function (event, validator) {
			let msg = validator.errorList.length + lang[' field(s) are invalid']
			flash(msg, 'danger', false)
			mUtil.scrollTop()
		}
	})

	let tablePermission = $('#table_permissions').DataTable()

	$('body').on('click', '.btn-delete-permission', function () {
		tablePermission.row($(this).parents('tr')).remove().draw(false)
	})

	$('#btn_add_permission').on('click', function () {
		let permission = $('#txt_permission').val()
		if (permission) {
			tablePermission.row.add([
				permission + `<input type="hidden" name="permissions[]" value="${permission}">`,
				`<button type="button" class="btn btn-sm btn-danger btn-delete-permission m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" title="${lang['Delete']}"><i class="la la-trash"></i>`
			]).draw(false)

			$('#txt_permission').val('')
		}
	})
})