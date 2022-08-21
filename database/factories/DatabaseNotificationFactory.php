<?php

namespace Database\Factories;

use App\Models\User;
use App\Notifications\ThreadWasUpdatedNotification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;

class DatabaseNotificationFactory extends Factory
{
    protected $model = DatabaseNotification::class;

    public function definition(): array
    {
        return [
            'id' => str()->uuid(),
            'type' => ThreadWasUpdatedNotification::class,
            'notifiable_id' => fn (array $attributes) => auth()->id() ?: UserFactory::new(),
            'notifiable_type' => User::class,
            'data' => $this->faker->words(),
        ];
    }
}
