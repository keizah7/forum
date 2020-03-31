<div class="card mb-2">
    <div class="card-header">
        <a href="#">{{ $reply->owner->name }}</a>
        said
        {{ $reply->created_at->diffForHumans() }}
    </div>

    <div class="card-body">
        <article>
            <p>{{ $reply->body }}</p>
        </article>
    </div>
</div>
