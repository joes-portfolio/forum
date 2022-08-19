<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import axios from 'axios';

const emit = defineEmits(['added', 'removed']);
const items = ref([]);
const pagination = reactive({
  links: {},
  meta: {},
});

onMounted(() => fetch());

async function fetch(page) {
  const { data } = await axios.get(url(page));

  refresh(data);
}

function url(page) {
  if (! page) {
    page = (new URLSearchParams(window.location.search)).get('page') || 1;
  }

  return `${location.pathname}/replies?page=${page}`;
}

function refresh({ data, links, meta }) {
  items.value = data;
  pagination.links = links;
  pagination.meta = meta;

  window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
}

function add(reply) {
  items.value.push(reply);
  emit('added');
}

function remove(index) {
  items.value.splice(index, 1);
  emit('removed');
}
</script>

<template>
  <slot
    :items="items"
    :pagination="pagination"
    :add="add"
    :remove="remove"
    :fetch="fetch"
  />
</template>
