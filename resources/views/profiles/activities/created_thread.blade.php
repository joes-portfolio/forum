@component('profiles.activities.activity')
  @slot('heading')
    <span>{{ $subject->creator->name }} posted</span>
    <a href="{{ $subject->path() }}">"{{ $subject->title }}"</a>
    &middot;
    <span>{{ $subject->created_at->diffForHumans() }}</span>
  @endslot

  @slot('body')
    {{ $subject->body }}
  @endslot
@endcomponent
