<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Threads') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="flex space-x-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="w-3/4">
        @include('threads.list')

        {{ $threads->links() }}
      </div>
      <div class="w-1/4">
        @include('threads.trending')
      </div>
    </div>
  </div>
</x-app-layout>
