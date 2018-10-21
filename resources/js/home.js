$(function() {
	let userId = $('#txt_user_id').val()

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

	function showFormChangeState({typeCall = 1, url, callId = '', table = ''}) {
		$('#modal_md').showModal({
			url: url, params: {
				typeCall,
				callId,
				table
			}, method: 'get',
		})
	}

	$('#leads_form').on('submit', function(e) {
		e.preventDefault()
		let url = $('#btn_form_change_state').data('url')
		showFormChangeState({url: url})
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

		$(this).submitForm().then(result => {
			$(this).resetForm()
			$('#btn_pause').hide()
			$('#btn_resume').show()
			let target = result.maxTimeBreak

			breakTimer.start({precision: 'seconds', startValues: {seconds: 0}, target: {seconds: parseInt(target)}});

			$('#modal_md').modal('hide')
			mApp.unblock('#modal_md')
		})
	})

	$body.on('click', '.btn-delete', function() {
		let route = $(this).data('route')
		if (route === 'callbacks') {
			tableCallback.actionDelete({
				btnDelete: $(this),
			})
		} else if (route === 'appointments') {
			tableAppointment.actionDelete({
				btnDelete: $(this),
			})
		} else if (route === 'history_calls') {
			tableHistoryCall.actionDelete({
				btnDelete: $(this),
			})
		}
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
		let callId = $(this).data('id')

		showFormChangeState({typeCall: typeCall, url: route('leads.form_change_state', leadId), callId: callId, table: 'appointments'})
		updateCallTypeText('Appointment Call')

	})

	$body.on('click', '.btn-callback-call', function() {
		let leadId = $(this).data('lead-id')
		let typeCall = $(this).data('type-call')
		let callId = $(this).data('id')

		showFormChangeState({typeCall: typeCall, url: route('leads.form_change_state', leadId), callId: callId, table: 'callbacks'})
		updateCallTypeText('Callback Call')
	})

	$body.on('click', '.btn-history-call', function() {
		let leadId = $(this).data('lead-id')
		let typeCall = $(this).data('type-call')

		showFormChangeState({typeCall: typeCall, url: route('leads.form_change_state', leadId)})
		updateCallTypeText('History Call')
	})

	$body.on('click', '.btn-edit-datetime', function() {
		let appointmentId = $(this).data('id')
		let $tr = $(this).parents('tr')
		let spanAppointmentDatetimeText = $tr.find('.span-datetime')
		let appointmentDatetime = spanAppointmentDatetimeText.text()
		let urlEdit = $(this).data('url')

		let html = `<div class="input-group">
							<input type="text" class="form-control text-inline-datepicker" value="${appointmentDatetime}" data-appointment-id="${appointmentId}">
							<div class="input-group-append">
								<button class="btn btn-success btn-change-datetime btn-sm" type="button" data-url="${urlEdit}"><i class="fa fa-check"></i></button>
								<button class="btn btn-danger btn-cancel-datetime btn-sm" type="button"><i class="fa fa-trash"></i></button>
							</div>
						</div>`

		spanAppointmentDatetimeText.html(html)
		$tr.find('.text-inline-datepicker').datetimepicker({
			startDate: new Date(),
		})
		$(this).prop('disabled', true)
	})

	$body.on('click', '.btn-cancel-datetime', function() {
		let parents = $(this).parents('tr')
		let appointmentDatetime = parents.find('.text-inline-datepicker').val()
		parents.find('.span-datetime').text(appointmentDatetime)

		parents.find('.btn-edit-datetime').prop('disabled', false)
	})

	$body.on('click', '.btn-change-datetime', function() {
		let $textInlineDatepicker = $(this).parents('.input-group').find('.text-inline-datepicker')
		let dateTime = $textInlineDatepicker.val()
		let urlEdit = $(this).data('url')

		axios.post(urlEdit, {
			dateTime: dateTime,
		}).then(result => {
			let obj = result['data']
			if (obj.message) {
				flash(obj.message)
			}
			let parents = $(this).parents('tr')
			parents.find('.span-datetime').text(dateTime)
			parents.find('.btn-edit-datetime').prop('disabled', false)
		}).catch(e => console.log(e)).finally(() => {
			unblock()
		})
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

	function resume(params = {}) {
		blockPage()
		let url = $('#btn_resume').data('url')
		return axios.post(url, params).then(result => {
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
	}

	$('#btn_resume').on('click', function() {
		resume()
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

	let waitTimer = new Timer()
	waitTimer.addEventListener('started', function() {
		updateCallTypeText('Waiting')
	})
	waitTimer.addEventListener('stopped', function() {
		updateCallTypeText('Auto')
		fetchLead('', 1)
		callInterval = setInterval(callClock, 1000)
	})
	waitTimer.addEventListener('secondsUpdated', function() {
		$('#span_call_time').html(waitTimer.getTimeValues().toString())
	})
	waitTimer.addEventListener('targetAchieved', function() {
		$('#span_call_time').html('00:00:00')
	})

	let breakTimer = new Timer()
	breakTimer.addEventListener('secondsUpdated', function() {
		$('#span_pause_time').html(breakTimer.getTimeValues().toString())
	})
	breakTimer.addEventListener('targetAchieved', function() {
		$('#btn_resume').trigger('click')
		resume().then(() => {
			flash('Đã quá thời gian nghỉ, vui lòng trở lại làm việc.', 'danger', false)
		})
	})

	function harold(standIn) {
		if (standIn < 10) {
			standIn = '0' + standIn
		}
		return standIn
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
	}

	function waitClock() {
		waitTimer.start({countdown: true, startValues: {seconds: 5}})
		$('#span_call_time').html(waitTimer.getTimeValues().toString())
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
		let maxBreakTime = $('#span_pause_time').data('max-break-time')
		if (diffTime !== '') {
			let times = _.split(diffTime, ':')

			pauseHours = times[0]
			pauseMinutes = times[1]
			pauseSeconds = times[2]

			breakTimer.start({precision: 'seconds', startValues: {seconds: pauseSeconds}, target: {seconds: maxBreakTime}});
			$('#btn_pause').hide()
			$('#btn_resume').show()
		}
	}

	function resetPauseClock() {
		clearInterval(pauseInterval)
		$('#span_pause_time').text('00:00:00')
	}

	function resetCallClock() {
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