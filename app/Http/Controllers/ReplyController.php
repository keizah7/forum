<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\Response
     */
    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $channelId
     * @param Thread $thread
     * @return array|ResponseFactory|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread)
    {
        try {
            $this->validate(request(), ['body' => ['required', new SpamFree]]);

            $reply = $thread->addReply([
               'body' => request('body'),
               'user_id' => auth()->id()
           ]);
        } catch (\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }

        return $reply->load('owner');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Reply $reply
     * @return ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            $this->validate(request(), ['body' => ['required', new SpamFree]]);

            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Reply $reply
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }
}
