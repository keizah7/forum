@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $thread->title }}</div>

                    <div class="card-body">
                        <article>
                            <p>{{ $thread->body }}</p>
                        </article>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-header">Replies</div>
                @forelse($thread->replies as $reply)
                    <div class="card">
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
                @empty
                    Replies list is empty
                @endforelse
            </div>
        </div>
    </div>
@endsection
