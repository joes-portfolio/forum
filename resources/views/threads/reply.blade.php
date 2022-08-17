<div>
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
  <hr class="mt-2" />
  <article>
    {{ $reply->body }}
  </article>
</div>
