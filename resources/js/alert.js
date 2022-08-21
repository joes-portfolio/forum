window.flash = function (message, level = 'success') {
    window.dispatchEvent(new CustomEvent('flash', { detail: { message, level }, bubbles: true }));
};

export default (initialMessage) => ({
    message: '',
    level: '',
    show: false,

    init() {
        if (initialMessage) {
            this.flash(initialMessage.message, initialMessage.level);
        }

        window.addEventListener('flash', evt => this.flash(evt.detail.message, evt.detail.level));
    },

    get isSuccess() {
      return this.level === 'success';
    },
    get isDanger() {
      return this.level === 'danger';
    },
    get isInfo() {
      return this.level === 'info';
    },

    flash(message, level) {
        this.message = message;
        this.level = level;
        this.show = true;

        this.hide();
    },
    hide() {
        setTimeout(() => this.show = false, 3000);
    },
});
