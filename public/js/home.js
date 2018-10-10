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
		// let url = $('#btn_form_change_state').data('url')
		//
		// $('#modal_md').showModal({url: url, params: {}, method: 'get'})
		fetchLead('', 1);
	});

	$('body').on('submit', '#change_state_leads_form', function (e) {
		e.preventDefault();
		mApp.block('#modal_md');

		$(this).submitForm().then(function () {
			$('#modal_md').modal('hide');
			mApp.unblock('#modal_md');
			fetchLead('', 1);
		});
	});

	$('body').on('submit', '#break_form', function (e) {
		e.preventDefault();
		mApp.block('#modal_md');

		$(this).submitForm().then(function () {
			$('#modal_md').modal('hide');
			mApp.unblock('#modal_md');
			$('#btn_pause').hide();
			$('#btn_resume').hide();
		});
	});

	$('#modal_md').on('show.bs.modal', function () {
		$('#select_state_modal').select2();
		$('#select_reason_break').select2();
	});

	$('#btn_pause').on('click', function () {
		var url = $(this).data('url');

		$('#modal_md').showModal({ url: url, params: {}, method: 'get' });
	});

	$('#btn_resume').on('click', function () {
		var _this = this;

		var url = $(this).data('url');

		axios.post(url).then(function (result) {
			var obj = result['data'];
			if (obj.message) {
				flash(obj.message);
			}
			$(_this).hide();
			$('#btn_pause').show();
		}).catch(function (e) {
			return console.log(e);
		}).finally(function () {
			unblock();
		});
	});

	$('body').on('click', '.link-lead-name', function () {
		var leadId = $(this).data('lead-id');
		fetchLead(leadId, 0);
	});

	$('body').on('change', '#select_reason_break', function () {
		if ($(this).val() === '5') {
			$('#another_reason_section').show();
		} else {
			$('#textarea_reason').val('');
			$('#another_reason_section').hide();
		}
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

			$('#txt_name').val(lead.name);
			$('#txt_email').val(lead.email);
			$('#txt_phone').val(lead.phone);
			$('#txt_address').val(lead.address);
			$('#textarea_comment').val(lead.comment);
			$('#select_state').val(lead.state).trigger('change');

			if (lead.title === 'Anh') {
				$('#select_title').val(1).trigger('change');
			} else {
				$('#select_title').val(2).trigger('change');
			}
		});
	}
});

/***/ })

/******/ });