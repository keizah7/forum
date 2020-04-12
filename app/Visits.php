<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Visits
{
    protected $thread;

    /**
     * Visits constructor.
     * @param $thread
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    public function record() {
        Redis::incr($this->getChacheKey());
    }

    public function count()
    {
        return Redis::get($this->getChacheKey()) ?? 0;
    }

    protected function getChacheKey()
    {
        return "threads.{$this->thread->id}.visits";
    }

    public function reset()
    {
        Redis::del($this->getChacheKey());
    }
}
