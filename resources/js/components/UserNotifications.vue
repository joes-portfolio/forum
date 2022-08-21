<script setup>
import { inject, onMounted, ref } from 'vue';
import axios from 'axios';

const auth = inject('auth');
const open = ref(false);
const notifications = ref([]);

onMounted(() => {
  fetchNotifications();
});

async function fetchNotifications() {
  const {data} = await axios.get(`/profiles/${auth.name}/notifications`);

  notifications.value = data;
}

function markAsRead(notificationId) {
  axios.patch(`/profiles/${auth.name}/notifications/${notificationId}`);
}
</script>

<template>
  <div v-cloak v-if="notifications.length" class="relative">
    <div>
      <button
        @click="open = !open"
        type="button"
        class="rounded-full flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="menu-button" aria-expanded="true" aria-haspopup="true">
        <span class="sr-only">Open options</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
      </button>
    </div>

    <div
      v-if="open"
      class="origin-top-right absolute bg-white right-0 mt-2 w-48 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
      <div class="py-1" role="none">
        <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
        <div class="divide-y divide-gray-200">
          <a v-for="notification in notifications"
             :href="notification.data.link"
             @click="markAsRead(notification.id)"
             class="text-gray-700 block px-4 py-2 text-sm"
             role="menuitem"
             tabindex="-1"
             id="menu-item-0"
          >{{ notification.data.message }}</a>
        </div>
      </div>
    </div>
  </div>
</template>
