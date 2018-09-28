$(function() {
	let $body = $('body')
	let tableUrl = $('#table_translation_managers').data('url')

	let tableTranslateManager = $('#table_translation_managers').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: tableUrl,
			data: function(q) {
				q.filters = JSON.stringify($('#translation_managers_search_form').serializeArray())
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
			// {
			// 	'targets': [0],
			// 	'searchable': false,
			// 	'orderable': false,
			// 	'visible': true,
			// 	'width': '5%',
			// 	'className': 'dt-center',
			// },
		],
	})

	$body.on('submit', '#translation_managers_search_form', function() {
		tableTranslateManager.reload()
		return false
	})
	$body.on('click', '#btn_reset_filter', function() {
		$('#translation_managers_search_form').resetForm()
		tableTranslateManager.reload()
	})
	$body.on('click', '.btn-edit-translation', function() {
		let key = $(this).parent().prev().prev().text()
		let translatedText = $(this).parent().prev().text()
		let url = $(this).data('url')

		$('#modal_lg').showModal({url: url, params: {key: key, translatedText: translatedText}})
	})
	$body.on('submit', '#form_edit_translation', function(e) {
		mApp.block($(this)[0])
		let formData = new FormData($(this)[0])
		let url = $(this).prop('action')

		$('#form_edit_translation').submitForm({url: url, formData: formData}).then(function() {
			mApp.unblock()
			$('#modal_lg').modal('hide')
			tableTranslateManager.reload()
		})
		e.preventDefault()
	})
})