@component('profiles.activities.activity')
  @slot('heading')
    <span>{{ $subject->owner->name }} replied in</span>
    <a href="{{ $subject->thread->path() }}">"{{ $subject->thread->title }}"</a>
    &middot;
    <span>{{ $subject->created_at->diffForHumans() }}</span>
  @endslot

  @slot('body')
    {{ $subject->body }}
  @endslot
@endcomponent
