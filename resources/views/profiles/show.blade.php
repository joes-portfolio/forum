<x-app-layout>
  <x-slot name="header">
    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:tracking-tight sm:truncate">
      {{ $profileUser->name }}
    </h2>

    <p class="mb-0 text-sm font-medium text-gray-500 hover:text-gray-700">
      since {{ $profileUser->created_at->diffForHumans() }}
    </p>
  </x-slot>

  <div class="py-12">
    <div class="flex space-x-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="w-2/3 mx-auto space-y-3">
        @foreach($activities as $date => $activity)
          <h4 class="text-xl font-bold leading-7 text-gray-900 sm:text-xl sm:tracking-tight sm:truncate">{{ $date }}</h4>

          @foreach($activity as $record)
            @include('profiles.activities.' . $record->type, ['subject' => $record->subject])
          @endforeach
        @endforeach
      </div>
    </div>
  </div>
</x-app-layout>
