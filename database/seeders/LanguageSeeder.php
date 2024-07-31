<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::query()
            ->insert([
                [
                    'name' => 'Azerbaycan',
                    'code' => 'AZE'
                ],
                [
                    'name' => 'English',
                    'code' => 'EN'
                ],
                [
                    'name' => 'Turkish',
                    'code' => 'TR'
                ],
                [
                    'name' => 'Russion',
                    'code' => 'RU'
                ],
            ]);
    }
}
