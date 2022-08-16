<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Threads') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @forelse($threads as $thread)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <article>
              <div class="flex items-center space-x-2">
                <h4>
                  <strong>
                    <a href="{{ $thread->path() }}">
                      {{ $thread->title }}
                    </a>
                  </strong>
                </h4>
                <span>&middot;</span>
                <strong>
                  <a href="{{ $thread->path() }}">
                    {{ $thread->replies_count }} {{ str('reply')->plural($thread->replies_count) }}</a>
                </strong>
              </div>
              <div>{{ $thread->body }}</div>
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
    </div>
  </div>
</x-app-layout>
