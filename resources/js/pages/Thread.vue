<script setup>
import { inject, ref } from 'vue';

const { data } = defineProps(['data']);
const auth = inject('auth');
const count = ref(data.replies_count);

function decrement() {
  count.value--;
}
</script>

<template>
  <slot
    :auth="auth"
    :data="data"
    :count="count"
    :decrement="decrement"
  />
</template>
