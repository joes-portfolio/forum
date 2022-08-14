<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Threads') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          @foreach($threads as $thread)
            <article>
              <div class="flex items-center space-x-2">
                <h4>
                  <a href="{{ $thread->path() }}">
                    {{ $thread->title }}
                  </a>
                </h4>
                <span>&middot;</span>
                <strong>
                  <a href="{{ $thread->path() }}">
                    {{ $thread->replies_count }} {{ str('reply')->plural($thread->replies_count) }}</a>
                </strong>
              </div>
              <div>{{ $thread->body }}</div>
            </article>
            <br />
          @endforeach
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
