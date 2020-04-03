<x-activity :activity="$activity">
    <x-slot name="heading">
        {{ $user->name }} favorited
        <a href="/profiles/{{ $activity->subject->favorable->owner->name }}">{{ $activity->subject->favorable->owner->name }}</a> reply on
        <a href="{{ $activity->subject->favorable->path() }}">{{ $activity->subject->favorable->thread->title }}</a>
    </x-slot>
    <x-slot name="body">
        {{ $activity->subject->favorable->body }}
    </x-slot>
</x-activity>
