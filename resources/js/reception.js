$(function() {
	let userId = $('#txt_user_id').val()
	let $body = $('body')

	const tableAppointment = $('#table_appointment').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('appointments.table'),
			data: function(q) {
				q.filters = JSON.stringify([{'name': 'user_id', 'value': userId}])
				q.form = 'reception_console'
			},
		}),
		conditionalPaging: true,
		'columnDefs': [],
		sort: false,
	})
	const tableEventData = $('#table_event_data').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('event_datas.table'),
			data: function(q) {
				q.filters = JSON.stringify([{'name': 'user_id', 'value': userId}])
			},
		}),
		conditionalPaging: true,
		'columnDefs': [],
		sort: false,
	})

	function fetchLead(leadId = '', isNew = 1) {
		return axios.get(route('appointments.list'), {
			params: {
				isNew: isNew,
				leadId: leadId,
				getLeadFromUser: true,
			},
		}).then(result => {
			let items = result.data.items
			console.log(items)
			let lead = items[0].lead
			let appointmentDatetime = items[0].appointment_datetime
			let user = items[0].user

			$('#span_lead_name').text(lead.name)
			$('#span_lead_email').text(lead.email)
			$('#span_lead_phone').text(lead.phone)
			$('#span_lead_title').text(lead.title)

			$('#span_appointment_datetime').text(appointmentDatetime)
			$('#span_tele_marketer').text(user.name)

		})
	}

	$body.on('click', '.link-lead-name', function() {
		let leadId = $(this).data('lead-id')
		fetchLead(leadId, 0)
		$('#txt_lead_id').val(leadId)
	})
})