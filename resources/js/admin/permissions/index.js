$(function() {
	let $body = $('body')
	let tableUrl = $('#table_permissions').data('url')

	let tablePermissions = $('#table_permissions').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: tableUrl,
			data: function(q) {
				q.filters = JSON.stringify($('#permissions_search_form').serializeArray())
			},
		}),
		conditionalPaging: true,
		info: true,
		searching: false,
		lengthChange: true,
		responsive: true,
		'columnDefs': [
			{
				'targets': [-1],
				'searchable': false,
				'orderable': false,
				'visible': true,
				'width': '10%',
			},
			{
				'targets': [2],
				'orderable': false,
				'visible': true,
			},
			{
				'targets': [0],
				'searchable': false,
				'orderable': false,
				'visible': true,
				'width': '5%',
				'className': 'dt-center',
			},
		],
	})

	$body.on('submit', '#permissions_search_form', function() {
		tablePermissions.reload()
		return false
	})
	$body.on('click', '#btn_reset_filter', function() {
		$('#permissions_search_form').resetForm()
		tablePermissions.reload()
	})
	$body.on('click', '.btn-delete', function() {
		tablePermissions.actionDelete({btnDelete: $(this)})
	})
})