window.flash = function (message) {
    window.dispatchEvent(new CustomEvent('flash', { detail: { message }, bubbles: true }));
};

export default (initialMessage = '') => ({
    message: '',
    show: false,

    init() {
        if (initialMessage) {
            this.flash(initialMessage);
        }

        window.addEventListener('flash', evt => this.flash(evt.detail.message));
    },

    flash(message) {
        this.message = message;
        this.show = true;

        this.hide();
    },
    hide() {
        setTimeout(() => this.show = false, 3000);
    },
});
