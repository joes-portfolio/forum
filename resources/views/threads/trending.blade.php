<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
  <div class="p-3 bg-white border-b border-gray-200">
    <p class="text-md">Trending Threads</p>
    <ul role="list" class="divide-y divide-gray-200">
      @foreach($trending as $thread)
        <li class="py-2">
          <span>#{{ $loop->iteration }}</span>
          <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
        </li>
      @endforeach
    </ul>
  </div>
</div>
