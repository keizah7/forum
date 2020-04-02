@props(['activity'])

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>{{ $heading }}</span>
        {{ $activity->created_at->diffForHumans() }}
    </div>

    <div class="card-body">
        <article>{{ $body }}</article>
    </div>
</div>
