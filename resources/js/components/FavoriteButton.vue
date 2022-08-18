<script setup>
import { ref } from 'vue';
import axios from 'axios';

const { data } = defineProps(['data']);

let count = ref(data.favorites_count);
let active = ref(data.is_favorited);

function toggle() {
  try {
    if (active.value) {
      unfavorite();
    } else {
      favorite();
    }
  } catch (e) {
    flash('An error occurred, try again.');
  }
}

async function favorite() {
  await axios.post(`/replies/${data.id}/favorites`);
  active.value = true;
  count.value++;
}

async function unfavorite() {
  await axios.delete(`/replies/${data.id}/favorites`);
  active.value = false;
  count.value--;
}
</script>

<template>
  <button
    @click="toggle"
    :class="{
      'border-gray-300 text-gray-700 hover:bg-gray-50': !active,
      'border-transparent text-indigo-700 bg-indigo-100 hover:bg-indigo-200': active
    }"
    type="button"
    class="inline-flex items-center px-2.5 py-1.5 border text-sm font-medium rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
  >
    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
    <span>{{ count }}</span>
  </button>
</template>
