$(function() {
	let $body = $('body')

	$body.on('click', '#btn_create', function() {
		let createUrl = $(this).data('url')
		$('#modal_lg').showModal({url: createUrl, method: 'get'})
	})

	$body.on('click', '#btn_delete_event', function() {
		let deleteUrl = $(this).data('url')
		let title = $(this).data('title')
		mApp.block('#modal_lg', {opacity: 0.3})

		bootbox.confirm({
			sise: 'md',
			title: `Xóa sự kiện ${title} !!!`,
			message: 'Bạn có chắc muốn xóa ?',
			className: 'modal-danger',
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
			callback: function(confirm) {
				if (confirm) {
					axios.delete(deleteUrl).then(result => {
						let obj = result['data']
						flash(obj.message)
						$('#modal_lg').modal('hide')
						$('#m_calendar').fullCalendar('refetchEvents')
					}).catch(err => {
						let response = err.response
						let msg = response.data.message
						if (msg === '') {
							msg = response.statusText
						}
						console.error(err.response)
						flash(msg, 'danger', false)
					}).finally(function() {
						mApp.unblock('#modal_lg')
					})
				} else {
					mApp.unblock('#modal_lg')
				}
			},
		})
	})

	$body.on('submit', '#events_form', function(e) {
		let url = $(this).prop('action')

		let formData = new FormData($(this)[0])

		$(this).submitForm(url, formData).then(function() {
			$('#modal_lg').modal('hide')
			$('#m_calendar').fullCalendar('refetchEvents')
		})

		e.preventDefault()
	})

	$('#modal_lg').on('shown.bs.modal', function() {
		$('.text-datetimepicker').datetimepicker({
			language: 'vi',
		})

		$('.text-colorpicker').minicolors({
			theme: 'bootstrap',
		})
	})

	$('#m_calendar').fullCalendar({
		lang: 'vi',
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay,listWeek',
		},
		editable: !1,
		eventLimit: !0,
		navLinks: !0,
		events: function(start, end, tz, callback) {
			axios.get(route('events.list'), {
				params: {
					start: start.unix(),
					end: end.unix(),
					limit: 50,
				},
			}).then(function(result) {
				let datas = result.data.items
				let mappedDatas = _.map(datas, function(elem) {
					elem['className'] = 'm-fc-event--solid-info m-fc-event--light'
					elem['allDay'] = elem['all_day']
					if (elem['allDay']) {
						elem['end'] = null
					}
					if (elem['description'] === null) {
						elem['description'] = ''
					}
					return elem
				})
				callback(mappedDatas)
			})
		},
		eventRender: function(e, t) {
			t.hasClass('fc-day-grid-event') ? (t.data('content', e.description), t.data('placement', 'top'), mApp.initPopover(t)) : t.hasClass(
				'fc-time-grid-event') ? t.find('.fc-title').append('<div class="fc-description">' + e.description + '</div>') : 0 !==
				t.find('.fc-list-item-title').lenght && t.find('.fc-list-item-title').append('<div class="fc-description">' + e.description + '</div>')
		},
		eventClick: function(event) {
			let eventId = event.id
			let editUrl = `/department/events/${eventId}/edit`
			$('#modal_lg').showModal({url: editUrl, method: 'get'})
		},
		//todo: thêm chức năng chuyển ngày event = event drop
		// eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
		// 	log.info(event)
		// 	log.info(dayDelta)
		// },
	})
})