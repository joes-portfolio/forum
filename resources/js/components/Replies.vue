<script setup>
import { reactive } from 'vue';

const props = defineProps(['data']);
const emit = defineEmits(['removed']);

const items = reactive(props.data);

function remove(index) {
  items.splice(index, 1);
  emit('removed');
}
</script>

<template>
  <slot :items="items" :remove="remove" />
</template>
