<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

const props = defineProps(['data']);

const deleted = ref(false);
const editing = ref(false);
const body = ref('');

onMounted(() => body.value = props.data.body);

function edit() {
  editing.value = true;
}

function cancel() {
  editing.value = false;
}

function setBody(e) {
  body.value = e.target.value;
}

function update() {
  axios.patch(`/replies/${props.data.id}`, {
    body: body.value,
  });

  editing.value = false;
  flash('Your reply was updated.');
}

async function destroy() {
  try {
    const response = await axios.delete(`/replies/${props.data.id}`);
    deleted.value = true;

    flash(response.data.message);
  } catch (e) {
    flash(e.response.data.message);
  }
}
</script>

<template>
  <slot
    :deleted="deleted"
    :editing="editing"
    :body="body"
    :setBody="setBody"
    :edit="edit"
    :cancel="cancel"
    :update="update"
    :destroy="destroy"
  />
</template>
