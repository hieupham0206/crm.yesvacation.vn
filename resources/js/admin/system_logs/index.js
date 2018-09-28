$(function() {
	let $body = $('body')

	let tableLogs = $('#table_system_logs').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('system_logs.table'),
			data: function(q) {
				q.filters = JSON.stringify($('#system_logs_search_form').serializeArray())
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
		],
	})

	$body.on('submit', '#system_logs_search_form', function() {
		tableLogs.reload()
		return false
	})
	$body.on('click', '#btn_reset_filter', function() {
		$('#system_logs_search_form').resetForm()
		tableLogs.reload()
	})
	$body.on('click', '.btn-view', function() {
		let url = $(this).data('url')
		let text = $(this).parent().find('.txt-content').val()
		let stack = $(this).parent().find('.txt-stack').val()

		$('#modal_lg').showModal({
			url: url, params: {
				content: text,
				stack: stack,
			},
		})
	})
})