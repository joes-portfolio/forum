<script setup>
import axios from 'axios';
import { computed, inject, ref } from 'vue';

const auth = inject('auth');

const props = defineProps(['active']);
const active = ref(props.active);
const buttonText = computed(() => active.value ? 'unsubscribe' : 'subscribe');

async function toggle() {
  try {
    const method = !active ? 'delete' : 'post';

    await axios[method](`${location.pathname}/subscriptions`);

    active.value = !active.value;

    flash(active.value ? 'subscribed!' : 'unsubscribed!');
  } catch (e) {
    console.log(e);
  }
}
</script>

<template>
  <button
    v-if="auth.check"
    @click="toggle"
    type="button"
    :class="{
      'border-gray-300 shadow-sm text-gray-700 bg-white hover:bg-gray-50': !active,
      'border-transparent text-indigo-700 bg-indigo-100 hover:bg-indigo-200': active,
    }"
    class="inline-flex items-center px-3 py-2 border text-sm leading-4 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
  >{{ buttonText }}</button>
</template>
