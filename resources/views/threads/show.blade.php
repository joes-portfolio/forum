<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ $thread->title }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <p>
            <a href="#">{{ $thread->creator->name }}</a> posted:
          </p>
          <hr />
          <article>
            {{ $thread->body }}
          </article>
        </div>
      </div>

      <br />

      @foreach($thread->replies as $reply)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            @include("threads.reply")
          </div>
        </div>
        <br />
      @endforeach

      @auth
        <br />
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
  </div>
</x-app-layout>
