<?php

namespace App;

use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{
    public function recordVisit() {
        Redis::incr($this->visitsChacheKey());

        return $this;
    }

    public function visits()
    {
        return Redis::get($this->visitsChacheKey()) ?? 0;
    }

    public function resetVisits()
    {
        Redis::del($this->visitsChacheKey());

        return $this;
    }

    public function visitsChacheKey()
    {
        return "threads.{$this->id}.visits";
    }
}
