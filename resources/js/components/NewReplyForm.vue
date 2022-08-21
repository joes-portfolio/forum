<script setup>
import { inject, reactive } from 'vue';
import axios from 'axios';

const threadPath = inject('threadPath');
const emit = defineEmits(['added']);
const form = reactive({ body: '' });

function setBody(e) {
  form.body = e.target.value;
}

async function store() {
  try {
    const {data} = await axios.post(`${threadPath}/replies`, form);
    form.body = '';
    emit('added', data);
    flash('Thread published successfully!');
  } catch (e) {
    flash(e.response.data, 'danger');
  }
}
</script>

<template>
  <slot
    :body="form.body"
    :setBody="setBody"
    :store="store"
  />
</template>
