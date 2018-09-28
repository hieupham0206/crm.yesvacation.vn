let page = 0
mUtil.scrollerInit($('#activity_log_container.m-scrollable')[0], {disableForMobile: false, resetHeightOnDestroy: true, handleWindowResize: true, height: 200})
$('#activity_log_container.m-scrollable').on('ps-y-reach-end', function() {
	let url = route('activity_logs.get_more_logs')
	mApp.block('#topbar_notifications_logs', {opacity: 0})
	axios.get(url, {
		params: {
			page: page,
		},
	}).then(result => {
		page++
		let datas = result.data.datas
		let isEmpty = result.data.isEmpty
		let items = ''
		for (let log of datas) {
			items += `<div class="m-list-timeline__item"><span class="m-list-timeline__badge"></span> <a href="" class="m-list-timeline__text">
                        ${log.description}
                    </a> <span class="m-list-timeline__time">
                        ${moment(log.created_at).fromNow()}
                    </span></div>`
		}

		$(this).find('.m-list-timeline__items').append(items)

		if (isEmpty) {
			$(this).off('ps-y-reach-end')
		}
	}).finally(() => {
		mApp.unblock('#topbar_notifications_logs')
	})
})