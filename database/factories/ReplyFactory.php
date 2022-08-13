<?php

namespace Database\Factories;

use App\Models\Reply;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReplyFactory extends Factory
{
    protected $model = Reply::class;

    public function definition(): array
    {
        return [
            'thread_id' => ThreadFactory::new(),
            'user_id' => UserFactory::new(),
            'body' => $this->faker->paragraph(),
        ];
    }
}
