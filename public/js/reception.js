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
/******/ 	return __webpack_require__(__webpack_require__.s = 63);
/******/ })
/************************************************************************/
/******/ ({

/***/ 63:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(64);


/***/ }),

/***/ 64:
/***/ (function(module, exports) {

$(function () {
	var userId = $('#txt_user_id').val();
	var $body = $('body'),
	    $btnShowUp = $('#btn_show_up'),
	    $btnNotShowUp = $('#btn_not_show_up'),
	    $btnQueue = $('#btn_queue'),
	    $btnNotQueue = $('#btn_not_queue'),
	    $btnChangeToEventData = $('#btn_change_to_event_data'),
	    $btnSearch = $('#btn_search'),
	    $btnNewLead = $('#btn_new_lead');

	var tableAppointment = $('#table_appointment').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('appointments.table'),
			data: function data(q) {
				q.filters = JSON.stringify([{ 'name': 'code', 'value': $('#txt_voucher_code').val() }]);
				q.form = 'reception_console';
			}
		}),
		conditionalPaging: true,
		'columnDefs': []
		// sort: false,
	});
	var tableEventData = $('#table_event_data').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('event_datas.table'),
			data: function data(q) {
				q.filters = JSON.stringify([{ 'name': 'code', 'value': $('#txt_voucher_code').val() }]);
			}
		}),
		conditionalPaging: true,
		'columnDefs': [],
		sort: false
	});

	function fetchLead() {
		var leadId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
		var isNew = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
		var appointmentId = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '';

		blockPage();
		return axios.get(route('appointments.list'), {
			params: {
				isNew: isNew,
				leadId: leadId,
				getLeadFromUser: true
			}
		}).then(function (result) {
			var items = result.data.items;

			var lead = items[0].lead;
			var appointmentDatetime = items[0].appointment_datetime;
			var user = items[0].user;

			$('#span_lead_name').text(lead.name);
			$('#span_lead_email').text(lead.email);
			$('#span_lead_phone').text(lead.phone);
			$('#span_lead_title').text(lead.title);
			$('#txt_lead_id').val(lead.id);
			console.log(appointmentId);
			$('#txt_appointment_id').val(appointmentId);

			$('#span_appointment_datetime').text(appointmentDatetime);
			$('#span_tele_marketer').text(user.username);
		}).finally(function () {
			unblock();
		});
	}

	function toggleFormEventData() {
		var disabled = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

		if (disabled) {
			$('#event_data_section').hide();
			$('#event_data_form').find('input, textarea').prop('disabled', disabled);
		} else {
			$('#event_data_section').show();
			$('#event_data_form').find('input, textarea').prop('disabled', disabled);
		}
	}

	function clearFormEventData() {
		$('#event_data_form').resetForm();
	}

	function toggleShowUpSection() {
		var isShow = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

		if (isShow) {
			$btnShowUp.prop('disabled', false);
			$btnNotShowUp.prop('disabled', false);
		} else {
			$btnShowUp.prop('disabled', true);
			$btnNotShowUp.prop('disabled', true);
		}
	}

	$('#modal_lg').on('show.bs.modal', function () {
		$('.select').select2();

		$('#select_province').select2Ajax();
		$(this).find('#txt_phone').alphanum({
			allowMinus: false,
			allowLatin: false,
			allowOtherCharSets: false,
			maxLength: 11
		});
	});

	$body.on('click', '.link-lead-name', function () {
		var leadId = $(this).data('lead-id');
		var appointmentId = $(this).data('appointment-id');
		fetchLead(leadId, 0, appointmentId).then(function () {
			toggleShowUpSection(true);
		});
		$('#txt_lead_id').val(leadId);
	});

	$body.on('click', '.btn-change-event-status', function () {
		var message = $(this).data('message');
		tableEventData.actionEdit({
			btnEdit: $(this),
			params: {
				state: $(this).data('state')
			},
			message: message
		});
	});

	$body.on('submit', '#new_leads_form', function (e) {
		e.preventDefault();

		var formData = new FormData($(this)[0]);
		formData.append('form', 'reception');

		$(this).submitForm({ url: route('leads.store'), formData: formData }).then(function () {
			$('#modal_lg').modal('hide');
			tableAppointment.reload();
			tableEventData.reload();
		});
	});

	$body.on('click', '#btn_reappointment', function () {
		var leadId = $('#txt_lead_id').val();
		var url = route('appointments.cancel', $('#txt_appointment_id').val());

		blockPage();
		axios.post(url, {}).then(function (result) {
			var obj = result['data'];
			if (obj.message) {
				flash(obj.message);
			}
			$('#modal_md').showModal({
				url: route('leads.form_change_state', leadId), params: {
					typeCall: 4,
					callId: ''
				}, method: 'get'
			});
		}).catch(function (e) {
			return console.log(e);
		}).finally(function () {
			unblock();
		});
	});

	$body.on('click', '.link-event-data', function () {
		var eventDataId = $(this).data('id');
		$('#txt_event_data_id').val(eventDataId);
		toggleFormEventData();
	});

	$body.on('click', '#btn_cancel_appointment', function () {
		var url = route('appointments.cancel', $('#txt_appointment_id').val());

		blockPage();
		axios.post(url, {}).then(function (result) {
			var obj = result['data'];
			if (obj.message) {
				flash(obj.message);
			}
			$('#modal_md').modal('hide');
			tableAppointment.reload();
		}).catch(function (e) {
			return console.log(e);
		}).finally(function () {
			unblock();
		});
	});

	$btnShowUp.on('click', function () {
		// toggleFormEventData(false)
		$('#queue_section').show();
	});

	$btnNotShowUp.on('click', function () {
		$('#queue_section').hide();
		var url = route('appointments.not_show_up', $('#txt_appointment_id').val());

		axios.post(url, {
			notQueue: true
		}).then(function (result) {
			var obj = result['data'];
			flash(obj.message);
		}).catch(function (e) {
			return console.log(e);
		}).finally(function () {
			unblock();
		});
	});

	$btnQueue.on('click', function () {
		var url = route('appointments.do_queue', $('#txt_appointment_id').val());

		axios.post(url, {}).then(function (result) {
			var obj = result['data'];
			flash(obj.message);
		}).catch(function (e) {
			return console.log(e);
		}).finally(function () {
			unblock();
		});
	});

	$btnNotQueue.on('click', function () {
		var url = route('appointments.do_queue', $('#txt_appointment_id').val());

		axios.post(url, {
			notQueue: true
		}).then(function (result) {
			url = route('appointments.form_change_appointment');
			$('#modal_md').showModal({
				url: url, method: 'get'
			});
		}).catch(function (e) {
			return console.log(e);
		}).finally(function () {
			unblock();
		});
	});

	$('#event_data_form').on('submit', function (e) {
		e.preventDefault();

		var eventDataFormData = new FormData($('#event_data_form')[0]);

		$('#event_data_form').submitForm({ url: route('event_datas.update', $('#txt_event_data_id').val()), formData: eventDataFormData }).then(function () {
			tableAppointment.reload();
			tableEventData.reload();
		});
	});

	$btnSearch.on('click', function () {
		tableAppointment.reload();
		tableEventData.reload();
	});

	$btnNewLead.on('click', function () {
		//todo: form tạo new customer
		$('#modal_lg').showModal({ url: route('leads.form_new_lead'), method: 'get' });
	});
});

/***/ })

/******/ });