<x-app-layout>
  <x-slot name="header">
    <div id="profile-header">
      <v-profile-header :data="@js($profileUser)"></v-profile-header>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="flex space-x-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="w-2/3 mx-auto space-y-3">
        @forelse($activities as $date => $activity)
          <h4 class="text-xl font-bold leading-7 text-gray-900 sm:text-xl sm:tracking-tight sm:truncate">{{ $date }}</h4>

          @foreach($activity as $record)
            @include('profiles.activities.' . $record->type, ['subject' => $record->subject])
          @endforeach
        @empty
          <div class="text-center border-2 border-gray-300 border-dashed rounded-lg p-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="mt-2 text-xl font-semibold text-gray-900">Nothing to see here.</h3>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</x-app-layout>
