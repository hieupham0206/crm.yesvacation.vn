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
/******/ 	return __webpack_require__(__webpack_require__.s = 79);
/******/ })
/************************************************************************/
/******/ ({

/***/ 79:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(80);


/***/ }),

/***/ 80:
/***/ (function(module, exports) {

$(function () {
	var $body = $('body');
	var tableUrl = $('#table_translation_managers').data('url');

	var tableTranslateManager = $('#table_translation_managers').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: tableUrl,
			data: function data(q) {
				q.filters = JSON.stringify($('#translation_managers_search_form').serializeArray());
			}
		}),
		conditionalPaging: true,
		info: true,
		searching: false,
		lengthChange: true,
		responsive: true,
		'columnDefs': [{
			'targets': [-1],
			'searchable': false,
			'orderable': false,
			'visible': true,
			'width': '10%'
		}]
	});

	$body.on('submit', '#translation_managers_search_form', function () {
		tableTranslateManager.reload();
		return false;
	});
	$body.on('click', '#btn_reset_filter', function () {
		$('#translation_managers_search_form').resetForm();
		tableTranslateManager.reload();
	});
	$body.on('click', '.btn-edit-translation', function () {
		var key = $(this).parent().prev().prev().text();
		var translatedText = $(this).parent().prev().text();
		var url = $(this).data('url');

		$('#modal_lg').showModal({ url: url, params: { key: key, translatedText: translatedText } });
	});
	$body.on('submit', '#form_edit_translation', function (e) {
		mApp.block($(this)[0]);
		var formData = new FormData($(this)[0]);
		var url = $(this).prop('action');

		$('#form_edit_translation').submitForm({ url: url, formData: formData }).then(function () {
			mApp.unblock();
			$('#modal_lg').modal('hide');
			tableTranslateManager.reload();
		});
		e.preventDefault();
	});
});

/***/ })

/******/ });