<script setup>
import { inject, reactive } from 'vue';
import axios from 'axios';
import VueTribute from 'vue-tribute';
import debounce from 'lodash.debounce';

const threadPath = inject('threadPath');
const emit = defineEmits(['added']);
const form = reactive({ body: '' });

const vueTributeOptions = {
  trigger: '@',
  containerClass: 'border border-gray-300 rounded-lg overflow-hidden bg-white divide-y divide-gray-200',
  itemClass: 'px-3 py-1 text-sm',
  selectClass: 'highlight',
  selectTemplate: (item) => `@${item.original.value}`,
  values: debounce(function (text, cb) {
    axios.get('/api/users', { params: { s: text }})
      .then(res => cb(res.data))
      .catch(err => cb([]));
  }, 750),
};

async function store() {
  try {
    const {data} = await axios.post(`${threadPath}/replies`, form);
    form.body = '';
    emit('added', data);
    flash('Reply added successfully!');
  } catch (e) {
    flash(e.response.data.message, 'danger');
  }
}
</script>

<template>
  <form @submit.prevent="store">
    <div id="tabs-1-panel-1" class="p-0.5 -m-0.5 rounded-lg" aria-labelledby="tabs-1-tab-1" role="tabpanel" tabindex="0">
      <label for="reply" class="sr-only">Reply</label>
      <vue-tribute :options="vueTributeOptions">
        <textarea
          v-model="form.body"
          rows="5"
          name="body"
          id="reply"
          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
          placeholder="Add your reply..."
          required
        ></textarea>
      </vue-tribute>
    </div>

    <div class="mt-2 flex justify-end">
      <button
        type="submit"
        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >Reply</button>
    </div>
  </form>
</template>
