$(function() {
	let userId = $('#txt_user_id').val()
	let leadId = $('#txt_lead_id').val()

	let loginHours = 0, loginMinutes = 0, loginSeconds = 0
	let callHours = 0, callMinutes = 0, callSeconds = 0
	let pauseHours = 0, pauseMinutes = 0, pauseSeconds = 0
	let totalCustomer = 0

	let pauseInterval, callInterval
	let $body = $('body')

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
		sort: false,
	})
	const tableCustomerHistory = $('#table_customer_history').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('history_calls.table'),
			data: function(q) {
				q.filters = JSON.stringify([{'name': 'lead_id', 'value': $('#txt_lead_id').val()}])
			},
		}),
		conditionalPaging: true,
		'columnDefs': [],
		sort: false,
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
		sort: false,
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
		sort: false,
	})

	function showFormChangeState(typeCall = 1) {
		let url = $('#btn_form_change_state').data('url')

		$('#modal_md').showModal({
			url: url, params: {
				typeCall: typeCall,
			}, method: 'get',
		})
		callInterval = setInterval(callClock, 1000)
	}

	$('#leads_form').on('submit', function(e) {
		e.preventDefault()
		showFormChangeState()
	})

	$body.on('submit', '#change_state_leads_form', function(e) {
		e.preventDefault()
		mApp.block('#modal_md')

		$(this).submitForm().then(() => {
			$(this).resetForm()
			resetCallClock()
			waitClock()
			reloadTable()
			$('#span_customer_no').text(++totalCustomer)

			$('#modal_md').modal('hide')
			mApp.unblock('#modal_md')
		})
	})

	$body.on('submit', '#break_form', function(e) {
		e.preventDefault()
		mApp.block('#modal_md')

		$(this).submitForm().then(() => {
			$(this).resetForm()
			$('#btn_pause').hide()
			$('#btn_resume').show()
			pauseInterval = setInterval(pauseClock, 1000)

			$('#modal_md').modal('hide')
			mApp.unblock('#modal_md')
		})
	})

	$body.on('click', '.link-lead-name', function() {
		let leadId = $(this).data('lead-id')
		fetchLead(leadId, 0)
		$('#txt_lead_id').val(leadId)
		reloadLeadRelatedTable()
	})

	$body.on('click', '.btn-appointment-call', function() {
		let leadId = $(this).data('lead-id')
		let typeCall = $(this).data('type-call')

		showFormChangeState(typeCall)
		fetchLead(leadId, 0)
		updateCallTypeText('Appointment Call')

	})

	$body.on('click', '.btn-edit-appointment', function() {
		let appointmentId = $(this).data('id')
		let spanAppointmentDatetimeText = $(this).parents('tr').find('.span-appointment-datetime')
		let appointmentDatetime = spanAppointmentDatetimeText.text()
		let html = `<div class="input-group">
							<input type="text text-datepicker" class="form-control" value="${appointmentDatetime}" data-appointment-id="${appointmentId}">
							<div class="input-group-append">
								<button class="btn btn-brand btn-change-appointment-datetime" type="button">Submit</button>
							</div>
						</div>`

		spanAppointmentDatetimeText.html(html)
		$('.text-datepicker').datepicker()
	})

	$body.on('click', '.btn-change-appointment-datetime', function() {
		let appointmentDatetime = $(this).parents('.input-group').find('.text-datepicker').val()
		let appointmentId = $(this).data('appointment-id')
		let urlEdit = route('leads.edit_appointment', appointmentId)

		axios.post(urlEdit, {
			appointmentDatetime: appointmentDatetime,
		}).then(result => {
			let obj = result['data']
			if (obj.message) {
				flash(obj.message)
			}
			$(this).parents('tr').find('.span-appointment-datetime').text(appointmentDatetime)
		}).catch(e => console.log(e)).finally(() => {
			unblock()
		})
	})

	$body.on('click', '.btn-callback-call', function() {
		let leadId = $(this).data('lead-id')
		let typeCall = $(this).data('type-call')

		showFormChangeState(typeCall)
		fetchLead(leadId, 0)
		updateCallTypeText('Callback Call')
	})

	$body.on('change', '#select_state_modal', function() {
		if (['7', '8'].includes($(this).val())) {
			$('#appointment_lead_section').show()
		} else {
			$('#appointment_lead_section').hide()
		}
	})

	$body.on('change', '#select_reason_break', function() {
		if ($(this).val() === '5') {
			$('#another_reason_section').show()
		} else {
			$('#textarea_reason').val('')
			$('#another_reason_section').hide()
		}
	})

	$('#modal_md').on('show.bs.modal', function() {
		$('#select_state_modal').select2()
		$('#select_reason_break').select2()
		$('#select_time').select2()
		$('#txt_date').datepicker()
	})

	$('#btn_pause').on('click', function() {
		let url = $(this).data('url')

		$('#modal_md').showModal({url: url, params: {}, method: 'get'})
	})

	$('#btn_resume').on('click', function() {
		let url = $(this).data('url')
		blockPage()

		axios.post(url).then(result => {
			let obj = result['data']
			if (obj.message) {
				flash(obj.message)
			}
			$(this).hide()
			$('#btn_pause').show()
			resetPauseClock()
		}).catch(e => console.log(e)).finally(() => {
			unblock()
		})
	})

	let timer = new Timer()
	timer.addEventListener('started', function(e) {
		updateCallTypeText('Waiting')
	})
	timer.addEventListener('stopped', function(e) {
		updateCallTypeText('Auto')
		fetchLead('', 1)
	})
	timer.addEventListener('secondsUpdated', function(e) {
		$('#span_call_time').html(timer.getTimeValues().toString())
	})
	timer.addEventListener('targetAchieved', function(e) {
		$('#span_call_time').html('00:00:00')
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

			$('#span_lead_name').text(lead.name)
			$('#span_lead_email').text(lead.email)
			$('#span_lead_phone').text(lead.phone)
			$('#span_lead_title').text(lead.title)

		})
	}

	function loginClock() {
		loginSeconds++
		if (loginSeconds === 60) {
			loginMinutes++
			loginSeconds = 0

			if (loginMinutes === 60) {
				loginMinutes = 0
				loginHours++
			}
		}
		$('#span_login_time').text(harold(loginHours) + ':' + harold(loginMinutes) + ':' + harold(loginSeconds))

		function harold(standIn) {
			if (standIn < 10) {
				standIn = '0' + standIn
			}
			return standIn
		}
	}

	function callClock() {
		callSeconds++
		if (callSeconds === 60) {
			callMinutes++
			callSeconds = 0

			if (callMinutes === 60) {
				callMinutes = 0
				callHours++
			}
		}
		$('#span_call_time').text(harold(callHours) + ':' + harold(callMinutes) + ':' + harold(callSeconds))

		function harold(standIn) {
			if (standIn < 10) {
				standIn = '0' + standIn
			}
			return standIn
		}
	}

	function pauseClock() {
		pauseSeconds++
		if (pauseSeconds === 60) {
			pauseMinutes++
			pauseSeconds = 0

			if (pauseMinutes === 60) {
				pauseMinutes = 0
				pauseHours++
			}
		}
		$('#span_pause_time').text(harold(pauseHours) + ':' + harold(pauseMinutes) + ':' + harold(pauseSeconds))

		function harold(standIn) {
			if (standIn < 10) {
				standIn = '0' + standIn
			}
			return standIn
		}
	}

	function waitClock() {
		timer.start({countdown: true, startValues: {seconds: 5}})
		$('#span_call_time').html(timer.getTimeValues().toString())
	}

	function initLoginClock() {
		let diffTime = $('#span_login_time').data('diff-login-time')
		let times = _.split(diffTime, ':')

		loginHours = times[0]
		loginMinutes = times[1]
		loginSeconds = times[2]
	}

	function initBreakClock() {
		let diffTime = $('#span_pause_time').data('diff-break-time')
		if (diffTime !== '') {
			let times = _.split(diffTime, ':')

			pauseHours = times[0]
			pauseMinutes = times[1]
			pauseSeconds = times[2]
		}
	}

	function resetPauseClock() {
		clearInterval(pauseInterval)
		$('#span_pause_time').text('00:00:00')
	}

	function resetCallClock() {
		console.log('clear call clock')
		clearInterval(callInterval)
		$('#span_call_time').text('00:00:00')
	}

	function updateCallTypeText(type) {
		$('#span_call_type').text(type)
	}

	function reloadTable() {
		tableAppointment.reload()
		tableCallback.reload()
		tableCustomerHistory.reload()
		tableHistoryCall.reload()
	}

	function reloadLeadRelatedTable() {
		tableCustomerHistory.reload()
		tableHistoryCall.reload()
	}

	initLoginClock()
	initBreakClock()
	setInterval(loginClock, 1000)
})