$(function() {
	let $btnAddUser = $('#btn_add_user'),
		$selectUser = $('#select_user'),
		$selectLeader = $('#select_leader'),
		$selectManager = $('#select_mananger')

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

	if ($selectLeader.length > 0) {
		$selectLeader.select2Ajax({
			url: route('users.list'),
			data: function(q) {
				q.roleId = 5
			},
			column: 'username'
		})
	}

	if ($selectManager.length > 0) {
		$selectManager.select2Ajax({
			url: route('users.list'),
			data: function(q) {
				q.roleId = 4
			},
			column: 'username',
			allowClear: true
		})
	}

	$selectUser.select2Ajax({
		url: route('users.list'),
		data: function(q) {
			q.excludeIds = [1, ...$('.txt-user-id').getValues({parse: 'int'})]
			q.roleId = 6
		},
		column: 'username',
		allowClear: true
	})

	$btnAddUser.on('click', function() {
		if ($selectUser.val() === '') {
			flash('Vui lòng chọn user', 'danger')
			return
		}

		let username = $selectUser.select2('data')[0]['username']
		let userId = $selectUser.val()
		let idx = tableUserDepartment.data().count()

		tableUserDepartment.row.add([
			username +
			`<input type="hidden" name="UserDepartment[user_id][${idx}][]" value="${userId}" class="txt-user-id">`,
			`Tele Marketer <input type="hidden" name="UserDepartment[position][${idx}][]" value="1" class="txt-position">`,
			`<button type="button" class="btn-delete-user btn btn-sm btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--outline-2x m-btn--pill" title="Delete"><i class="la la-trash"></i></button>`,
		]).draw(false)

		$selectUser.val('').trigger('change')
	})

	$('body').on('click', '.btn-delete-user', function() {
		tableUserDepartment.row($(this).parents('tr')).remove().draw(false)
	})
})