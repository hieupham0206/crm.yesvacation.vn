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
/******/ 	return __webpack_require__(__webpack_require__.s = 59);
/******/ })
/************************************************************************/
/******/ ({

/***/ 59:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(60);


/***/ }),

/***/ 60:
/***/ (function(module, exports) {

$(function () {
	var userId = $('#txt_user_id').val();
	var leadId = $('#txt_lead_id').val();

	var loginHours = 0,
	    loginMinutes = 0,
	    loginSeconds = 0;
	var callHours = 0,
	    callMinutes = 0,
	    callSeconds = 0;
	var pauseHours = 0,
	    pauseMinutes = 0,
	    pauseSeconds = 0;
	var totalCustomer = 0;

	var pauseInterval = void 0,
	    callInterval = void 0;
	var $body = $('body');

	var tableHistoryCall = $('#table_history_calls').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('history_calls.table'),
			data: function data(q) {
				q.filters = JSON.stringify([{ 'name': 'user_id', 'value': userId }]);
			}
		}),
		conditionalPaging: true,
		'columnDefs': []
		// info: true,
		// lengthChange: true,
	});
	var tableCustomerHistory = $('#table_customer_history').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('history_calls.table'),
			data: function data(q) {
				q.filters = JSON.stringify([{ 'name': 'lead_id', 'value': leadId }]);
			}
		}),
		conditionalPaging: true,
		'columnDefs': []
		// info: true,
		// lengthChange: true,
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
		'columnDefs': []
		// info: true,
		// lengthChange: true,
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
		'columnDefs': []
		// info: true,
		// lengthChange: true,
	});

	$('#leads_form').on('submit', function (e) {
		e.preventDefault();
		var url = $('#btn_form_change_state').data('url');

		$('#modal_md').showModal({ url: url, params: {}, method: 'get' });
	});

	$body.on('submit', '#change_state_leads_form', function (e) {
		e.preventDefault();
		mApp.block('#modal_md');

		$(this).submitForm().then(function () {
			$('#modal_md').modal('hide');
			mApp.unblock('#modal_md');
			fetchLead('', 1);
			resetCallClock();
			$('#span_customer_no').text(++totalCustomer);
		});
	});

	$body.on('submit', '#break_form', function (e) {
		e.preventDefault();
		mApp.block('#modal_md');

		$(this).submitForm().then(function () {
			$('#modal_md').modal('hide');
			mApp.unblock('#modal_md');
			$('#btn_pause').hide();
			$('#btn_resume').show();
			pauseInterval = setInterval(pauseClock, 1000);
		});
	});

	$body.on('click', '.link-lead-name', function () {
		var leadId = $(this).data('lead-id');
		fetchLead(leadId, 0);
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
		$('#txt_date').datepicker();
	});

	$('#btn_pause').on('click', function () {
		var url = $(this).data('url');

		$('#modal_md').showModal({ url: url, params: {}, method: 'get' });
	});

	$('#btn_resume').on('click', function () {
		var _this = this;

		var url = $(this).data('url');
		blockPage();

		axios.post(url).then(function (result) {
			var obj = result['data'];
			if (obj.message) {
				flash(obj.message);
			}
			$(_this).hide();
			$('#btn_pause').show();
			resetPauseClock();
		}).catch(function (e) {
			return console.log(e);
		}).finally(function () {
			unblock();
		});
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

		function harold(standIn) {
			if (standIn < 10) {
				standIn = '0' + standIn;
			}
			return standIn;
		}
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

		function harold(standIn) {
			if (standIn < 10) {
				standIn = '0' + standIn;
			}
			return standIn;
		}
	}

	function pauseClock() {
		pauseSeconds++;
		if (pauseSeconds === 60) {
			pauseMinutes++;
			pauseSeconds = 0;

			if (pauseMinutes === 60) {
				pauseMinutes = 0;
				pauseHours++;
			}
		}
		$('#span_pause_time').text(harold(pauseHours) + ':' + harold(pauseMinutes) + ':' + harold(pauseSeconds));

		function harold(standIn) {
			if (standIn < 10) {
				standIn = '0' + standIn;
			}
			return standIn;
		}
	}

	function loginTime() {
		loginClock();
	}

	function initLoginClock() {
		var diffTime = $('#span_login_time').data('diff-in-minute');
		var times = _.split(diffTime, ':');

		loginHours = times[0];
		loginMinutes = times[1];
		loginSeconds = times[2];
	}

	function resetPauseClock() {
		clearInterval(pauseInterval);
		$('#span_pause_time').text('00:00:00');
	}

	function resetCallClock() {
		clearInterval(callInterval);
		$('#span_call_time').text('00:00:00');
	}

	initLoginClock();
	setInterval(loginTime, 1000);
});

/***/ })

/******/ });