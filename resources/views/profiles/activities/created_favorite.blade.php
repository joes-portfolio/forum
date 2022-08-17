@component('profiles.activities.activity')
  @slot('heading')
    <a href="{{ $subject->favorited->path() }}">{{ $profileUser->name }} liked a reply</a>
    &middot;
    <span>{{ $subject->created_at->diffForHumans() }}</span>
  @endslot

  @slot('body')
    {{ $subject->favorited->body }}
  @endslot
@endcomponent
