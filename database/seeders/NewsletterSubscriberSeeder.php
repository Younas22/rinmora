<?php
// database/seeders/NewsletterSubscriberSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsletterSubscriber;

class NewsletterSubscriberSeeder extends Seeder
{
    public function run(): void
    {
        $subscribers = [
            [
                'email' => 'john.doe@example.com',
                'status' => 'active',
                'joined_date' => now()->subDays(30)
            ],
            [
                'email' => 'jane.smith@example.com',
                'status' => 'active',
                'joined_date' => now()->subDays(15)
            ],
            [
                'email' => 'travel.lover@example.com',
                'status' => 'active',
                'joined_date' => now()->subDays(60)
            ],
            [
                'email' => 'old.subscriber@example.com',
                'status' => 'unsubscribed',
                'joined_date' => now()->subDays(90)
            ],
            [
                'email' => 'inactive.user@example.com',
                'status' => 'inactive',
                'joined_date' => now()->subDays(45)
            ]
        ];

        foreach ($subscribers as $subscriber) {
            NewsletterSubscriber::create($subscriber);
        }
    }
}