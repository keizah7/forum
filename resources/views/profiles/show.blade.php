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

                @forelse ($activities as $date => $activity)
                    <h3>{{ $date }}</h3>
                    @foreach($activity as $record)
                        @includeIf("profiles.activities.{$record->type}", ['activity' => $record])
                    @endforeach
                @empty
                    <p>There is no activity for this user yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
