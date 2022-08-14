<?php

namespace Database\Factories;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    protected $model = Thread::class;

    public function definition(): array
    {
        return [
            'user_id' => UserFactory::new(),
            'channel_id' => ChannelFactory::new(),
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
        ];
    }
}
