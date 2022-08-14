<form action="{{ $thread->path() . '/replies' }}" method="post">
  <x-auth-validation-errors class="mb-4" :errors="$errors" />

  @csrf
  <div id="tabs-1-panel-1" class="p-0.5 -m-0.5 rounded-lg" aria-labelledby="tabs-1-tab-1" role="tabpanel" tabindex="0">
    <label for="reply" class="sr-only">Reply</label>
    <textarea
      rows="5"
      name="body"
      id="reply"
      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
      placeholder="Add your reply..."
      required
    ></textarea>
  </div>

  <div class="mt-2 flex justify-end">
    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Reply</button>
  </div>
</form>
