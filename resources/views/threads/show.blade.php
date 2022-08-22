<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ $thread->title }}
    </h2>
  </x-slot>

  <div id="thread-view" class="py-12">
    <v-thread-view :data="@js($thread)"></v-thread-view>
  </div>
</x-app-layout>
