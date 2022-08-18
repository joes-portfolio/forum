<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ $thread->title }}
    </h2>
  </x-slot>

  <div id="thread-view" class="py-12">
    <v-thread-view
      :data="@js($thread)"
      v-slot="{ count, decrement, auth, data, increment }"
    >
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
              <article v-text="data.body"></article>
            </div>
          </div>

          {{--{{ $replies->links() }}--}}

          <v-replies
            v-slot="{ items, remove, add }"
            :data="@js($replies)"
            @added="increment"
            @removed="decrement"
          >
            @include("threads.reply")

            <div v-if="auth" class="sm:rounded-lg">
              @include('threads.reply-form')
            </div>
            <div v-else class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <p class="flex justify-center">Please&nbsp;<a href="{{ route('login') }}">sign in</a>&nbsp;to participate.</p>
              </div>
            </div>
          </v-replies>
        </div>

        <div class="w-1/3">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
              <p>
                This thread was published <span v-text="data.created_at"></span> by
                <a :href="data.creator.name" v-text="data.creator.name"></a>,
                and currently has <span v-text="count"></span> replies.
              </p>
            </div>
          </div>
        </div>
      </div>
    </v-thread-view>
  </div>
</x-app-layout>
