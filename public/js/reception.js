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
	    $btnChangeToMember = $('#btn_change_to_member'),
	    $btnSearch = $('#btn_search');

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

			$('#span_appointment_datetime').text(appointmentDatetime);
			$('#span_tele_marketer').text(user.username);
		});
	}

	function toggleFormEventData() {
		var disabled = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;

		$('#event_data_form').find('input, textarea').prop('disabled', disabled);
	}

	function clearFormEventData() {
		$('#event_data_form').resetForm();
	}

	$body.on('click', '.link-lead-name', function () {
		var leadId = $(this).data('lead-id');
		fetchLead(leadId, 0);
		$('#txt_lead_id').val(leadId);
	});

	$btnShowUp.on('click', function () {
		toggleFormEventData(false);
	});

	$btnNotShowUp.on('click', function () {
		toggleFormEventData();
		clearFormEventData();
	});

	$btnChangeToMember.on('click', function () {
		//todo:  nếu LEAD đồng ý mua hàng, chuyển toàn bộ thông tin LEAD sang thành MEMBER và đổi LEAD.Status thành MEMBER

		var eventDataFormData = new FormData($('#event_data_form')[0]);
		var leadDatas = $('#leads_form').serializeArray();
		var _iteratorNormalCompletion = true;
		var _didIteratorError = false;
		var _iteratorError = undefined;

		try {
			for (var _iterator = leadDatas[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
				var leadData = _step.value;

				eventDataFormData.append(leadData.name, leadData.value);
			}
		} catch (err) {
			_didIteratorError = true;
			_iteratorError = err;
		} finally {
			try {
				if (!_iteratorNormalCompletion && _iterator.return) {
					_iterator.return();
				}
			} finally {
				if (_didIteratorError) {
					throw _iteratorError;
				}
			}
		}

		$('#event_data_form').submitForm({ url: route('event_datas.store') }).then(function () {
			tableAppointment.reload();
			tableEventData.reload();
		});
	});

	$btnSearch.on('click', function () {
		tableAppointment.reload();
		tableEventData.reload();
	});
});

/***/ })

/******/ });