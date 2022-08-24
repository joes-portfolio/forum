<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Reply;
use App\Models\Thread;
use Database\Factories\ActivityFactory;
use Database\Factories\ChannelFactory;
use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \Artisan::call('cache:clear');

        $users = UserFactory::new()
            ->count(10)
            ->sequence(function () {
                $date = now()->subDays(random_int(7, 8));

                return [
                    'created_at' => $date,
                    'updated_at' => $date,
                ];
            })
            ->create();

        $users[1]->update(['email' => 'john@mail.com']);
        $users[2]->update(['email' => 'jane@mail.com']);

        $channels =  ChannelFactory::new()
            ->count(5)
            ->create();

        $userIds = array_flip($users->pluck('id')->toArray());
        $channelIds = array_flip($channels->pluck('id')->toArray());

        foreach ($users as $user) {
            $threads = ThreadFactory::new()
                ->state([
                    'user_id' => $user->id,
                    'channel_id' => array_rand($channelIds)
                ])
                ->sequence(function () {
                    $date = now()->subDays(random_int(5, 7));
                    return [
                        'created_at' => $date,
                        'updated_at' => $date,
                    ];
                })
                ->has(
                    ActivityFactory::new()
                        ->state(fn (array $attributes, Thread $thread) => [
                            'type' => 'created_thread',
                            'user_id' => $thread->user_id,
                            'created_at' => $thread->created_at,
                            'updated_at' => $thread->created_at,
                        ]),
                )
                ->count(3)
                ->create();

            foreach ($threads as $thread) {
                ReplyFactory::new()
                    ->state(['thread_id' =>$thread->id])
                    ->sequence(function () use ($userIds) {
                        $date = now()->subDays(random_int(4, 5));
                        return [
                            'user_id' => array_rand($userIds),
                            'created_at' => $date,
                            'updated_at' => $date,
                        ];
                    })
                    ->has(
                        ActivityFactory::new()
                            ->state(fn (array $attributes, Reply $reply) => [
                                'user_id' => $reply->user_id,
                                'type' => 'created_reply',
                                'created_at' => $reply->created_at,
                                'updated_at' => $reply->created_at,
                            ])
                    )
                    ->count(random_int(1, 4))
                    ->create();
            }
        }
    }
}
