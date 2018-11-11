$(function() {
	let userId = $('#txt_user_id').val()
	let $body = $('body'),
		$btnShowUp = $('#btn_show_up'),
		$btnNotShowUp = $('#btn_not_show_up'),
		$btnQueue = $('#btn_queue'),
		$btnNotQueue = $('#btn_not_queue'),
		$btnChangeToEventData = $('#btn_change_to_event_data'),
		$btnSearch = $('#btn_search'),
		$btnNewLead = $('#btn_new_lead')

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

	function fetchLead(leadId = '', isNew = 1, appointmentId = '') {
		blockPage()
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
			console.log(appointmentId)
			$('#txt_appointment_id').val(appointmentId)

			$('#span_appointment_datetime').text(appointmentDatetime)
			$('#span_tele_marketer').text(user.username)

		}).finally(() => {
			unblock()
		})
	}

	function toggleFormEventData(disabled = false) {
		if (disabled) {
			$('#event_data_section').hide()
			$('#event_data_form').find('input, textarea').prop('disabled', disabled)
		} else {
			$('#event_data_section').show()
			$('#event_data_form').find('input, textarea').prop('disabled', disabled)
		}
	}

	function clearFormEventData() {
		$('#event_data_form').resetForm()
	}

	function toggleShowUpSection(isShow = false) {
		if (isShow) {
			$btnShowUp.prop('disabled', false)
			$btnNotShowUp.prop('disabled', false)
		} else {
			$btnShowUp.prop('disabled', true)
			$btnNotShowUp.prop('disabled', true)
		}
	}

	$('#modal_lg').on('show.bs.modal', function() {
		$('.select').select2()

		$('#select_province').select2Ajax()
		$(this).find('#txt_phone').alphanum({
			allowMinus: false,
			allowLatin: false,
			allowOtherCharSets: false,
			maxLength: 11
		})
	})

	$body.on('click', '.link-lead-name', function() {
		let leadId = $(this).data('lead-id')
		let appointmentId = $(this).data('appointment-id')
		fetchLead(leadId, 0, appointmentId).then(() => {
			toggleShowUpSection(true)
		})
		$('#txt_lead_id').val(leadId)
	})

	$body.on('click', '.btn-change-event-status', function() {
		let message = $(this).data('message')
		tableEventData.actionEdit({
			btnEdit: $(this),
			params: {
				state: $(this).data('state'),
			},
			message: message,
		})
	})

	$body.on('submit', '#new_leads_form', function(e) {
		e.preventDefault()

		let formData = new FormData($(this)[0])
		formData.append('form', 'reception')

		$(this).submitForm({url: route('leads.store'), formData: formData}).then(() => {
			$('#modal_lg').modal('hide')
			tableAppointment.reload()
			tableEventData.reload()
		})
	})

	$body.on('click', '#btn_reappointment', function() {
		let leadId = $('#txt_lead_id').val()
		let url = route('appointments.cancel', $('#txt_appointment_id').val())

		blockPage()
		axios.post(url, {}).then(result => {
			let obj = result['data']
			if (obj.message) {
				flash(obj.message)
			}
			$('#modal_md').showModal({
				url: route('leads.form_change_state', leadId), params: {
					typeCall: 4,
					callId: '',
				}, method: 'get',
			})
		}).catch(e => console.log(e)).finally(() => {
			unblock()
		})
	})

	$body.on('click', '.link-event-data', function() {
		let eventDataId = $(this).data('id')
		$('#txt_event_data_id').val(eventDataId)
		toggleFormEventData()
	})

	$body.on('click', '#btn_cancel_appointment', function() {
		let url = route('appointments.cancel', $('#txt_appointment_id').val())

		blockPage()
		axios.post(url, {}).then(result => {
			let obj = result['data']
			if (obj.message) {
				flash(obj.message)
			}
			$('#modal_md').modal('hide')
			tableAppointment.reload()
		}).catch(e => console.log(e)).finally(() => {
			unblock()
		})
	})

	$btnShowUp.on('click', function() {
		// toggleFormEventData(false)
		$('#queue_section').show()
	})

	$btnNotShowUp.on('click', function() {
		$('#queue_section').hide()
		let url = route('appointments.not_show_up', $('#txt_appointment_id').val())

		axios.post(url, {
			notQueue: true
		}).then(result => {
			let obj = result['data']
			flash(obj.message)
		}).catch(e => console.log(e)).finally(() => {
			unblock()
		})
	})

	$btnQueue.on('click', function() {
		$(this).confirmation(function(confirm) {
			if (confirm && (typeof confirm === 'object' && confirm.value)) {
				let url = route('appointments.do_queue', $('#txt_appointment_id').val())

				axios.post(url, {}).then(result => {
					let obj = result['data']
					flash(obj.message)
					tableEventData.reload()
				}).catch(e => console.log(e)).finally(() => {
					unblock()
				})
			}
		})
	})

	$btnNotQueue.on('click', function() {
		$(this).confirmation(function(confirm) {
			if (confirm && (typeof confirm === 'object' && confirm.value)) {
				let url = route('appointments.do_queue', $('#txt_appointment_id').val())

				axios.post(url, {
					notQueue: true
				}).then(result => {
					url = route('appointments.form_change_appointment')
					$('#modal_md').showModal({
						url: url, method: 'get',
					})
				}).catch(e => console.log(e)).finally(() => {
					unblock()
				})
			}

		})
	})

	$('#event_data_form').on('submit', function(e) {
		e.preventDefault()

		let eventDataFormData = new FormData($('#event_data_form')[0])

		$('#event_data_form').submitForm({url: route('event_datas.update', $('#txt_event_data_id').val()), formData: eventDataFormData}).then(() => {
			tableAppointment.reload()
			tableEventData.reload()
		})
	})

	$btnSearch.on('click', function() {
		tableAppointment.reload()
		tableEventData.reload()
	})

	$btnNewLead.on('click', function() {
		//todo: form tạo new customer
		$('#modal_lg').showModal({url: route('leads.form_new_lead'), method: 'get'})
	})
})