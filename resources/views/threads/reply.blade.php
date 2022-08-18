<v-reply
  :data="@js($reply->only(['id', 'body']))"
  v-slot="{ deleted, editing, body, setBody, edit, cancel, update, destroy }"
>
  <div v-if="!deleted" class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
    <div class="px-4 py-5 sm:px-6">
      <div class="flex justify-between items-end">
        <p>
          <a href="/profiles/{{ $reply->owner->name }}">{{ $reply->owner->name }}</a>
          said {{ $reply->created_at->diffForHumans() }}
        </p>

        @auth()
          <v-favorite-button :data="@js($reply->only(['id', 'favorites_count', 'is_favorited']))"></v-favorite-button>
        @endauth
      </div>
    </div>

    <div class="px-4 py-5 sm:p-6">
      <div v-if="editing" v-cloak class="space-y-2">
        <textarea
          v-model="body"
          @input="setBody"
          rows="4"
          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
        >{{ $reply->body }}</textarea>

        <div class="flex space-x-2">
          <button
            @click="cancel"
            type="button"
            class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >Cancel</button>

          <button
            @click="update"
            type="button"
            class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >Save</button>
        </div>
      </div>

      <div v-else>
        <article v-text="body"></article>
      </div>
    </div>

    @can('update', $reply)
      <div class="bg-gray-50 px-4 py-4 sm:px-6 flex space-x-2">
        <button
          @click="destroy"
          type="button"
          class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400"
        >
          Delete
        </button>

        <button
          v-show="!editing"
          @click="edit"
          type="button"
          class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >Edit</button>
      </div>
    @endcan
  </div>
</v-reply>

