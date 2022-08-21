import './bootstrap';
import Alpine from 'alpinejs';
import { createApp } from 'vue';

import alert from './alert';
import ThreadView from './pages/Thread.vue';
import Replies from './components/Replies.vue';
import Reply from './components/Reply.vue';
import FavoriteButton from './components/FavoriteButton.vue';
import NewReplyForm from './components/NewReplyForm.vue';
import Paginator from './components/Paginator.vue';
import SubscribeButton from './components/SubscribeButton.vue';
import UserNotifications from './components/UserNotifications.vue';
import { auth, can } from './utils';

Alpine.data('alert', alert);

window.Alpine = Alpine;

if (document.getElementById('notifications')) {
    const app = createApp({});
    app.provide('auth', auth);
    app.component('v-user-notifications', UserNotifications);
    app.mount('#notifications');
}

if (document.getElementById('thread-view')) {
    const app = createApp({});

    app.provide('auth', auth);
    app.provide('can', can);

    app.component('v-paginator', Paginator);
    app.component('v-thread-view', ThreadView);
    app.component('v-replies', Replies);
    app.component('v-reply', Reply);
    app.component('v-favorite-button', FavoriteButton);
    app.component('v-new-reply-form', NewReplyForm);
    app.component('v-subscribe-button', SubscribeButton);

    app.mount('#thread-view');
}

Alpine.start();
