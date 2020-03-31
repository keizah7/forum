<?php

use App\Reply;
use App\Thread;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Thread::class, rand(1, 10))->create()->each(function ($thread) {
            factory(Reply::class, rand(1, 5))->create(['thread_id' => $thread]);
        });
    }
}
