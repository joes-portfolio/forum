<?php

namespace Database\Factories;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{
    protected $model = Channel::class;

    public function definition(): array
    {
        $name = $this->faker->words(random_int(1, 3), true);

        return [
            'name' => $name,
            'slug' => str($name)->slug(),
        ];
    }
}
