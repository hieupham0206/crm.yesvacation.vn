$(function() {
	let userId = $('#txt_user_id').val()
	let leadId = $('#txt_lead_id').val()

	const tableHistoryCall = $('#table_history_calls').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('history_calls.table'),
			data: function(q) {
				q.filters = JSON.stringify([{'name': 'user_id', 'value': userId}])
			},
		}),
		conditionalPaging: true,
		'columnDefs': [],
		// info: true,
		// lengthChange: true,
	})
	const tableCustomerHistory = $('#table_customer_history').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('history_calls.table'),
			data: function(q) {
				q.filters = JSON.stringify([{'name': 'lead_id', 'value': leadId}])
			},
		}),
		conditionalPaging: true,
		'columnDefs': [],
		// info: true,
		// lengthChange: true,
	})
	const tableCallback = $('#table_callback').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('callbacks.table'),
			data: function(q) {
				q.filters = JSON.stringify([{'name': 'user_id', 'value': userId}])
			},
		}),
		conditionalPaging: true,
		'columnDefs': [],
		// info: true,
		// lengthChange: true,
	})
	const tableAppointment = $('#table_appointment').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('appointments.table'),
			data: function(q) {
				q.filters = JSON.stringify([{'name': 'user_id', 'value': userId}])
			},
		}),
		conditionalPaging: true,
		'columnDefs': [],
		// info: true,
		// lengthChange: true,
	})

	$('#leads_form').on('submit', function(e) {
		e.preventDefault()
		// let url = $('#btn_form_change_state').data('url')
		//
		// $('#modal_md').showModal({url: url, params: {}, method: 'get'})
		fetchLead('', 1)
	})

	$('body').on('submit', '#change_state_leads_form', function(e) {
		e.preventDefault()
		mApp.block('#modal_md')

		$(this).submitForm().then(() => {
			$('#modal_md').modal('hide')
			mApp.unblock('#modal_md')
			fetchLead('', 1)
		})
	})

	$('body').on('submit', '#break_form', function(e) {
		e.preventDefault()
		mApp.block('#modal_md')

		$(this).submitForm().then(() => {
			$('#modal_md').modal('hide')
			mApp.unblock('#modal_md')
		})
	})

	$('#modal_md').on('show.bs.modal', function() {
		$('#select_state_modal').select2()
		$('#select_reason_break').select2()
	})

	$('#btn_pause').on('click', function() {
		let url = $(this).data('url')

		$('#modal_md').showModal({url: url, params: {}, method: 'get'})
	})

	$('#btn_resume').on('click', function() {
		let url = $(this).data('url')

		axios.post(url).then(result => {
			let obj = result['data']
			if (obj.message) {
				flash(obj.message)
			}
		}).catch(e => console.log(e)).finally(() => {
			unblock()
		})
	})

	$('body').on('click', '.link-lead-name', function() {
		let leadId = $(this).data('lead-id')
		fetchLead(leadId, 0)
	})

	$('body').on('change', '#select_reason_break', function() {
		if ($(this).val() === '5') {
			$('#another_reason_section').show()
		} else {
			$('#textarea_reason').val('')
			$('#another_reason_section').hide()
		}
	})

	function fetchLead(leadId = '', isNew = 1) {
		return axios.get(route('leads.list'), {
			params: {
				isNew: isNew,
				leadId: leadId,
				getLeadFromUser: true,
			},
		}).then(result => {
			let items = result.data.items
			let lead = items[0]

			$('#txt_name').val(lead.name)
			$('#txt_email').val(lead.email)
			$('#txt_phone').val(lead.phone)
			$('#txt_address').val(lead.address)
			$('#textarea_comment').val(lead.comment)
			$('#select_state').val(lead.state).trigger('change')

			if (lead.title === 'Anh') {
				$('#select_title').val(1).trigger('change')
			} else {
				$('#select_title').val(2).trigger('change')
			}
		})
	}
})