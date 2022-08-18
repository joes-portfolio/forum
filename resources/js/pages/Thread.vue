<script setup>
import { inject, provide, ref } from 'vue';

const { data } = defineProps(['data']);
const auth = inject('auth');
const count = ref(data.replies_count);

provide('threadPath', data.path);

function increment() {
  count.value++;
}

function decrement() {
  count.value--;
}
</script>

<template>
  <slot
    :auth="auth"
    :data="data"
    :count="count"
    :increment="increment"
    :decrement="decrement"
  />
</template>
