@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endpush

@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8" v-cloak>
                    @include ('threads._question')

                    <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            Published {{ $thread->created_at->diffForHumans() }} and has
                            <span v-text="repliesCount"></span> {{ Str::plural('reply', $thread->replies_count) }}

                            <p>
                                <subscribe-button :active="@json($thread->isSubscribedTo)" v-if="signedIn"></subscribe-button>

                                <button class="btn btn-outline-primary"
                                        v-if="authorize('isAdmin')"
                                        @click="toggleLock"
                                        v-text="locked ? 'Unlock' : 'Lock'"></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
