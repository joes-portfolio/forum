<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ $thread->title }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="flex space-x-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="w-2/3 space-y-6">
        <div class="bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200">
          <div class="px-4 py-5 sm:px-6">
            <div class="flex justify-between items-end">
              <p>
                <a href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name }}</a> posted:
              </p>

              @can('update', $thread)
                <form action="{{ $thread->path() }}" method="post">
                  @csrf
                  @method('DELETE')

                  <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 border border-red-500 text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400"
                  >
                    Delete Thread
                  </button>
                </form>
              @endcan
            </div>
          </div>
          <div class="px-4 py-5 sm:p-6">
            <article>
              {{ $thread->body }}
            </article>
          </div>
        </div>

        @foreach($replies as $reply)
          @include("threads.reply")
        @endforeach

        {{ $replies->links() }}

        @auth
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              @include('threads.reply-form')
            </div>
          </div>
        @else
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              <p class="flex justify-center">Please&nbsp;<a href="{{ route('login') }}">sign in</a> to participate.</p>
            </div>
          </div>
        @endauth
      </div>

      <div class="w-1/3">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <p>
              This thread was published {{ $thread->created_at->diffForHumans() }} by
              <a href="#">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies_count }} {{ str('reply')->plural($thread->replies_count) }}.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
