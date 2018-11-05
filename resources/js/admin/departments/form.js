$(function() {
	let $btnAddUser = $('#btn_add_user'),
		$selectUser = $('#select_user'),
		$selectPosition = $('#select_position')

	$('#departments_form').validate({
		submitHandler: $(this).data('confirm') ? function(form, e) {
			window.blockPage()
			e.preventDefault()

			let isConfirm = $(form).data('confirm')
			$(form).confirmation(result => {
				if (result && (typeof result === 'object' && result.value)) {
					$(form).submitForm({
						data: {
							'isConfirm': isConfirm,
						},
					}).then(() => {
						location.href = route('departments.index')
					})
				} else {
					window.unblock()
				}
			})
		} : false,
	})

	let tableUserDepartment = $('#table_user_department').DataTable({
		paging: false,
		'columnDefs': [
			{'targets': [-1], 'orderable': false, 'width': '5%'},
		],
	})

	$selectUser.select2Ajax({
		url: route('users.list'),
		data: function(q) {
			q.excludeIds = [1, ...$('.txt-user-id').getValues({parse: 'int'})]
			q.roleId = $('#select_position').val()
		},
		column: 'username'
	})

	$selectPosition.on('change', function() {
		$selectUser.val('').trigger('change').prop('disabled', $(this).val() === '')
	})

	$btnAddUser.on('click', function() {
		//todo: validation
		if ($selectUser.val() === '') {
			flash('Vui lòng chọn user', 'danger')
			return
		}
		if ($selectPosition.val() === '') {
			flash('Vui lòng chọn vị trí', 'danger')
			return
		}

		let currentPositions = $('.txt-position').getValues({parse: 'int'})
		let positionValue = $selectPosition.val()
		let positionText = $selectPosition.select2('data')[0]['text']

		if (positionValue === '2' && currentPositions.includes(+positionValue)) {
			flash('Vui lòng chọn lại vị trí khác', 'danger')
			return
		}

		let username = $selectUser.select2('data')[0]['username']
		let userId = $selectUser.val()

		tableUserDepartment.row.add([
			username +
			`<input type="hidden" name="UserDepartment[id][{{ $key }}][]" value="">
			<input type="hidden" name="UserDepartment[user_id][{{ $key }}][]" value="${userId}" class="txt-user-id">`,
			positionText + `<input type="hidden" name="UserDepartment[position][{{ $key }}][]" value="${positionValue}" class="txt-position">`,
			`<button type="button" class="btn-delete-user btn btn-sm btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" title="Delete"><i class="la la-trash"></i></button>`,
		]).draw(false)

		$selectUser.val('').trigger('change')
	})

	$('body').on('click', '.btn-delete-user', function() {
		tableUserDepartment.row($(this).parents('tr')).remove().draw(false)
	})
})