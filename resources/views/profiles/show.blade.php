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

                @foreach($activities as $date => $activity)
                    <h3>{{ $date }}</h3>
                    @foreach($activity as $record)
                        @include('profiles.activities.'.$record->type, ['activity' => $record])
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
