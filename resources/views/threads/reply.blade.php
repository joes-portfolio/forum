<div
  x-data="replyComponent(@js($reply->only(['id', 'body', 'thread_id'])))"
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
        <form action="{{ url("/replies/{$reply->id}/favorites") }}" method="post">
          @csrf

          <button
            @disabled($reply->isFavorited())
            type="submit"
            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-indigo-600 bg-white hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-75 disabled:hover:bg-white"
          >
            {{ $reply->favorites_count }} {{ str('favorite')->plural($reply->favorites_count) }}
          </button>
        </form>
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

