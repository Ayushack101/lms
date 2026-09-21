<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Content;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Content
        |--------------------------------------------------------------------------
        */

        $contents = [
            [
                'content_name' => 'Supplement',
                'allow' => 'teacher',
            ],
            [
                'content_name' => 'Capstone Project',
                'allow' => 'teacher',
            ],
            [
                'content_name' => 'Bridge Course',
                'allow' => 'teacher',
            ],
            [
                'content_name' => 'Software Download Link',
                'allow' => 'teacher',
            ],
            [
                'content_name' => 'Practice Worksheet Student',
                'allow' => 'student',
            ],
            [
                'content_name' => 'Practice Worksheet Teacher',
                'allow' => 'teacher',
            ],
            [
                'content_name' => 'Test Paper Generator',
                'allow' => 'teacher',
            ],
            [
                'content_name' => 'Lesson Plan',
                'allow' => 'teacher',
            ],
            [
                'content_name' => 'Answer Key',
                'allow' => 'teacher',
            ],
            [
                'content_name' => 'Topic Animation',
                'allow' => 'both',
            ],
        ];

        foreach ($contents as $content) {
            Content::updateOrCreate(
                ['content_name' => $content['content_name']],
                ['allow' => $content['allow']]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Admin User
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            ['email' => 'admin123@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin123$bakugo'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
