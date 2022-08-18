<div
  x-data="replyComponent(@js($reply->jsProperties()))"
  x-show="!deleted"
  x-transition.duration.300ms
  class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200"
>
  <div class="px-4 py-5 sm:px-6">
    <div class="flex justify-between items-end">
      <p>
        <a href="/profiles/{{ $reply->owner->name }}">{{ $reply->owner->name }}</a>
        said {{ $reply->created_at->diffForHumans() }}
      </p>

      @auth()
        <button
          x-data="favoriteButton"
          x-on:click="toggle"
          x-bind:class="{
            'border-gray-300 text-gray-700 hover:bg-gray-50': !active,
            'border-transparent text-indigo-700 bg-indigo-100 hover:bg-indigo-200': active
          }"
          type="button"
          class="inline-flex items-center px-2.5 py-1.5 border text-sm font-medium rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"

        >
          <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
          </svg>
          <span x-text="count">{{ $reply->favorites_count }}</span>
        </button>
      @endauth
    </div>
  </div>
  <div class="px-4 py-5 sm:p-6">
    <div x-show="editing" x-cloak class="space-y-2">
      <textarea x-model="body" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
        {{ $reply->body }}
      </textarea>

      <div class="flex space-x-2">
        <button
          x-on:click="editing = false"
          type="button"
          class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >Cancel</button>

        <button
          x-on:click="update"
          type="button"
          class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >Save</button>
      </div>
    </div>

    <article x-show="!editing" x-html="body">
      {{ $reply->body }}
    </article>
  </div>

  @can('update', $reply)
    <div class="bg-gray-50 px-4 py-4 sm:px-6 flex space-x-2">
      <button
        x-on:click="editing = true"
        x-show="!editing"
        type="button"
        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >Edit</button>

      <button
        x-on:click="destroy"
        type="button"
        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400"
      >
        Delete
      </button>
    </div>
  @endcan
</div>

