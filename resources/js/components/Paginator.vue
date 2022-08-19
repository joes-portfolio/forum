<script setup>
import { computed, ref, watch } from 'vue';

const { data } = defineProps(['data']);
const emit = defineEmits(['changed']);

const page = ref(1);
const prevUrl = ref(null);
const nextUrl = ref(null);

const shouldPaginate = computed(() => !!(prevUrl.value || nextUrl.value));

watch(data, () => {
  page.value = data.meta.current_page;
  prevUrl.value = data.links.prev;
  nextUrl.value = data.links.next;
});

watch(page, () => {
  broadcast();
  updateUrl();
});

function prevPage() {
  if (page.value <= 1) {
    return;
  }

  page.value--;
}

function nextPage() {
  if (page.value === data.meta.last_page) {
    return;
  }

  page.value++;
}

function setPage(newPage) {
  page.value = parseInt(newPage);
}

function broadcast() {
  emit('changed', page.value);
}

function updateUrl() {
  history.pushState(null, null, `?page=${page.value}`);
}
</script>

<template>
  <slot
    :shouldPaginate="shouldPaginate"
    :prevUrl="prevUrl"
    :prevPage="prevPage"
    :nextUrl="nextUrl"
    :nextPage="nextPage"
    :setPage="setPage"
    :meta="data.meta"
  />
</template>
