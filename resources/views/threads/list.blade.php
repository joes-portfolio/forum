@forelse($threads as $thread)
  <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
      <article class="divide-y divide-gray-300">
        <div class="flex items-center">
          <div class="flex-1 py-2">
            <h4 @class(["text-lg", 'font-bold' => auth()->check() && $thread->hasUpdatesFor(auth()->user())])>
              <a href="{{ $thread->path() }}">
                {{ $thread->title }}
              </a>
            </h4>
            <p>posted by <a href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name }}</a></p>
          </div>
          <a href="{{ $thread->path() }}">
            {{ $thread->replies_count }} {{ str('reply')->plural($thread->replies_count) }}
          </a>
        </div>
        <div class="py-2">{{ $thread->body }}</div>
      </article>
    </div>
  </div>
  <br />
@empty
  <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
      <p class="text-center">Such empty :(. We could not find any threads.</p>
    </div>
  </div>
@endforelse
