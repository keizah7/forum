<x-activity :activity="$activity">
    <x-slot name="heading">
        {{ $user->name }} replied to
        <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>
    </x-slot>
    <x-slot name="body">
        {{ $activity->subject->body }}
    </x-slot>
</x-activity>
