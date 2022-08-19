<script setup>
import { inject, onMounted, reactive, ref } from 'vue';
import axios from 'axios';

const props = defineProps(['data']);
const emit = defineEmits(['deleted']);
const can = inject('can');
const auth = inject('auth');

const editing = ref(false);
const data = reactive(props.data);
const body = ref('');

onMounted(() => {
  body.value = props.data.body;
});

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
  axios.patch(`/replies/${data.id}`, {
    body: body.value,
  });

  editing.value = false;
  flash('Your reply was updated.');
}

async function destroy() {
  try {
    const response = await axios.delete(`/replies/${data.id}`);
    emit('deleted', data.id);

    flash(response.data.message);
  } catch (e) {
    console.log(e);
    // flash(e.response.data.message);
  }
}
</script>

<template>
  <slot
    :auth="auth"
    :can="can"
    :editing="editing"
    :data="data"
    :body="body"
    :setBody="setBody"
    :edit="edit"
    :cancel="cancel"
    :update="update"
    :destroy="destroy"
  />
</template>
