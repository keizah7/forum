<?php

namespace App;

use Illuminate\Support\Facades\Redis;

/**
 * Class Visits
 * counts thread visits in redis database.
 * its useful when traffic is high
 * in this script this file will be just an example
 * because traffic wont be big
 *
 * @package App
 */
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

    /**
     * @return int
     */
    public function count()
    {
        return Redis::get($this->getChacheKey()) ?? 0;
    }

    /**
     * @return string
     */
    protected function getChacheKey()
    {
        return "threads.{$this->thread->id}.visits";
    }

    public function reset()
    {
        Redis::del($this->getChacheKey());
    }
}
