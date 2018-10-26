$(function() {
	let userId = $('#txt_user_id').val()
	let $body = $('body'),
		$btnShowUp = $('#btn_show_up'),
		$btnNotShowUp = $('#btn_not_show_up'),
		$btnChangeToMember = $('#btn_change_to_member'),
		$btnSearch = $('#btn_search')

	const tableAppointment = $('#table_appointment').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('appointments.table'),
			data: function(q) {
				q.filters = JSON.stringify([{'name': 'code', 'value': $('#txt_voucher_code').val()}])
				q.form = 'reception_console'
			},
		}),
		conditionalPaging: true,
		'columnDefs': [],
		// sort: false,
	})
	const tableEventData = $('#table_event_data').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('event_datas.table'),
			data: function(q) {
				q.filters = JSON.stringify([{'name': 'code', 'value': $('#txt_voucher_code').val()}])
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

			let lead = items[0].lead
			let appointmentDatetime = items[0].appointment_datetime
			let user = items[0].user

			$('#span_lead_name').text(lead.name)
			$('#span_lead_email').text(lead.email)
			$('#span_lead_phone').text(lead.phone)
			$('#span_lead_title').text(lead.title)
			$('#txt_lead_id').val(lead.id)

			$('#span_appointment_datetime').text(appointmentDatetime)
			$('#span_tele_marketer').text(user.username)

		})
	}

	function toggleFormEventData(disabled = true) {
		$('#event_data_form').find('input, textarea').prop('disabled', disabled)
	}

	function clearFormEventData() {
		$('#event_data_form').resetForm()
	}

	$body.on('click', '.link-lead-name', function() {
		let leadId = $(this).data('lead-id')
		fetchLead(leadId, 0)
		$('#txt_lead_id').val(leadId)
	})

	$btnShowUp.on('click', function() {
		toggleFormEventData(false)
	})

	$btnNotShowUp.on('click', function() {
		toggleFormEventData()
		clearFormEventData()
	})

	$btnChangeToMember.on('click', function() {
		//todo:  nếu LEAD đồng ý mua hàng, chuyển toàn bộ thông tin LEAD sang thành MEMBER và đổi LEAD.Status thành MEMBER

		let eventDataFormData = new FormData($('#event_data_form')[0])
		let leadDatas = $('#leads_form').serializeArray()
		for (let leadData of leadDatas) {
			eventDataFormData.append(leadData.name, leadData.value)
		}

		$('#event_data_form').submitForm({url: route('event_datas.store')}).then(() => {
			tableAppointment.reload()
			tableEventData.reload()
		})
	})

	$btnSearch.on('click', function() {
		tableAppointment.reload()
		tableEventData.reload()
	})
})