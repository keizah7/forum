@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2>{{ $user->name }}</h2>
                        Since {{ $user->created_at }}
                    </div>
                </div>

                @foreach($threads as $thread)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{ $thread->title }}</h4>
                            <span>{{ $thread->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="card-body">
                            <article>
                                <p>{{ $thread->body }}</p>
                            </article>

                        </div>
                    </div>
                @endforeach

                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
