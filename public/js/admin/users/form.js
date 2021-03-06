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

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

$(function () {
	var $usersForm = $('#users_form');
	var isConfirm = $usersForm.data('confirm');

	$usersForm.validate({
		// define validation rules
		rules: {
			password: {
				required: function required(element) {
					var val = $(element).data('value');
					return val === '';
				},
				pwCheck: function pwCheck(element) {
					var val = $(element).data('value');
					return val === '';
				}
			},
			password_confirmation: {
				required: function required() {
					return $('#txt_password').val() !== '';
				},
				equalTo: '#txt_password'
			}
		},
		submitHandler: isConfirm && function (form, e) {
			window.blockPage();
			e.preventDefault();
			$(form).confirmation(function (result) {
				if (result && (typeof result === 'undefined' ? 'undefined' : _typeof(result)) === 'object' && result.value) {
					$(form).submitForm({
						data: {
							'isConfirm': isConfirm
						}
					}).then(function () {
						location.href = route('users.index');
					});
				} else {
					window.unblock();
				}
			});
		}
	});

	$('.chk_all_permission').on('click', function () {
		if ($(this).is(':checked')) {
			$(this).parents('tr').find('.chk_permission').prop('checked', true);
		} else {
			$(this).parents('tr').find('.chk_permission').prop('checked', false);
		}
	});
	$('.chk_permission').on('click', function () {
		var tr = $(this).parents('tr');
		if (tr.find('.chk_permission:checked').length >= tr.find('.chk_permission').length) {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', true);
		} else {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', false);
		}
	});

	//Check trang edit
	$('.chk_all_permission').each(function () {
		var tr = $(this).parents('tr');
		if (tr.find('.chk_permission:checked').length >= tr.find('.chk_permission').length) {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', true);
		} else {
			$(this).parents('tr').find('.chk_all_permission').prop('checked', false);
		}
	});
});

/***/ })

/******/ });