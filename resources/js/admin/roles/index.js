$(function() {
	const $app = $('#app')
	const tableRole = $('#table_roles').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('roles.table'),
			data: function(q) {
				q.filters = JSON.stringify($('#roles_search_form').serializeArray())
			},
		}),
		conditionalPaging: true,
		info: true,
		lengthChange: true,
		'columnDefs': [
			{
				'targets': [0],
				'visible': true,
			},
			{
				'targets': [-1],
				'searchable': false,
				'orderable': false,
				'visible': true,
				'width': '10%',
			},
		],
	})

	$('#roles_search_form').on('submit', function() {
		tableRole.reload()
		return false
	})
	$('#btn_reset_filter').on('click', function() {
		$('#roles_search_form').resetForm()
		tableRole.reload()
	})
	$('#link_delete_selected_rows').on('click', function() {
		let ids = $('.m-checkbox--single > input[type=\'checkbox\']:checked').getValues()

		if (ids.length > 0) {
			tableRole.actionDelete({btnDelete: $(this), params: {ids: ids}})
		}
	})
	$app.on('click', '.btn-delete', function() {
		tableRole.actionDelete({btnDelete: $(this)})
	})
	$app.on('click', '.btn-change-status', function() {
		tableRole.actionEdit({btnEdit: $(this), params: {state: $(this).data('state')}})
	})
})