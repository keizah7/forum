<x-activity :activity="$activity">
    <x-slot name="heading">
        {{ $user->name }} published
        <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>
    </x-slot>
    <x-slot name="body">
        {{ $activity->subject->body }}
    </x-slot>
</x-activity>
