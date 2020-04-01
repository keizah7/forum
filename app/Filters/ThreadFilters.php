<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected array $filters = ['by', 'popularity'];

    /**
     * @param string $userName
     * @return mixed
     */
    protected function by(string $userName)
    {
        $user = User::whereName($userName)->firstOrFail();

        return $this->builder->whereUserId($user->id);
    }

    protected function popularity($value)
    {
//        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }
}
