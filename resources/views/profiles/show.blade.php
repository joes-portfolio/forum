<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center space-x-3">
      <img class="inline-block h-10 w-10 rounded-full" src="{{ $profileUser->avatar_path }}" alt="">

      <div>
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:tracking-tight sm:truncate">
          {{ $profileUser->name }}
        </h2>

        <p class="mb-0 text-sm font-medium text-gray-500 hover:text-gray-700">
          member since {{ $profileUser->created_at->diffForHumans() }}
        </p>
      </div>
    </div>

    @can('update', $profileUser)
      <form action="{{ route('api.users.avatar', $profileUser) }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="avatar" accept="image/*">
        <br>
        <button type="submit">save</button>
      </form>
    @endcan
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
