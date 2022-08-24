<script setup>
import { inject, provide, ref } from 'vue';

const { data } = defineProps(['data']);
const auth = inject('auth');
const can = inject('can');
const count = ref(data.replies_count);

provide('threadPath', data.path);

function increment() {
  count.value++;
}

function decrement() {
  count.value--;
}
</script>

<template>
  <div class="flex space-x-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="w-2/3 space-y-6">
      <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
        <div class="px-4 py-5 sm:px-6">
          <div class="flex justify-between">
            <div class="flex items-center space-x-1">
              <img v-if="data.creator.avatar"
                   :src="data.creator.avatar"
                   :alt="data.creator.name"
                   class="inline-block h-6 w-6 rounded-sm"
              />

              <p>
                <a :href="`/profiles/${data.creator.name}`">{{ data.creator.name }}</a> posted:
              </p>
            </div>

            <form v-if="can('update', data)" :action="data.path" method="post">
              <button
                type="submit"
                class="inline-flex items-center px-4 py-2 border border-red-500 text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400"
              >
                Delete Thread
              </button>
            </form>
          </div>
        </div>
        <div class="px-4 py-5 sm:p-6">
          <article v-text="data.body"></article>
        </div>
      </div>

      <v-replies @added="increment" @removed="decrement"></v-replies>
    </div>

    <div class="w-1/3">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200 space-y-2">
          <p>
            This thread was published <span v-text="data.created_at"></span> by
            <a :href="data.creator.name" v-text="data.creator.name"></a>,
            and currently has <span v-text="count"></span> replies.
          </p>

          <v-subscribe-button :active="data.is_subscribed_to"></v-subscribe-button>
        </div>
      </div>
    </div>
  </div>
</template>
