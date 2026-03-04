<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Translation;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = ['en', 'fr', 'es'];
        $tags = ['mobile', 'desktop', 'web'];

        Translation::factory()
            ->count(100000)
            ->create([
                'locale' => fake()->randomElement($locales),
                'tags' => [fake()->randomElement($tags)]
            ]);
    }
}
