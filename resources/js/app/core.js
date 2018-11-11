/* eslint-disable no-undef,no-console */
'use strict'
let cloudTeamCore = (function($, lang) {
	const handleModal = function() {
		// fix stackable modal issue: when 2 or more modals opened, closing one of modal will remove .modal-open class.
		$(document).on('hidden.bs.modal', function() {
			if ($('.modal:visible').length) {
				$('body').addClass('modal-open')
			}
		})

		// fix page scrollbars issue
		$(document).on('show.bs.modal', '.modal', function() {
			if ($(this).hasClass('modal-scroll')) {
				$('body').addClass('modal-open-noscroll')
			}
		})

		// fix page scrollbars issue
		$(document).on('hidden.bs.modal', '.modal', function() {
			$('body').removeClass('modal-open-noscroll')
		})

		// remove ajax content and remove cache on modal closed
		$(document).on('hidden.bs.modal', '.modal:not(.modal-cached)', function() {
			$(this).removeData('bs.modal')
		})
	}

	const handleSelect2 = function() {
		if (typeof $.fn.select2 === 'function') {
			let language = $('html').attr('lang')
			let chooseText = lang['Choose']
			//Select2 default config
			$.extend(true, $.fn.select2.defaults.defaults, {
				width: '100%',
				allowClear: true,
				placeholder: chooseText,
				language: language,
			})
			$('.select').select2()
		}
	}

	const handleDatepicker = function() {
		let i18nObject = {
			days: [
				'Chủ nhật',
				'Thứ hai',
				'Thứ ba',
				'Thứ tư',
				'Thứ năm',
				'Thứ sáu',
				'Thứ bảy'],
			daysShort: [
				'CN',
				'Thứ 2',
				'Thứ 3',
				'Thứ 4',
				'Thứ 5',
				'Thứ 6',
				'Thứ 7'],
			daysMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
			months: [
				'Tháng 1',
				'Tháng 2',
				'Tháng 3',
				'Tháng 4',
				'Tháng 5',
				'Tháng 6',
				'Tháng 7',
				'Tháng 8',
				'Tháng 9',
				'Tháng 10',
				'Tháng 11',
				'Tháng 12'],
			monthsShort: [
				'Th1',
				'Th2',
				'Th3',
				'Th4',
				'Th5',
				'Th6',
				'Th7',
				'Th8',
				'Th9',
				'Th10',
				'Th11',
				'Th12'],
			meridiem: '',
			today: 'Hôm nay',
			clear: 'Xóa',
		}
		let language = $('html').attr('lang')

		if (typeof $.fn.datepicker === 'function') {
			$.extend(true, $.fn.datepicker.defaults, {
				format: 'dd-mm-yyyy',
				autoclose: true,
				orientation: 'bottom left',
				todayHighlight: true,
				language: language,
				todayBtn: true,
				// clearBtn: true
			})
			$.fn.datepicker.dates['vi'] = i18nObject

			$('.text-datepicker, .input-group.date').datepicker()
		}

		if (typeof $.fn.datetimepicker === 'function') {
			$.extend(true, $.fn.datetimepicker.defaults, {
				format: 'dd-mm-yyyy hh:ii:ss',
				autoclose: true,
				orientation: 'bottom left',
				todayHighlight: true,
				language: language,
				todayBtn: true,
				forceParse: false,
				// clearBtn: true
			})
			$.fn.datetimepicker.dates['vi'] = i18nObject

			$('.text-dateptimeicker, .input-group.datetime').datetimepicker()
		}
	}

	const handleAlphanum = function() {
		// noinspection JSUnresolvedVariable
		if (typeof $.fn.alphanum === 'function') {
			//input có class alphanum chỉ được nhập chữ và số
			$('.alphanum').alphanum({
				allow: '-_,./%#@()*',
			})
			$('.email, .username').alphanum({
				allow: '@.-_',
			})
			$('.numeric').numeric({
				allow: '.',
				allowMinus: false,
			})
			$('.phone-number').alphanum({
				allowMinus: false,
				allowLatin: false,
				allowOtherCharSets: false,
				maxLength: 11
			})
			$('.string').alpha()
		}
	}

	const handleBootbox = function() {
		if (typeof bootbox === 'object') {
			let language = $('html').attr('lang')
			//Bootbox default config
			bootbox.setDefaults({
				locale: language,
				show: true,
				backdrop: true,
				closeButton: true,
				animate: true,
			})
		}
	}

	const handleAjax = function() {
		$(document).ajaxComplete(function() {
			unblock()
		})
		$(document).ajaxError(function() {
			unblock()
		})
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			},
		})
	}

	const handleDatatables = function() {
		// noinspection JSUnresolvedVariable
		if (typeof $.fn.dataTable === 'function') {
			let language = $('html').attr('lang')
			let optionLang = {
				'sLengthMenu': 'Display <select class="m_selectpicker m-bootstrap-select--air" data-width="85px">' +
					'<option value="10">10</option>' +
					'<option value="20">20</option>' +
					'<option value="30">30</option>' +
					'<option value="40">40</option>' +
					'<option value="50">50</option>' +
					'<option value="-1">All</option>' +
					'</select> records',
				'sSearch': 'Search:',
				'oPaginate': {
					'sFirst': '<i class="la la la-angle-double-left"></i>',
					'sPrevious': '<i class="la la-angle-left"></i>',
					'sNext': '<i class="la la-angle-right"></i>',
					'sLast': '<i class="la la la-angle-double-right"></i>',
				},
				'sEmptyTable': 'No data available',
				'sProcessing': 'Loading...',
				'sZeroRecords': 'No matching records found',
				'sInfo': 'Showing _START_ to _END_ of _TOTAL_ entries',
				'sInfoEmpty': 'Showing 0 to 0 of 0 entries',
				'sInfoFiltered': '(filtered from _MAX_ total entries)',
				'sInfoPostFix': '',
				'sUrl': '',
			}
			if (language === 'vi') {
				optionLang = {
					'sEmptyTable': 'Không có dữ liệu',
					'sProcessing': 'Đang xử lý...',
					'sLengthMenu': 'Xem <select class="m_selectpicker m-bootstrap-select--air" data-width="85px">' +
						'<option value="10">10</option>' +
						'<option value="20">20</option>' +
						'<option value="30">30</option>' +
						'<option value="40">40</option>' +
						'<option value="50">50</option>' +
						'<option value="-1">All</option>' +
						'</select> dòng',
					'sZeroRecords': 'Không tìm thấy dữ liệu phù hợp',
					'sInfo': 'Đang xem _START_ đến _END_ trên _TOTAL_ mục',
					'sInfoEmpty': 'Đang xem 0 đến 0 trong tổng số 0 mục',
					'sInfoFiltered': '(được lọc từ _MAX_ dòng)',
					'sInfoPostFix': '',
					'sSearch': 'Tìm:',
					'sUrl': '',
					'oPaginate': {
						'sFirst': '<i class="fa fa-angle-double-left"></i>',
						'sPrevious': '<i class="fa fa-angle-left"></i>',
						'sNext': '<i class="fa fa-angle-right"></i>',
						'sLast': '<i class="fa fa-angle-double-right"></i>',
					},
				}
			}

			// noinspection JSUnresolvedVariable
			$.extend(true, $.fn.dataTable.defaults, {
				'oLanguage': optionLang,
				'lengthChange': false,
				'info': false,
				'searching': false,
				'columnDefs': [
					{
						'targets': [0],
						'searchable': false,
						'sortable': false,
						'orderable': false,
						'visible': true,
						'width': '5%',
						'className': 'dt-center',
					},
					{
						'targets': [-1],
						'searchable': false,
						'orderable': false,
						'visible': true,
						'width': '10%',
					},
				],
				'dom': 'rt<"bottom"flip>',
				'order': [],
				'iDisplayLength': 10,
				'autoWidth': true,
				'processing': false,
				'paging': false,
				'searchDelay': 500,
				'pagingType': 'full_numbers',
				'responsive': true,
				buttons: ['excelHtml5', 'pdfHtml5'],
			})

			//Datatable Pipleline
			// noinspection JSUnresolvedVariable
			$.fn.dataTable.pipeline = function(opts) {
				// Configuration options
				const conf = $.extend({
					pages: 5, // number of pages to cache
					url: '', // script url
					data: null, // function or object with parameters to send to the server
					// matching how `ajax.data` works in DataTables
					method: 'POST', // Ajax HTTP method
				}, opts)
				// Private variables for storing the cache
				let cacheLower = -1
				let cacheUpper = null
				let cacheLastRequest = null
				let cacheLastJson = null
				return function(request, drawCallback, settings) {
					let ajax = false
					let requestStart = request.start
					const drawStart = request.start
					let requestLength = request.length
					if (requestLength < 0) {
						requestLength = 50
					}
					const requestEnd = requestStart + requestLength
					if (settings.clearCache) {
						// API requested that the cache be cleared
						ajax = true
						settings.clearCache = false
					} else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
						// outside cached data - need to make a request
						ajax = true
					} else if (JSON.stringify(request.order) !==
						JSON.stringify(cacheLastRequest.order) || JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
						JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
					) {
						// properties changed (ordering, columns, searching)
						ajax = true
					}
					// Store the request for checking next time around
					cacheLastRequest = $.extend(true, {}, request)
					if (ajax) {
						// Need data from the server
						if (requestStart < cacheLower) {
							requestStart = requestStart - (requestLength * (conf.pages - 1))
							if (requestStart < 0) {
								requestStart = 0
							}
						}
						cacheLower = requestStart
						cacheUpper = requestStart + (requestLength * conf.pages)
						request.start = requestStart
						request.length = requestLength * conf.pages
						// Provide the same `data` options as DataTables.
						if (typeof conf.data === 'function') {
							// As a function it is executed with the data object as an arg
							// for manipulation. If an object is returned, it is used as the
							// data object to submit
							const d = conf.data(request)
							if (d) {
								$.extend(request, d)
							}
						} else if ($.isPlainObject(conf.data)) {
							// As an object, the data given extends the default
							$.extend(request, conf.data)
						}
						settings.jqXHR = $.ajax({
							'type': conf.method,
							'url': conf.url,
							'data': request,
							'dataType': 'json',
							'cache': false,
							'success': function(json) {
								cacheLastJson = $.extend(true, {}, json)
								// noinspection EqualityComparisonWithCoercionJS
								if (cacheLower != drawStart) {
									json.data.splice(0, drawStart - cacheLower)
								}
								if (requestLength > -1) {
									json.data.splice(requestLength, json.data.length)
								}
								drawCallback(json)
							},
							'error': function(jqXHR) {
								let errorMsg = null
								let errorTitle = lang['Error']
								let status = jqXHR.status
								if (status === 419) {
									errorMsg = lang['Login session has expired. Please log in again.']
								}
								if (status === 500) {
									errorMsg = lang['Whoops, something went wrong on our servers.']
								}

								if (errorMsg) {
									swal({
										title: errorTitle,
										text: errorMsg,
										type: 'error',
										confirmButtonClass: 'btn btn-brand m-btn--custom',
										confirmButtonText: 'OK',
									}).then(() => {
										if (status === 419) {
											location.reload()
										}
									})
								}
							}
						})
					} else {
						let json = $.extend(true, {}, cacheLastJson)
						json.draw = request.draw // Update the echo for each response
						json.data.splice(0, requestStart - cacheLower)
						json.data.splice(requestLength, json.data.length)
						drawCallback(json)
					}
				}
			}

			//Datatable clear Pipleline
			// noinspection JSUnresolvedVariable
			$.fn.dataTable.Api.register('clearPipeline()', function() {
				blockPage()
				return this.iterator('table', function(settings) {
					settings.clearCache = true
				})
			})

			// noinspection JSUnresolvedVariable
			$.fn.dataTable.Api.register('reload()', function() {
				return this.clearPipeline().draw()
			})

			// noinspection JSUnresolvedVariable
			$.fn.dataTable.Api.register('exportExcel()', function() {
				return this.buttons(0).trigger()
			})

			// noinspection JSUnresolvedVariable
			$.fn.dataTable.Api.register('exportPdf()', function() {
				return this.buttons(1).trigger()
			})

			// noinspection JSUnresolvedVariable
			$.fn.dataTable.Api.register('actionDelete()',
				function({btnDelete, message = lang['Do you want to continue?'], title = lang['Delete data !!!'], size = 'medium', params = {}} = {}) {
					let table = this
					let url = btnDelete.data('url')
					let checkbox = btnDelete.parents('tr').find('.m-checkbox--single > [type="checkbox"]')
					let deleteTitle = btnDelete.data('title')
					if (deleteTitle === undefined) {
						deleteTitle = title
					}

					checkbox.prop('checked', 'checked')
					blockPage()
					btnDelete.confirmation(function(confirm) {
						if (confirm && (typeof confirm === 'object' && confirm.value)) {
							axios.delete(url, {data: params}).then(result => {
								let obj = result['data']
								flash(obj.message)
								table.reload()
							}).catch(ajaxErrorHandler).finally(() => {
								unblock()
							})
						} else {
							unblock()
						}
						checkbox.prop('checked', '')
					}, {confirmType: 'swal', title: deleteTitle, type: 'error', text: message})
				})

			// noinspection JSUnresolvedVariable
			$.fn.dataTable.Api.register('actionEdit()',
				function({btnEdit, redirectTo, params = {}, message = lang['Do you want to continue?'], title = lang['Edit data !!!']} = {}) {
					let table = this
					let url = btnEdit.data('url')
					let checkbox = btnEdit.parents('tr').find('.m-checkbox--single > [type="checkbox"]')
					let editTitle = btnEdit.data('title')
					if (editTitle === undefined) {
						editTitle = title
					}

					checkbox.prop('checked', 'checked')
					blockPage()
					btnEdit.confirmation(function(confirm) {
						if (confirm && (typeof confirm === 'object' && confirm.value)) {
							axios.post(url, params).then(result => {
								let obj = result['data']
								flash(obj.message)
								if (redirectTo !== undefined && redirectTo !== '') {
									location.href = redirectTo
								}
								table.reload()
							}).catch(ajaxErrorHandler).finally(() => {
								unblock()
							})
						} else {
							unblock()
						}
						checkbox.prop('checked', '')
					}, {confirmType: 'swal', title: editTitle, type: 'warning', text: message})
				})

			/**
			 * Update original input/select on change in child row
			 */
			$.fn.dataTable.Api.register('updateChildRow()', function() {
				let self = this
				const tableSelector = self.context[0].sTableId
				// Update original input/select on change in child row
				$(`#${tableSelector} tbody`).on('keyup change', '.child input, .child select, .child textarea', function() {
					const $el = $(this)
					const rowIdx = $el.closest('ul').data('dtr-index')
					const colIdx = $el.closest('li').data('dtr-index')
					const cell = self.cell({row: rowIdx, column: colIdx}).node()

					$('input, select, textarea', cell).val($el.val())
					if ($el.is(':checked')) {
						$('input', cell).prop('checked', true)
					} else {
						$('input', cell).removeProp('checked')
					}
				})
			})

			//conditionalPaging
			$(document).on('init.dt', function(e, dtSettings) {
				$('.m_selectpicker').selectpicker()

				if (e.namespace !== 'dt') {
					return
				}

				// noinspection JSUnresolvedVariable
				const options = dtSettings.oInit.conditionalPaging

				if ($.isPlainObject(options) || options === true) {
					// noinspection JSUnresolvedVariable
					const config = $.isPlainObject(options) ? options : {},
						api = new $.fn.dataTable.Api(dtSettings)
					let speed = 'slow'
					const conditionalPaging = function(e) {
						const $paging = $(api.table().container()).
								find('div.dataTables_paginate'),
							pages = api.page.info().pages

						if (e instanceof $.Event) {
							if (pages <= 1) {
								if (config.style === 'fade') {
									$paging.stop().fadeTo(speed, 0)
								}
								else {
									$paging.css('visibility', 'hidden')
								}
							}
							else {
								if (config.style === 'fade') {
									$paging.stop().fadeTo(speed, 1)
								}
								else {
									$paging.css('visibility', '')
								}
							}
						}
						else if (pages <= 1) {
							if (config.style === 'fade') {
								$paging.css('opacity', 0)
							}
							else {
								$paging.css('visibility', 'hidden')
							}
						}
					}

					if ($.isNumeric(config.speed) || $.type(config.speed) ===
						'string') {
						speed = config.speed
					}

					conditionalPaging()

					api.on('draw.dt', conditionalPaging)
				}
			})

			$(document).on('preXhr.dt', function() {
				blockPage()
			})

			$(document).on('xhr.dt', function() {
				unblock()
			})

			const $datatables = $('.datatables')
			if ($datatables.length > 0) {
				$datatables.DataTable({
					'columnDefs': [
						{
							'targets': '_all',
							'searchable': true,
							'orderable': true,
							'visible': true,
						},
					],
					// 'sort': false,
				})
			}
		}
	}

	const handleInput = function() {
		//event cho nút check all & single ở table
		$(document).on('click', '.m-checkbox--all > [type="checkbox"]', function() {
			let cbSingle = $('.m-checkbox--single > [type="checkbox"]')
			if (!$(this).is(':checked')) {
				cbSingle.prop('checked', '')
			} else {
				cbSingle.prop('checked', 'checked')
			}
		})
		//event cho nút check từng dòng ở table
		$(document).on('click', '.m-checkbox--single > [type="checkbox"]', function() {
			let cbSingle = $('.m-checkbox--single > [type="checkbox"]')
			let cbAll = $('.m-checkbox--all > [type="checkbox"]')
			if ($(this).is(':checked')) {
				let cbSingleChecked = $('.m-checkbox--single > [type="checkbox"]:checked')
				if (cbSingle.length === cbSingleChecked.length) {
					cbAll.prop('checked', 'checked')
				} else {
					cbAll.prop('checked', '')
				}
			} else {
				cbAll.prop('checked', '')
			}
		})
		//Set select text cho thẻ input focus
		// noinspection JSCheckFunctionSignatures
		$('input, textarea').focus(function() {
			$(this).select()
		})
	}

	const handleValidation = function() {
		let language = $('html').attr('lang')
		if (language === 'vi') {
			$.extend($.validator.messages, {
				required: 'Hãy nhập giá trị.',
				remote: 'Hãy sửa cho đúng.',
				email: 'Hãy nhập email.',
				url: 'Hãy nhập URL.',
				date: 'Hãy nhập ngày.',
				dateISO: 'Hãy nhập ngày (ISO).',
				number: 'Hãy nhập số.',
				digits: 'Hãy nhập chữ số.',
				creditcard: 'Hãy nhập số thẻ tín dụng.',
				equalTo: 'Hãy nhập giống thêm lần nữa.',
				extension: 'Phần mở rộng không đúng.',
				maxlength: $.validator.format('Hãy nhập từ {0} kí tự trở xuống.'),
				minlength: $.validator.format('Hãy nhập từ {0} kí tự trở lên.'),
				rangelength: $.validator.format('Hãy nhập từ {0} đến {1} kí tự.'),
				range: $.validator.format('Hãy nhập từ {0} đến {1}.'),
				max: $.validator.format('Hãy nhập từ {0} trở xuống.'),
				min: $.validator.format('Hãy nhập từ {0} trở lên.'),
			})
		}

		$.validator.addMethod('greaterThan', function(value, element, params) {
			if ($(params[0]).val() !== '' && value !== '') {
				let isTime = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])?$/.test(
					value)

				if (isTime) {
					let beginningTime = moment($(params[0]).val(), 'h:mm')
					let endTime = moment(value, 'h:mm')

					return beginningTime.isBefore(endTime)
				} else {
					// noinspection JSCheckFunctionSignatures
					if (!/Invalid|NaN/.test(new Date(value))) {
						return new Date(value) >
							new Date($(params[0]).val())
					} else {
						return (Number(value) > Number($(params[0]).val()))
					}
				}
			}

			return true
		}, '{1} phải lớn hơn {2}.')

		$.validator.addMethod('pwCheck', function(value) {
			return /^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/.test(value) // consists of only these
		}, 'Mật khẩu phải gồm ít nhất 8 kí tự bao gồm kí tự thường, kí tự hoa, số (VD: Cloudteam123)')

		$.validator.setDefaults({
			showErrors: function() {
				let numberOfInvalids = this.numberOfInvalids()
				let msg = numberOfInvalids + lang[' field(s) are invalid']
				if (numberOfInvalids > 0) {
					flash(msg, 'danger', false)
				} else {
					window.events.$emit('hide')
				}
				this.defaultShowErrors()
			},
		})
	}

	const handleHighcharts = function() {
		if (typeof Highcharts === 'object') {
			const options = {
				chart: {
					style: {
						fontFamily: 'Montserrat',
						fontWeight: 'bold',
					},
				},
				credits: {
					enabled: false,
				},
			}

			Highcharts.setOptions(options)
		}
	}

	const handleToastr = function() {
		if (typeof toastr === 'object') {
			let opts = {
				'closeButton': true,
				'debug': false,
				'positionClass': 'toast-top-right',
				'newestOnTop': true,
				'onclick': null,
				'showDuration': '1000',
				'hideDuration': '1000',
				'timeOut': '5000',
				'extendedTimeOut': '1000',
				'showEasing': 'swing',
				'hideEasing': 'linear',
				'showMethod': 'fadeIn',
				'hideMethod': 'fadeOut',
			}
			$.fn.toast = function(options) {
				if (options.hasOwnProperty('content')) {
					let content = options.content
					if (options.type === 'success') {
						toastr.success(content, options.title, opts)
					} else if (options.type === 'error') {
						toastr.error(content, options.title, opts)
					} else if (options.type === 'warning') {
						toastr.warning(content, options.title, opts)
					}
				} else {
					let content
					if (options.type === 'success') {
						content = lang['Success']
						toastr.success(content, options.title, opts)
					} else if (options.type === 'error') {
						content = lang['Fail']
						toastr.error(content, options.title, opts)
					} else if (options.type === 'warning') {
						content = lang['Warning']
						toastr.warning(content, options.title, opts)
					}
				}
			}
		}
	}

	const handlePluginJquery = function() {
		/**
		 * Tạo mảng giá trị từ nhiều input cùng class
		 * @param attribute (optional): tên của data attribute
		 * @param parse (optional): parse dữ liệu (int hoặc float)
		 * @return array
		 */
		$.fn.getValues = function({attribute, parse} = {}) {
			if (attribute !== undefined) {
				if (parse !== undefined) {
					if (parse === 'int') {
						return _.map($(this), (elem) => {
							return parseInt($(elem).attr(`data-${attribute}`))
						})
					} else if (parse === 'float') {
						return _.map($(this), (elem) => {
							return parseFloat($(elem).attr(`data-${attribute}`))
						})
					}
				} else {
					return _.map($(this), (elem) => {
						return $(elem).attr(`data-${attribute}`)
					})
				}
			}
			if (parse !== undefined) {
				if (parse === 'int') {
					return _.map($(this), (elem) => {
						return parseInt($(elem).val())
					})
				} else if (parse === 'float') {
					return _.map($(this), (elem) => {
						return parseFloat($(elem).val())
					})
				}
			}

			return _.map($(this), (elem) => {
				return $(elem).val()
			})
		}

		/**
		 * Lưu form sử dụng Form data
		 * @param url
		 * @param formData
		 * @param data: custom data
		 * @param returnEarly: return promise without handle by default
		 * @param method
		 * @return Promise
		 */
		$.fn.submitForm = function({url, formData, data, returnEarly, method = 'post'} = {}) {
			blockPage()
			if (formData === undefined) {
				formData = new FormData(this[0])
			}
			if (url === undefined) {
				url = $(this).prop('action')
			}
			if (data !== undefined && typeof data === 'object') {
				Object.entries(data).forEach(
					([key, value]) => {
						formData.append(key, value)
					},
				)
			}
			if (returnEarly !== undefined) {
				return axios({
					method: method,
					url: url,
					data: formData,
					config: {headers: {'Content-Type': 'multipart/form-data'}},
				}).catch(ajaxErrorHandler)
			}

			return axios({
				method: method,
				url: url,
				data: formData,
				config: {headers: {'Content-Type': 'multipart/form-data'}},
			}).then((result) => {
				let obj = result['data']
				if (obj.message) {
					flash(obj.message)
				}

				return result['data']
			}).catch(ajaxErrorHandler).finally(() => {
				window.unblock()
			})
		}

		/**
		 * Hiện modal xác nhận hành động
		 * @param callback: hàm xử lý hành động
		 * @param confirmType: thư viện xác nhận
		 * @param text: nội dung
		 * @param title: tiêu đề
		 * @param type: loại modal xác nhận (warning, info, danger)
		 */
		$.fn.confirmation = function(callback, {confirmType = 'swal', text = lang['Do you want to continue?'], title = lang['Confirm action!!!'], type = 'warning'} = {}) {
			let confirmTitle = $(this).data('confirm-title') || title
			let confirmText = $(this).data('confirm-text') || text

			if (confirmType === 'swal') {
				swal({
					title: confirmTitle,
					text: confirmText,
					type: type,
					showCancelButton: true,
					confirmButtonClass: 'btn btn-brand m-btn--custom',
					cancelButtonClass: 'btn btn-secondary m-btn--custom',
					confirmButtonText: lang['Yes'],
					cancelButtonText: lang['No'],
				}).then(callback)
			} else {
				type = type === 'error' ? 'danger' : type
				bootbox.confirm({
					size: 'small',
					text: confirmText,
					title: confirmTitle,
					className: `modal-${type}`,
					buttons: {
						confirm: {
							label: lang['Yes'],
							className: 'btn-danger m-btn',
						},
						cancel: {
							label: lang['No'],
							className: 'btn-secondary m-btn',
						},
					},
					callback: callback,
				})
			}
		}

		/**
		 * Hiện modal với content load ajax
		 * @param url: đường dẫn gọi form modal
		 * @param params: tham số truyền vào request
		 * @param method: phương thức của ajax request
		 * @returns {*}
		 */
		$.fn.showModal = function({url, params = {}, method = 'post'}) {
			blockPage()
			if (method === 'post') {
				axios.post(url, params).then(result => {
					this.find('.modal-content').html(result.data)
					this.modal({
						backdrop: 'static',
					})
				}).catch(ajaxErrorHandler).finally(() => {
					unblock()
				})
			} else {
				axios.get(url, {
					params: params,
				}).then(result => {
					this.find('.modal-content').html(result.data)
					this.modal({
						backdrop: 'static',
					})
				}).catch(ajaxErrorHandler).finally(() => {
					unblock()
				})
			}
		}

		$.fn.setModalMaxHeight = function() {
			let $element = this
			let $content = $element.find('.modal-content')
			let innerHeight = $content.innerHeight()
			let borderWidth = $content.outerHeight() - innerHeight
			let dialogMargin = $(window).width() < 768 ? 20 : 60
			let contentHeight = $(window).height() - (dialogMargin + borderWidth)
			let headerHeight = $element.find('.modal-header').outerHeight() || 0
			let footerHeight = $element.find('.modal-footer').outerHeight() || 0
			let maxHeight = contentHeight - (headerHeight + footerHeight)
			let $scrollableElem = $element.find('.m-scrollable')

			if ($scrollableElem.length !== 0 && typeof mUtil.scrollerInit === 'function' && innerHeight > 700) {
				mUtil.scrollerInit($scrollableElem[0], {
					disableForMobile: false, handleWindowResize: true, height: function() {
						if (mUtil.isInResponsiveRange('tablet-and-mobile')) {
							return `${(maxHeight - 29) / 2}`
						} else {
							return `${maxHeight - 29}`
						}
					},
				})
			} else {
				$content.css({
					'overflow': 'hidden',
				})

				$element.find('.modal-body').css({
					'overflow-y': 'auto',
				})
			}
		}

		/**
		 * Clear form co select2
		 */
		$.fn.resetForm = function() {
			this[0].reset()
			this.find('select').val('').trigger('change')
		}

		//Select2 ajax plugin
		if (typeof $.fn.select2 === 'function') {
			/**
			 * Khai báo sử dụng select2 ajax
			 * @param options
			 * options: {
			 *     url: đường dẫn gọi ajax,
			 *     column: giá tri muốn hiển thị (default là name hoặc code),
			 *     allowClear: thuộc tính clear select (default là true),
			 *     data: function(q): hàm truyền tham số
			 * }
			 * @returns {*|void}
			 */
			$.fn.select2Ajax = function(options = {}) {
				let url = $(this).data('url')
				let col = $(this).data('column')

				let column = options.hasOwnProperty('column') ? options.column : ''
				let finalUrl = url || options.url
				column = column || col

				let settings = {
					ajax: {
						url: finalUrl,
						dataType: 'json',
						delay: 50,
						data: function(params) {
							let paramFinal = {
								query: params.term, // search term
								page: params.page,
							}
							if (typeof options.data === 'function') {
								options.data(params)
								$.extend(paramFinal, params)
							}
							return paramFinal
						},
						processResults: function(data, params) {
							params.page = params.page || 1
							// noinspection JSUnresolvedVariable
							return {
								results: data.items,
								pagination: {
									more: (params.page * 10) <= data.total_count,
								},
							}
						},
						cache: true,
					},
					escapeMarkup: markup => markup,
					allowClear: options.allowClear !== undefined ? options.allowClear : true,
					minimumInputLength: options.hasOwnProperty('minimumInputLength') ? options.minimumInputLength : 0,
					templateResult: options.hasOwnProperty('templateResult') ? options.templateResult : function(repo) {
						if (repo.loading) return repo.text
						if (typeof repo['name'] !== 'undefined') {
							return `<div class="select2-result-repository clearfix"><div class="select2-result-repository__title"> ${repo['name']} </div>`
						}
						if (typeof repo['code'] !== 'undefined') {
							return `<div class="select2-result-repository clearfix"><div class="select2-result-repository__title"> ${repo['code']} </div>`
						}
						let column = options.hasOwnProperty('column') ? options.column : ''
						if (column !== '' && typeof repo[column] !== 'undefined') {
							return `<div class="select2-result-repository clearfix"><div class="select2-result-repository__title"> ${repo[column]} </div>`
						}
					},
					templateSelection: options.hasOwnProperty('templateSelection') ? options.templateSelection : function(repo) {
						let val = repo.text
						if (typeof repo.name !== 'undefined') {
							val = repo['name']
						} else if (typeof repo.code !== 'undefined') {
							val = repo['code']
						} else if (column !== '' && typeof repo[column] !== 'undefined') {
							val = repo[column]
						}
						return val
					},
				}
				return this.select2(settings)
			}

			const $select2Ajax = $('.select2-ajax')
			if ($select2Ajax.length > 0) {
				$select2Ajax.each(function() {
					$(this).select2Ajax()
				})
			}
		}
	}

	const handleMomentJs = function() {
		moment.defineLocale('vi', {
			months: 'tháng 1_tháng 2_tháng 3_tháng 4_tháng 5_tháng 6_tháng 7_tháng 8_tháng 9_tháng 10_tháng 11_tháng 12'.split('_'),
			monthsShort: 'Th01_Th02_Th03_Th04_Th05_Th06_Th07_Th08_Th09_Th10_Th11_Th12'.split('_'),
			monthsParseExact: true,
			weekdays: 'chủ nhật_thứ hai_thứ ba_thứ tư_thứ năm_thứ sáu_thứ bảy'.split('_'),
			weekdaysShort: 'CN_T2_T3_T4_T5_T6_T7'.split('_'),
			weekdaysMin: 'CN_T2_T3_T4_T5_T6_T7'.split('_'),
			weekdaysParseExact: true,
			meridiemParse: /sa|ch/i,
			isPM: function(input) {
				return /^ch$/i.test(input)
			},
			meridiem: function(hours, minutes, isLower) {
				if (hours < 12) {
					return isLower ? 'sa' : 'SA'
				} else {
					return isLower ? 'ch' : 'CH'
				}
			},
			longDateFormat: {
				LT: 'HH:mm',
				LTS: 'HH:mm:ss',
				L: 'DD/MM/YYYY',
				LL: 'D MMMM [năm] YYYY',
				LLL: 'D MMMM [năm] YYYY HH:mm',
				LLLL: 'dddd, D MMMM [năm] YYYY HH:mm',
				l: 'DD/M/YYYY',
				ll: 'D MMM YYYY',
				lll: 'D MMM YYYY HH:mm',
				llll: 'ddd, D MMM YYYY HH:mm',
			},
			calendar: {
				sameDay: '[Hôm nay lúc] LT',
				nextDay: '[Ngày mai lúc] LT',
				nextWeek: 'dddd [tuần tới lúc] LT',
				lastDay: '[Hôm qua lúc] LT',
				lastWeek: 'dddd [tuần rồi lúc] LT',
				sameElse: 'L',
			},
			relativeTime: {
				future: '%s tới',
				past: '%s trước',
				s: 'vài giây',
				ss: '%d giây',
				m: 'một phút',
				mm: '%d phút',
				h: 'một giờ',
				hh: '%d giờ',
				d: 'một ngày',
				dd: '%d ngày',
				M: 'một tháng',
				MM: '%d tháng',
				y: 'một năm',
				yy: '%d năm',
			},
			dayOfMonthOrdinalParse: /\d{1,2}/,
			ordinal: function(number) {
				return number
			},
			week: {
				dow: 1, // Monday is the first day of the week.
				doy: 4, // The week that contains Jan 4th is the first week of the year.
			},
		})
	}

	const ajaxErrorHandler = function(err) {
		let response = err.response
		if (response === undefined) {
			console.error(err)
		} else {
			console.log(response)
			let msg = ''
			let errors = response.data.errors

			if (errors !== undefined) {
				msg = '<ul>'
				Object.entries(errors).forEach(
					([key, values]) => {
						for (let value of values) {
							msg += `<li>${value}</li>`
						}
					},
				)
				msg += '</ul>'
			} else {
				msg = response.data.message
			}

			if (msg === '') {
				msg = response.statusText
			}

			flash(msg, 'danger', false)
		}
		mUtil.scrollTop()
	}

	// const handleTimepicker = function () {
	// 	if (typeof $.fn.timepicker === "function") {
	// 		$.extend(true, $.fn.timepicker.defaults, {
	// 			showMeridian: false,
	// 			explicitMode: true
	// 			// defaultTime: '00:00',
	// 			// defaultTime: false
	// 		})
	// 		$(".timepicker, .input-group.time").timepicker()
	// 	}
	// }

	return {
		init() {
			handleModal()
			handleSelect2()
			handleDatepicker()
			handleAlphanum()
			handleBootbox()
			handleAjax()
			handleInput()
			handleValidation()
			handleDatatables()
			handleHighcharts()
			handlePluginJquery()
			handleMomentJs()

			// note: optional plugin
			handleToastr()
			// handleTimepicker()
		},
	}
})(jQuery, lang)

module.exports = cloudTeamCore