$(function() {
	$('#event_form').validate({
		//display error alert on form submit
		invalidHandler: function(event, validator) {
			let msg = validator.errorList.length + lang[' field(s) are invalid']
			flash(msg, 'danger', false)
			mUtil.scrollTop()
		},
	})
})