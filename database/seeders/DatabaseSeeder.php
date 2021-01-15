<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;
use PharIo\Manifest\Email;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user1 = \App\Models\User::factory()->create([
            'email' => 'jane@doe.com'
        ]);

        $user2 = \App\Models\User::factory()->create([
            'email' => 'jon@doe.com'
        ]);
        $channel1 = \App\Models\Channel::factory()->create([
            'user_id' =>$user1->id
        ]);
        $channel2 = \App\Models\Channel::factory()->create([
            'user_id' =>$user2->id
        ]);
    }
}
