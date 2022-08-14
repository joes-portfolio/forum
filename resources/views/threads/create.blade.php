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
          <form action="{{ url('/threads') }}" method="post">
            @csrf
            <div>
              <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
              <div class="mt-1">
                <input type="text" name="title" id="title" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
              </div>
            </div>

            <div class="mt-3 p-0.5 -m-0.5 rounded-lg">
              <label for="body" class="block text-sm font-medium text-gray-700">Body:</label>
              <div class="mt-1">
                <textarea
                  rows="5"
                  name="body"
                  id="body"
                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                ></textarea>
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
