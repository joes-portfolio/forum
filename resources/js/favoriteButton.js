import axios from 'axios';

export default () => ({
    count: null,
    active: null,

    init() {
        this.count = this.attributes.favorites_count;
        this.active = this.attributes.is_favorited;
    },

    async toggle() {
        try {
            if (this.active) {
                await this.unfavorite();
            } else {
                await this.favorite();
            }
        } catch (e) {
            flash('An error occurred, try again.')
        }
    },
    async favorite() {
        await axios.post(`/replies/${this.attributes.id}/favorites`);
        this.active = true;
        this.count++;
    },
    async unfavorite() {
        await axios.delete(`/replies/${this.attributes.id}/favorites`);
        this.active = false;
        this.count--;
    }
});
