$(function() {
	$('#btn_resend_otp').on('click', function() {
		let url = $(this).data('url')

		blockPage()
		axios.post(url).then(result => {
			let obj = result['data']
			flash(obj.message)
		}).catch(err => {
			let response = err.response
			if (response === undefined || response.data === undefined) {
				console.error(err)
			} else {
				let msg = response.data.message
				if (msg === '') {
					msg = response.statusText
				}

				flash(msg, 'danger', false)
			}
			mUtil.scrollTop()
		}).finally(() => {
			unblock()
		})
	})
})