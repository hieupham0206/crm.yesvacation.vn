$(function() {
	const $app = $('#app')
	const tableLog = $('#table_logs').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('activity_logs.table'),
			data: function(q) {
				q.filters = JSON.stringify($('#logs_search_form').serializeArray())
			},
		}),
		conditionalPaging: true,
		info: true,
		lengthChange: true,
	})

	$app.on('click', '.btn-view-detail', function() {
		let url = $(this).data('url')
		let logId = $(this).data('id')
		$('#modal_lg').showModal({url: url, params: {logId: logId}})
	})
	$('#logs_search_form').on('submit', function() {
		tableLog.reload()
		return false
	})
	$('#btn_reset_filter').on('click', function() {
		$('#logs_search_form').resetForm()
		tableLog.reload()
	})
})