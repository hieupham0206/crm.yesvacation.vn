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
/******/ 	return __webpack_require__(__webpack_require__.s = 82);
/******/ })
/************************************************************************/
/******/ ({

/***/ 82:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(83);


/***/ }),

/***/ 83:
/***/ (function(module, exports) {

$(function () {
	var $body = $('body');

	$body.on('click', '#btn_create', function () {
		var createUrl = $(this).data('url');
		$('#modal_lg').showModal({ url: createUrl, method: 'get' });
	});

	$body.on('click', '#btn_delete_event', function () {
		var deleteUrl = $(this).data('url');
		var title = $(this).data('title');
		mApp.block('#modal_lg', { opacity: 0.3 });

		bootbox.confirm({
			sise: 'md',
			title: 'X\xF3a s\u1EF1 ki\u1EC7n ' + title + ' !!!',
			message: 'Bạn có chắc muốn xóa ?',
			className: 'modal-danger',
			buttons: {
				confirm: {
					label: lang['Yes'],
					className: 'btn-danger m-btn'
				},
				cancel: {
					label: lang['No'],
					className: 'btn-secondary m-btn'
				}
			},
			callback: function callback(confirm) {
				if (confirm) {
					axios.delete(deleteUrl).then(function (result) {
						var obj = result['data'];
						flash(obj.message);
						$('#modal_lg').modal('hide');
						$('#m_calendar').fullCalendar('refetchEvents');
					}).catch(function (err) {
						var response = err.response;
						var msg = response.data.message;
						if (msg === '') {
							msg = response.statusText;
						}
						console.error(err.response);
						flash(msg, 'danger', false);
					}).finally(function () {
						mApp.unblock('#modal_lg');
					});
				} else {
					mApp.unblock('#modal_lg');
				}
			}
		});
	});

	$body.on('submit', '#events_form', function (e) {
		var url = $(this).prop('action');

		var formData = new FormData($(this)[0]);

		$(this).submitForm(url, formData).then(function () {
			$('#modal_lg').modal('hide');
			$('#m_calendar').fullCalendar('refetchEvents');
		});

		e.preventDefault();
	});

	$('#modal_lg').on('shown.bs.modal', function () {
		$('.text-datetimepicker').datetimepicker({
			language: 'vi'
		});

		$('.text-colorpicker').minicolors({
			theme: 'bootstrap'
		});
	});

	$('#m_calendar').fullCalendar({
		lang: 'vi',
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay,listWeek'
		},
		editable: !1,
		eventLimit: !0,
		navLinks: !0,
		events: function events(start, end, tz, callback) {
			axios.get(route('events.list'), {
				params: {
					start: start.unix(),
					end: end.unix(),
					limit: 50
				}
			}).then(function (result) {
				var datas = result.data.items;
				var mappedDatas = _.map(datas, function (elem) {
					elem['className'] = 'm-fc-event--solid-info m-fc-event--light';
					elem['allDay'] = elem['all_day'];
					if (elem['allDay']) {
						elem['end'] = null;
					}
					if (elem['description'] === null) {
						elem['description'] = '';
					}
					return elem;
				});
				callback(mappedDatas);
			});
		},
		eventRender: function eventRender(e, t) {
			t.hasClass('fc-day-grid-event') ? (t.data('content', e.description), t.data('placement', 'top'), mApp.initPopover(t)) : t.hasClass('fc-time-grid-event') ? t.find('.fc-title').append('<div class="fc-description">' + e.description + '</div>') : 0 !== t.find('.fc-list-item-title').lenght && t.find('.fc-list-item-title').append('<div class="fc-description">' + e.description + '</div>');
		},
		eventClick: function eventClick(event) {
			var eventId = event.id;
			var editUrl = '/department/events/' + eventId + '/edit';
			$('#modal_lg').showModal({ url: editUrl, method: 'get' });
		}
		//todo: thêm chức năng chuyển ngày event = event drop
		// eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
		// 	log.info(event)
		// 	log.info(dayDelta)
		// },
	});
});

/***/ })

/******/ });