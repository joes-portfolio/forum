<div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
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
    <article>
      {{ $reply->body }}
    </article>
  </div>
    @can('update', $reply)
      <div class="bg-gray-50 px-4 py-4 sm:px-6">
        <form action="/replies/{{ $reply->id }}" method="post">
            @csrf
            @method('DELETE')

            <button
              type="submit"
              class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400"
            >
              Delete
            </button>
          </form>
      </div>
    @endcan
</div>

