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
		orders: []
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
		orders: []
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
		orders: []
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

	function showFormChangeState() {
		let url = $('#btn_form_change_state').data('url')

		$('#modal_md').showModal({url: url, params: {}, method: 'get'})
		setInterval(callClock, 1000)
	}

	$('#leads_form').on('submit', function(e) {
		e.preventDefault()
		showFormChangeState()
	})

	$body.on('submit', '#change_state_leads_form', function(e) {
		e.preventDefault()
		mApp.block('#modal_md')

		$(this).submitForm().then(() => {
			$('#modal_md').modal('hide')
			mApp.unblock('#modal_md')
			fetchLead('', 1)
			resetCallClock()
			$('#span_customer_no').text(++totalCustomer)
		})
	})

	$body.on('submit', '#break_form', function(e) {
		e.preventDefault()
		mApp.block('#modal_md')

		$(this).submitForm().then(() => {
			$('#modal_md').modal('hide')
			mApp.unblock('#modal_md')
			$('#btn_pause').hide()
			$('#btn_resume').show()
			pauseInterval = setInterval(pauseClock, 1000)
		})
	})

	$body.on('click', '.link-lead-name', function() {
		let leadId = $(this).data('lead-id')
		fetchLead(leadId, 0)
	})

	$body.on('click', '.btn-appointment-call', showFormChangeState)

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

	function initLoginClock() {
		let diffTime = $('#span_login_time').data('diff-in-minute')
		let times = _.split(diffTime, ':')

		loginHours = times[0]
		loginMinutes = times[1]
		loginSeconds = times[2]
	}

	function resetPauseClock() {
		clearInterval(pauseInterval)
		$('#span_pause_time').text('00:00:00')
	}

	function resetCallClock() {
		clearInterval(callInterval)
		$('#span_call_time').text('00:00:00')
	}

	initLoginClock()
	setInterval(loginClock, 1000)
})