<template>
    <transition name="fade">
        <div class="m-alert m-alert--air m-alert--square alert alert-dismissible fade show" :class="'alert-' + level" role="alert" v-show="show">
            <button type="button" class="close" aria-label="Close"></button>
            <strong v-html="body"></strong>
        </div>
    </transition>
</template><!--suppress CssUnusedSymbol -->
<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    {
        opacity: 0;
    }
</style>
<script>
	// noinspection JSUnusedGlobalSymbols
	export default {
		props: ['message'],

		data() {
			return {
				body: '',
				level: '',
				show: false,
			}
		},

		created() {
			if (this.message) {
				this.flash(this.message)
			}

			window.events.$on(
				'flash',
				(message, level, hide) => {
					this.flash(message, level, hide)
				},
			)

			window.events.$on('hide', () => {
					this.hide()
				},
			)
		},

		methods: {
			flash(meessage, level = 'success', hide = true) {
				this.level = level
				this.body = meessage
				this.show = true
				if (hide) {
					this.autohide()
				}
			},
			autohide() {
				setTimeout(() => {
					this.show = false
				}, 5000)
			},
			hide() {
				this.show = false
			},
		},
	}
</script>
