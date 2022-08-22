<script setup>
import { inject, onMounted, reactive, ref } from 'vue';
import axios from 'axios';

const emit = defineEmits(['added', 'removed']);
const auth = inject('auth');

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
  <v-reply
    v-cloak
    v-for="(reply, index) in items"
    :key="reply.id"
    :data="reply"
    @deleted="remove(index)"
  ></v-reply>

  <v-paginator :data="pagination" @changed="fetch"></v-paginator>

  <div v-if="auth.check" class="sm:rounded-lg">
    <v-new-reply-form @added="add"></v-new-reply-form>
  </div>
  <div v-else class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
      <p class="flex justify-center">Please&nbsp;<a href="/login">sign in</a>&nbsp;to participate.</p>
    </div>
  </div>
</template>
