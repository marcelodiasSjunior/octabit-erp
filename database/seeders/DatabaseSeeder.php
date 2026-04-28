<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TagSeeder::class,
            ClientSeeder::class,
            ServiceSeeder::class,
            ProductSeeder::class,
            PipelineSeeder::class,
            FollowupSLASeeder::class,
            FollowupRuleSeeder::class,
        ]);
    }
}
