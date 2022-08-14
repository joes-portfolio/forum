<div>
  <p>
    <a href="#">{{ $reply->owner->name }}</a>
    said {{ $reply->created_at->diffForHumans() }}
  </p>
  <hr />
  <article>
    {{ $reply->body }}
  </article>
</div>
