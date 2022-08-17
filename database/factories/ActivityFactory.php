<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        $subjectIds = [
            'reply' => ReplyFactory::new(),
            'thread' => ThreadFactory::new(),
        ];

        $subjectTypes = [
            'reply' => Reply::class,
            'thread' => Thread::class,
        ];

        $subject = $this->faker->randomElement(array_keys($subjectIds));

        return [
            'user_id' => UserFactory::new(),
            'type' => 'created_' . $subject,
            'subject_id' => $subjectIds[$subject],
            'subject_type' => $subjectTypes[$subject],
        ];
    }
}
