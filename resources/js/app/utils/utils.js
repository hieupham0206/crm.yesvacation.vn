/**
 *
 * @param message
 * @param level
 * @param hide
 */
window.flash = function(message, level, hide) {
	window.events.$emit('flash', message, level, hide)

	mUtil.scrollTop()
}

/**
 * Shortcut block trang
 */
window.blockPage = function() {
	mApp.block('.m-body', {opacity: 0.05})
}

/**
 * Shortcut unblock
 */
window.unblock = function() {
	mApp.unblock('.m-body')
}