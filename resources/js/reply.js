import axios from 'axios';

export default (reply = null) => ({
    deleted: false,
    editing: false,
    attributes: {},
    body: '',

    init() {
        if (reply) {
            this.attributes = {...reply};
            this.body = this.attributes.body;
        }
    },

    async update() {
        await axios.patch(`/replies/${this.attributes.id}`, {
            body: this.body,
        });

        this.editing = false;
        flash('Your reply was updated.');
    },

    async destroy() {
        try {
            const response = await axios.delete(`/replies/${this.attributes.id}`);
            this.deleted = true;

            this.$nextTick(() => {
                flash(response.data.message);
                this.$root.remove();
            });
        } catch (e) {
            flash(e.response.data.message);
        }
    }
});
