<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ $profileUser->name }}
    </h2>

    <p class="mb-0">
      since {{ $profileUser->created_at->diffForHumans() }}
    </p>
  </x-slot>

  <div class="py-12">
    <div class="flex space-x-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="w-2/3 mx-auto space-y-3">
        @foreach($threads as $thread)
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              <p>
                <span>{{ $thread->creator->name }} posted:</span>
                <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                &middot;
                <span>{{ $thread->created_at->diffForHumans() }}</span>
              </p>
              <hr />
              <article>
                {{ $thread->body }}
              </article>
            </div>
          </div>
        @endforeach

        {{ $threads->links() }}
      </div>
    </div>
  </div>
</x-app-layout>
