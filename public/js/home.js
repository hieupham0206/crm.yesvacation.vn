/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 61);
/******/ })
/************************************************************************/
/******/ ({

/***/ 61:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(62);


/***/ }),

/***/ 62:
/***/ (function(module, exports) {

$(function () {
	var userId = $('#txt_user_id').val();

	var loginHours = 0,
	    loginMinutes = 0,
	    loginSeconds = 0;
	var callHours = 0,
	    callMinutes = 0,
	    callSeconds = 0;
	var totalCustomer = 0;

	var callInterval = void 0;
	var $body = $('body');

	var tableHistoryCall = $('#table_history_calls').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('history_calls.table'),
			data: function data(q) {
				q.filters = JSON.stringify([{ 'name': 'user_id', 'value': userId }]);
				q.table = 'history_call';
			}
		}),
		conditionalPaging: true,
		'columnDefs': [],
		sort: false
	});
	var tableCustomerHistory = $('#table_customer_history').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('history_calls.table'),
			data: function data(q) {
				q.filters = JSON.stringify([{ 'name': 'lead_id', 'value': $('#txt_lead_id').val() }]);
				q.table = 'customer_history';
			}
		}),
		conditionalPaging: true,
		'columnDefs': [],
		sort: false
	});
	var tableCallback = $('#table_callback').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('callbacks.table'),
			data: function data(q) {
				q.filters = JSON.stringify([{ 'name': 'user_id', 'value': userId }]);
			}
		}),
		conditionalPaging: true,
		'columnDefs': [],
		sort: false
	});
	var tableAppointment = $('#table_appointment').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('appointments.table'),
			data: function data(q) {
				q.filters = JSON.stringify([{ 'name': 'user_id', 'value': userId }]);
			}
		}),
		conditionalPaging: true,
		'columnDefs': [],
		sort: false
	});

	function showFormChangeState(_ref) {
		var _ref$typeCall = _ref.typeCall,
		    typeCall = _ref$typeCall === undefined ? 1 : _ref$typeCall,
		    url = _ref.url,
		    _ref$callId = _ref.callId,
		    callId = _ref$callId === undefined ? '' : _ref$callId,
		    _ref$table = _ref.table,
		    table = _ref$table === undefined ? '' : _ref$table;

		$('#modal_md').showModal({
			url: url, params: {
				typeCall: typeCall,
				callId: callId,
				table: table
			}, method: 'get'
		});
	}

	$('#leads_form').on('submit', function (e) {
		e.preventDefault();
		var leadId = $('#txt_lead_id').val();
		showFormChangeState({ url: route('leads.form_change_state', leadId) });
	});

	$body.on('submit', '#change_state_leads_form', function (e) {
		var _this = this;

		e.preventDefault();
		mApp.block('#modal_md');

		$(this).submitForm().then(function () {
			$(_this).resetForm();
			resetCallClock();
			waitClock();
			reloadTable();
			$('#span_customer_no').text(++totalCustomer);

			$('#modal_md').modal('hide');
			mApp.unblock('#modal_md');
		});
	});

	$body.on('submit', '#break_form', function (e) {
		var _this2 = this;

		e.preventDefault();
		mApp.block('#modal_md');

		$(this).submitForm().then(function (result) {
			$(_this2).resetForm();
			$('#btn_pause').hide();
			$('#btn_resume').show();
			var target = result.maxTimeBreak;

			breakTimer.start({ precision: 'seconds', startValues: { seconds: 0 }, target: { seconds: parseInt(target) } });

			$('#modal_md').modal('hide');
			mApp.unblock('#modal_md');
		});
	});

	$body.on('click', '.btn-delete', function () {
		var route = $(this).data('route');
		if (route === 'callbacks') {
			tableCallback.actionDelete({
				btnDelete: $(this)
			});
		} else if (route === 'appointments') {
			tableAppointment.actionDelete({
				btnDelete: $(this)
			});
		} else if (route === 'history_calls') {
			tableHistoryCall.actionDelete({
				btnDelete: $(this)
			});
		}
	});

	$body.on('click', '.link-lead-name', function () {
		var leadId = $(this).data('lead-id');
		fetchLead(leadId, 0);
		$('#txt_lead_id').val(leadId);
		reloadLeadRelatedTable();
	});

	$body.on('click', '.btn-appointment-call', function () {
		var leadId = $(this).data('lead-id');
		var typeCall = $(this).data('type-call');
		var callId = $(this).data('id');

		showFormChangeState({ typeCall: typeCall, url: route('leads.form_change_state', leadId), callId: callId, table: 'appointments' });
		updateCallTypeText('Appointment Call');
	});

	$body.on('click', '.btn-callback-call', function () {
		var leadId = $(this).data('lead-id');
		var typeCall = $(this).data('type-call');
		var callId = $(this).data('id');

		showFormChangeState({ typeCall: typeCall, url: route('leads.form_change_state', leadId), callId: callId, table: 'callbacks' });
		updateCallTypeText('Callback Call');
	});

	$body.on('click', '.btn-history-call', function () {
		var leadId = $(this).data('lead-id');
		var typeCall = $(this).data('type-call');

		showFormChangeState({ typeCall: typeCall, url: route('leads.form_change_state', leadId) });
		updateCallTypeText('History Call');
	});

	$body.on('click', '.btn-edit-datetime', function () {
		var appointmentId = $(this).data('id');
		var $tr = $(this).parents('tr');
		var spanAppointmentDatetimeText = $tr.find('.span-datetime');
		var appointmentDatetime = spanAppointmentDatetimeText.text();
		var urlEdit = $(this).data('url');

		var html = '<div class="input-group">\n\t\t\t\t\t\t\t<input type="text" class="form-control text-inline-datepicker" value="' + appointmentDatetime + '" data-appointment-id="' + appointmentId + '">\n\t\t\t\t\t\t\t<div class="input-group-append">\n\t\t\t\t\t\t\t\t<button class="btn btn-success btn-change-datetime btn-sm" type="button" data-url="' + urlEdit + '"><i class="fa fa-check"></i></button>\n\t\t\t\t\t\t\t\t<button class="btn btn-danger btn-cancel-datetime btn-sm" type="button"><i class="fa fa-trash"></i></button>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>';

		spanAppointmentDatetimeText.html(html);
		$tr.find('.text-inline-datepicker').datetimepicker({
			startDate: new Date()
		});
		$(this).prop('disabled', true);
	});

	$body.on('click', '.btn-cancel-datetime', function () {
		var parents = $(this).parents('tr');
		var appointmentDatetime = parents.find('.text-inline-datepicker').val();
		parents.find('.span-datetime').text(appointmentDatetime);

		parents.find('.btn-edit-datetime').prop('disabled', false);
	});

	$body.on('click', '.btn-change-datetime', function () {
		var _this3 = this;

		var $textInlineDatepicker = $(this).parents('.input-group').find('.text-inline-datepicker');
		var dateTime = $textInlineDatepicker.val();
		var urlEdit = $(this).data('url');

		axios.post(urlEdit, {
			dateTime: dateTime
		}).then(function (result) {
			var obj = result['data'];
			if (obj.message) {
				flash(obj.message);
			}
			var parents = $(_this3).parents('tr');
			parents.find('.span-datetime').text(dateTime);
			parents.find('.btn-edit-datetime').prop('disabled', false);
		}).catch(function (e) {
			return console.log(e);
		}).finally(function () {
			unblock();
		});
	});

	$body.on('change', '#select_state_modal', function () {
		if (['7', '8'].includes($(this).val())) {
			$('#appointment_lead_section').show();
		} else {
			$('#appointment_lead_section').hide();
		}
	});

	$body.on('change', '#select_reason_break', function () {
		if ($(this).val() === '5') {
			$('#another_reason_section').show();
		} else {
			$('#textarea_reason').val('');
			$('#another_reason_section').hide();
		}
	});

	$('#modal_md').on('show.bs.modal', function () {
		$('#select_state_modal').select2();
		$('#select_reason_break').select2();
		$('#select_time').select2();
		$('#txt_date').datepicker({
			startDate: new Date()
		});
	});

	$('#btn_pause').on('click', function () {
		var url = $(this).data('url');

		$('#modal_md').showModal({ url: url, params: {}, method: 'get' });
	});

	function resume() {
		var params = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

		blockPage();
		var url = $('#btn_resume').data('url');
		return axios.post(url, params).then(function (result) {
			var obj = result['data'];
			if (obj.message) {
				flash(obj.message);
			}
			$('#btn_resume').hide();
			$('#btn_pause').show();
			resetPauseClock();
		}).catch(function (e) {
			return console.log(e);
		}).finally(function () {
			unblock();
		});
	}

	$('#btn_resume').on('click', function () {
		resume();
	});

	function fetchLead() {
		var leadId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
		var isNew = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;

		return axios.get(route('leads.list'), {
			params: {
				isNew: isNew,
				leadId: leadId,
				getLeadFromUser: true
			}
		}).then(function (result) {
			var items = result.data.items;
			var lead = items[0];

			$('#span_lead_name').text(lead.name);
			$('#span_lead_email').text(lead.email);
			$('#span_lead_phone').text(lead.phone);
			$('#span_lead_title').text(lead.title);
		});
	}

	function clearLeadInfo() {
		$('#span_lead_name').text('');
		$('#span_lead_email').text('');
		$('#span_lead_phone').text('');
		$('#span_lead_title').text('');
	}

	var waitTimer = new Timer();
	waitTimer.addEventListener('started', function () {
		updateCallTypeText('Waiting');
		clearLeadInfo();
	});
	waitTimer.addEventListener('stopped', function () {
		updateCallTypeText('Auto');
		fetchLead('', 1).then(function () {
			callInterval = setInterval(callClock, 1000);
		});
	});
	waitTimer.addEventListener('secondsUpdated', function () {
		$('#span_call_time').html(waitTimer.getTimeValues().toString());
	});
	waitTimer.addEventListener('targetAchieved', function () {
		$('#span_call_time').html('00:00:00');
	});

	var breakTimer = new Timer();

	breakTimer.addEventListener('secondsUpdated', function () {
		$('#span_pause_time').html(breakTimer.getTimeValues().toString());
	});
	breakTimer.addEventListener('targetAchieved', function () {
		resume().then(function () {
			flash('Đã quá thời gian nghỉ, vui lòng trở lại làm việc.', 'danger', false);
		});
	});

	function harold(standIn) {
		if (standIn < 10) {
			standIn = '0' + standIn;
		}
		return standIn;
	}

	function loginClock() {
		loginSeconds++;
		if (loginSeconds === 60) {
			loginMinutes++;
			loginSeconds = 0;

			if (loginMinutes === 60) {
				loginMinutes = 0;
				loginHours++;
			}
		}
		$('#span_login_time').text(harold(loginHours) + ':' + harold(loginMinutes) + ':' + harold(loginSeconds));
	}

	function callClock() {
		callSeconds++;
		if (callSeconds === 60) {
			callMinutes++;
			callSeconds = 0;

			if (callMinutes === 60) {
				callMinutes = 0;
				callHours++;
			}
		}
		$('#span_call_time').text(harold(callHours) + ':' + harold(callMinutes) + ':' + harold(callSeconds));
	}

	function waitClock() {
		waitTimer.start({ countdown: true, startValues: { seconds: 5 } });
		$('#span_call_time').html(waitTimer.getTimeValues().toString());
	}

	function initLoginClock() {
		var diffTime = $('#span_login_time').data('diff-login-time');
		var times = _.split(diffTime, ':');

		loginHours = times[0];
		loginMinutes = times[1];
		loginSeconds = times[2];
	}

	function initBreakClock() {
		var diffTime = $('#span_pause_time').data('diff-break-time');
		var startValues = $('#span_pause_time').data('start-break-value');
		var maxBreakTime = $('#span_pause_time').data('max-break-time');
		if (diffTime !== '') {
			breakTimer.start({ precision: 'seconds', startValues: { seconds: startValues }, target: { seconds: maxBreakTime + startValues } });
			$('#btn_pause').hide();
			$('#btn_resume').show();
		}
	}

	function resetPauseClock() {
		breakTimer.stop();
	}

	function resetCallClock() {
		clearInterval(callInterval);
		$('#span_call_time').text('00:00:00');
	}

	function updateCallTypeText(type) {
		$('#span_call_type').text(type);
	}

	function reloadTable() {
		tableAppointment.reload();
		tableCallback.reload();
		tableCustomerHistory.reload();
		tableHistoryCall.reload();
	}

	function reloadLeadRelatedTable() {
		tableCustomerHistory.reload();
		tableHistoryCall.reload();
	}

	initLoginClock();
	initBreakClock();
	setInterval(loginClock, 1000);
});

/***/ })

/******/ });