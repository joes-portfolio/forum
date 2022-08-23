<script setup>
import { inject, onMounted, reactive, ref } from 'vue';
import axios from 'axios';

const props = defineProps(['data']);
const emit = defineEmits(['deleted']);
const can = inject('can');
const auth = inject('auth');

const editing = ref(false);
const data = reactive(props.data);
const form = reactive({ body: '' });

onMounted(() => {
  form.body = props.data.body;
});

function edit() {
  editing.value = true;
}

function cancel() {
  editing.value = false;
}

async function update() {
  try {
    await axios.patch(`/replies/${data.id}`, form);

    editing.value = false;
    flash('Your reply was updated.');
  } catch (e) {
    flash(e.response.data.message, 'danger');
  }
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
  <div
    :id="`reply-${data.id}`"
    class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200"
  >
    <div class="p-3 sm:px-6">
      <div class="flex justify-between items-end">
        <p>
          <a :href="`/profiles/${data.owner.name}`" v-text="data.owner.name"></a>
          said <span v-text="data.created_at"></span>
        </p>

        <v-favorite-button
          v-if="auth"
          :data="{
            id: data.id,
            favorites_count: data.favorites_count,
            is_favorited: data.is_favorited
          }"
        ></v-favorite-button>
      </div>
    </div>

    <div class="px-4 py-5 sm:p-6">
      <div v-if="editing" v-cloak>
        <form @submit.prevent="update" class="space-y-2">
          <textarea
            v-model="form.body"
            rows="4"
            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
          ></textarea>

          <div class="flex space-x-2">
            <button
              @click="cancel"
              type="button"
              class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >Cancel</button>

            <button
              type="submit"
              class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >Save</button>
          </div>
        </form>
      </div>

      <div v-else>
        <article v-html="form.body"></article>
      </div>
    </div>

    <div v-if="can('update', data)" class="bg-gray-50 px-4 py-4 sm:px-6 flex space-x-2">
      <button
        @click="destroy"
        type="button"
        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400"
      >Delete</button>

      <button
        v-show="!editing"
        @click="edit"
        type="button"
        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >Edit</button>
    </div>
  </div>
</template>
