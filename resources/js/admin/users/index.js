$(function() {
	const $modalLg = $('#modal_lg')
	const $app = $('#app')
	const tableUser = $('#table_users').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('users.table'),
			data: function(q) {
				q.filters = JSON.stringify($('#users_search_form').serializeArray())
			},
		}),
		conditionalPaging: true,
		info: true,
		lengthChange: true,
	})
	$app.on('click', '.btn-change-status', function() {
		let message = $(this).data('message')
		tableUser.actionEdit({
			btnEdit: $(this),
			params: {
				state: $(this).data('state'),
			},
			message: message,
		})
	})
	$app.on('submit', '#users_form', function() {
		// noinspection JSCheckFunctionSignatures
		mApp.block('.modal')
		let ids = $('.m-checkbox--single > input[type=\'checkbox\']:checked').getValues().join(',')
		if (ids.length > 0) {
			let url = $(this).prop('action')
			let formData = new FormData($(this)[0])

			formData.append('ids', ids)

			$(this).submitForm({url: url, formData: formData, method: 'post'}).then(() => {
				mApp.unblock('.modal')
				tableUser.reload()
				$('#modal_lg').modal('hide')
			})
		}

		return false
	})
	$app.on('click', '.btn-delete', function() {
		tableUser.actionDelete({
			btnDelete: $(this),
		})
	})
	$modalLg.on('shown.bs.modal', function() {
		$('.select').select2()
	})
	$('#users_search_form').on('submit', function() {
		tableUser.reload()
		return false
	})
	$('#btn_reset_filter').on('click', function() {
		$('#users_search_form').resetForm()
		tableUser.reload()
	})

	//Export tools
	$('#btn_export_excel').on('click', function() {
		tableUser.exportExcel()
	})
	$('#btn_export_pdf').on('click', function() {
		tableUser.exportPdf()
	})
	//Quick actions
	$('#link_delete_selected_rows').on('click', function() {
		let ids = $('.m-checkbox--single > input[type=\'checkbox\']:checked').getValues()
		if (ids.length > 0) {
			tableUser.actionDelete({
				btnDelete: $(this),
				params: {
					ids: ids,
				},
			})
		}
	})
	$('#link_edit_selected_rows').on('click', function() {
		let ids = $('.m-checkbox--single > input[type=\'checkbox\']:checked').getValues()
		if (ids.length > 0) {
			let editUrl = $(this).data('url')

			$modalLg.showModal({url: editUrl})
		}
	})
})