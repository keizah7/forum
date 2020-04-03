@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies->count() }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between items-center">
                            {{ $thread->title }}
                            @can('update', $thread)
                                <form action="/threads/{{ $thread->id }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            @endcan
                        </div>

                        <div class="card-body">
                            <article>
                                <p>{{ $thread->body }}</p>
                            </article>

                        </div>
                    </div>

                    <replies :data="{{ $thread->replies }}" @added="repliesCount++" @removed="repliesCount--"></replies>

                    {{--                    {{ $replies->links() }}--}}
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            Published {{ $thread->created_at->diffForHumans() }} by
                            <a href="{{ route('user.profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                            , and has
                            <span v-text="repliesCount"></span> {{ Str::plural('reply', $thread->replies_count) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
