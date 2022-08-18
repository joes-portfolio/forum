<script setup>
import { reactive } from 'vue';

const props = defineProps(['data']);
const emit = defineEmits(['added', 'removed']);

const items = reactive(props.data);

function add(reply) {
  items.push(reply);
  emit('added');
}

function remove(index) {
  items.splice(index, 1);
  emit('removed');
}
</script>

<template>
  <slot
    :items="items"
    :add="add"
    :remove="remove"
  />
</template>
