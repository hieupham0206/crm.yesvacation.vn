$(function() {
	let userId = $('#txt_user_id').val()

	let loginHours = 0, loginMinutes = 0, loginSeconds = 0
	let callHours = 0, callMinutes = 0, callSeconds = 0
	let totalCustomer = 0
	let wantToBreak = false

	let callInterval
	let $body = $('body')

	const tableHistoryCall = $('#table_history_calls').DataTable({
		'serverSide': true,
		'paging': false,
		'ajax': $.fn.dataTable.pipeline({
			url: route('history_calls.table'),
			data: function(q) {
				q.filters = JSON.stringify([{'name': 'user_id', 'value': userId}])
				q.table = 'history_call'
			},
		}),
		conditionalPaging: true,
		'columnDefs': [],
		sort: false,
		'iDisplayLength': 20,
	})
	const tableCustomerHistory = $('#table_customer_history').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('history_calls.table'),
			data: function(q) {
				q.filters = JSON.stringify([{'name': 'lead_id', 'value': $('#txt_lead_id').val()}])
				q.table = 'customer_history'
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
				table,
			}, method: 'get',
		})
	}

	$('#leads_form').on('submit', function(e) {
		e.preventDefault()
		let leadId = $('#txt_lead_id').val()
		showFormChangeState({url: route('leads.form_change_state', leadId)})
		if ($('#span_call_time').text() === '00:00:00') {
			callInterval = setInterval(callClock, 1000)
		}
	})

	$body.on('submit', '#change_state_leads_form', function(e) {
		e.preventDefault()
		mApp.block('#modal_md')
		let formData = new FormData($(this)[0])
		formData.append('startCallTime', moment($('#span_call_time').text(), 'HH:mm:ss: A').diff(moment().startOf('day'), 'seconds'))

		$(this).submitForm({formData: formData}).then(() => {
			$(this).resetForm()
			resetCallClock()
			waitClock()
			$('#span_customer_no').text(++totalCustomer)

			$('#modal_md').modal('hide')
			mApp.unblock('#modal_md')

			if (wantToBreak) {
				$('#btn_pause').trigger('click')
			}
		})
	})

	$body.on('submit', '#break_form', function(e) {
		e.preventDefault()
		mApp.block('#modal_md')

		$(this).submitForm({returnEarly: true}).then(result => {
			$(this).resetForm()
			$('#btn_pause').hide()
			$('#btn_resume').show()
			let target = result.data.maxTimeBreak

			breakTimer.start({precision: 'seconds', startValues: {seconds: 0}, target: {seconds: parseInt(target)}})
			$('#break_section').addClass('break-state')
			$('#modal_md').modal('hide')
			mApp.unblock('#modal_md')

			//hide tat ca chuc nang
			$('.work-section').hide()
		}).finally(() => {
			window.unblock()
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
		if ($(this).val() === '8') {
			$('#appointment_lead_section').show()
			$('#section_datetime').show()
			$('#comment_section').show()
		} else {
			$('#appointment_lead_section').hide()
			if ($(this).val() === '7') {
				$('#section_datetime').show()
				$('#comment_section').hide()
			} else {
				$('#section_datetime').hide()
				$('#comment_section').show()
			}
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
		$('#txt_date').datepicker({
			startDate: new Date(),
		})
	})

	$('#btn_pause').on('click', function() {
		let url = $(this).data('url')

		if ($('#span_call_time').text() !== '00:00:00' && ! wantToBreak) {
			wantToBreak = true
			// flash('Vui lòng kết thúc cuộc gọi', 'danger')
			$('#leads_form').trigger('submit')
		} else {
			$('#modal_md').showModal({url: url, params: {}, method: 'get'})
		}
	})

	function resume(params = {}) {
		blockPage()
		let url = $('#btn_resume').data('url')
		return axios.post(url, params).then(result => {
			let obj = result['data']
			if (obj.message) {
				flash(obj.message)
			}
			$('#btn_resume').hide()
			$('#btn_pause').show()
			resetPauseClock()
			$('#break_section').removeClass('break-state')
			$('.work-section').show()
			if (wantToBreak) {
				wantToBreak = false
				autoCall()
			}
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
			let birthday = lead.birthday !== '' ? moment(birthday).format('DD-MM-YYYY') : ''

			$('#span_lead_name').text(lead.name)
			$('#span_lead_birthday').text(birthday)
			$('#span_lead_phone').text(lead.phone)
			$('#span_lead_title').text(lead.title)
			$('#txt_lead_id').val(lead.id)

			reloadTable()
		})
	}

	function clearLeadInfo() {
		$('#span_lead_name').text('')
		$('#span_lead_birthday').text('')
		$('#span_lead_phone').text('')
		$('#span_lead_title').text('')
	}

	let waitTimer = new Timer()
	waitTimer.addEventListener('started', function() {
		updateCallTypeText('Waiting')
		clearLeadInfo()
		$('#btn_form_change_state').prop('disabled', true)
	})

	function autoCall() {
		fetchLead('', 1).then(() => {
			callInterval = setInterval(callClock, 1000)
			$('#btn_form_change_state').prop('disabled', false)
		})
	}

	waitTimer.addEventListener('stopped', function() {
		updateCallTypeText('Auto')
		if (! wantToBreak) {
			autoCall()
		}
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
		let startValues = $('#span_pause_time').data('start-break-value')
		let maxBreakTime = $('#span_pause_time').data('max-break-time')
		if (diffTime !== '') {
			wantToBreak = true
			breakTimer.start({precision: 'seconds', startValues: {seconds: startValues}, target: {seconds: maxBreakTime + startValues}})
			$('#btn_pause').hide()
			$('#btn_resume').show()
			$('#break_section').addClass('break-state')
			$('.work-section').hide()
		}
	}

	function resetPauseClock() {
		breakTimer.stop()
	}

	function resetCallClock() {
		clearInterval(callInterval)
		callHours = callMinutes = callSeconds = 0
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
	if ($('#txt_lead_id').val() !== '') {
		callInterval = setInterval(callClock, 1000)
	}
})