import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';

import alert from './alert';
import FavoriteButton from './components/FavoriteButton.vue';
import Reply from './components/Reply.vue';

Alpine.data('alert', alert);

window.Alpine = Alpine;

if (document.getElementById('thread-app')) {
    const app = createApp({});
    app.component('v-favorite-button', FavoriteButton);
    app.component('v-reply', Reply);
    app.mount('#thread-app');
}

Alpine.start();
