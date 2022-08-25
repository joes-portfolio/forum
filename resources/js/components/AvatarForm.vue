<script setup>
const props = defineProps(['endpoint']);
const emit = defineEmits(['loaded']);

function onChange(e) {
  if (!e.target.files.length) {
    return;
  }

  const file = e.target.files[0];
  const reader = new FileReader();

  reader.readAsDataURL(file);
  reader.onload = (e) => {
    emit('loaded', { url: e.target.result });
  };

  upload(file);
}

function upload(file) {
  const data = new FormData();
  data.append('avatar', file);

  axios.post(props.endpoint, data)
    .then(() => flash('Avatar uploaded!'))
    .catch(() => {
      emit('loaded', { url: null });
      flash('An error occured.', 'danger');
    });
}
</script>

<template>
  <form action="#">
    <div class="flex text-sm text-gray-600 pt-2">
      <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
        <span>Click here to select & upload your avatar</span>
        <input @change="onChange" id="file-upload" type="file" name="avatar" accept="image/*" class="sr-only" />
      </label>
    </div>
  </form>
</template>
