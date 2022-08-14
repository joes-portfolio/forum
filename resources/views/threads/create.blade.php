<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Create Thread
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <x-auth-validation-errors class="mb-4" :errors="$errors" />

          <form action="{{ url('/threads') }}" method="post">
            @csrf
            <div>
              <label for="channel" class="block text-sm font-medium text-gray-700">Choose a Channel</label>
              <select id="channel" name="channel_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                <option value="">...</option>
                @foreach($channels as $channel)
                  <option @selected(old('channel_id') == $channel->id) value="{{ $channel->id }}">{{ $channel->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mt-3">
              <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
              <div class="mt-1">
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
              </div>
            </div>

            <div class="mt-3 p-0.5 -m-0.5 rounded-lg">
              <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
              <div class="mt-1">
                <textarea
                  rows="5"
                  name="body"
                  id="body"
                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                  required
                >{{ old('body') }}</textarea>
              </div>
            </div>

            <div class="mt-2 flex justify-end">
              <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Publish</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
