<script setup>
import { computed, inject, onMounted, ref } from 'vue';

const can = inject('can');
const props = defineProps(['data']);
const avatar = ref(null);

onMounted(() => {
  avatar.value = props.data.avatar_path;
});

const endpoint = computed(() => `/api/users/${props.data.name}/avatar`);

function setAvatar(data) {
  avatar.value = data.url;
}
</script>

<template>
  <div class="flex items-center space-x-3">
    <img v-if="avatar"
         :src="avatar"
         :alt="data.name"
         class="inline-block h-10 w-10 rounded-full"
    />

    <div>
      <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:tracking-tight sm:truncate">
        {{ data.name }}
      </h2>

      <p class="mb-0 text-sm font-medium text-gray-500 hover:text-gray-700">
        member since {{ data.created_at_formatted }}
      </p>
    </div>
  </div>

  <v-avatar-form
    v-if="can('update', data)"
    :endpoint="endpoint"
    @loaded="setAvatar"
  ></v-avatar-form>
</template>
