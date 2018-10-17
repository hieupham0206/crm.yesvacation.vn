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
/******/ 	return __webpack_require__(__webpack_require__.s = 65);
/******/ })
/************************************************************************/
/******/ ({

/***/ 65:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(66);


/***/ }),

/***/ 66:
/***/ (function(module, exports) {

$(function () {
	var $modalLg = $('#modal_lg');
	var $app = $('#app');
	var tableUser = $('#table_users').DataTable({
		'serverSide': true,
		'paging': true,
		'ajax': $.fn.dataTable.pipeline({
			url: route('users.table'),
			data: function data(q) {
				q.filters = JSON.stringify($('#users_search_form').serializeArray());
			}
		}),
		conditionalPaging: true,
		info: true,
		lengthChange: true
	});
	$app.on('click', '.btn-change-status', function () {
		var message = $(this).data('message');
		tableUser.actionEdit({
			btnEdit: $(this),
			params: {
				state: $(this).data('state')
			},
			message: message
		});
	});
	$app.on('submit', '#users_form', function () {
		// noinspection JSCheckFunctionSignatures
		mApp.block('.modal');
		var ids = $('.m-checkbox--single > input[type=\'checkbox\']:checked').getValues().join(',');
		if (ids.length > 0) {
			var url = $(this).prop('action');
			var formData = new FormData($(this)[0]);

			formData.append('ids', ids);

			$(this).submitForm({ url: url, formData: formData, method: 'post' }).then(function () {
				mApp.unblock('.modal');
				tableUser.reload();
				$('#modal_lg').modal('hide');
			});
		}

		return false;
	});
	$app.on('click', '.btn-delete', function () {
		tableUser.actionDelete({
			btnDelete: $(this)
		});
	});
	$modalLg.on('shown.bs.modal', function () {
		$('.select').select2();
	});
	$('#users_search_form').on('submit', function () {
		tableUser.reload();
		return false;
	});
	$('#btn_reset_filter').on('click', function () {
		$('#users_search_form').resetForm();
		tableUser.reload();
	});

	//Export tools
	$('#btn_export_excel').on('click', function () {
		tableUser.exportExcel();
	});
	$('#btn_export_pdf').on('click', function () {
		tableUser.exportPdf();
	});
	//Quick actions
	$('#link_delete_selected_rows').on('click', function () {
		var ids = $('.m-checkbox--single > input[type=\'checkbox\']:checked').getValues();
		if (ids.length > 0) {
			tableUser.actionDelete({
				btnDelete: $(this),
				params: {
					ids: ids
				}
			});
		}
	});
	$('#link_edit_selected_rows').on('click', function () {
		var ids = $('.m-checkbox--single > input[type=\'checkbox\']:checked').getValues();
		if (ids.length > 0) {
			var editUrl = $(this).data('url');

			$modalLg.showModal({ url: editUrl });
		}
	});
});

/***/ })

/******/ });