import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';

import alert from './alert';
import ThreadView from './pages/Thread.vue';
import Replies from './components/Replies.vue';
import Reply from './components/Reply.vue';
import FavoriteButton from './components/FavoriteButton.vue';
import NewReplyForm from './components/NewReplyForm.vue';
import { auth, can } from './utils';

Alpine.data('alert', alert);

window.Alpine = Alpine;

const app = createApp({});

app.provide('auth', auth);
app.provide('can', can);

if (document.getElementById('thread-view')) {
    app.component('v-thread-view', ThreadView);
    app.component('v-replies', Replies);
    app.component('v-reply', Reply);
    app.component('v-favorite-button', FavoriteButton);
    app.component('v-new-reply-form', NewReplyForm);

    app.mount('#thread-view');
}

Alpine.start();
