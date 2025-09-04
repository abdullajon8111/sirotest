<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user yaratish
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.uz',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Test user yaratish
        User::create([
            'name' => 'Test User',
            'email' => 'user@test.uz',
            'password' => Hash::make('12345678'),
            'role' => 'user',
            'is_active' => true,
        ]);

        // Kategoriyalar yaratish
        $mathCategory = Category::create([
            'name' => 'Matematika',
            'description' => 'Matematika fani bo\'yicha savollar',
            'is_active' => true,
        ]);

        $physicsCategory = Category::create([
            'name' => 'Fizika',
            'description' => 'Fizika fani bo\'yicha savollar',
            'is_active' => true,
        ]);

        $chemistryCategory = Category::create([
            'name' => 'Kimyo',
            'description' => 'Kimyo fani bo\'yicha savollar',
            'is_active' => true,
        ]);

        // Matematika savollari
        Question::create([
            'category_id' => $mathCategory->id,
            'question' => '2 + 2 = ?',
            'option_a' => '3',
            'option_b' => '4',
            'option_c' => '5',
            'option_d' => '6',
            'correct_answer' => 'b',
            'is_active' => true,
        ]);

        Question::create([
            'category_id' => $mathCategory->id,
            'question' => '5 * 6 = ?',
            'option_a' => '25',
            'option_b' => '30',
            'option_c' => '35',
            'option_d' => '40',
            'correct_answer' => 'b',
            'is_active' => true,
        ]);

        Question::create([
            'category_id' => $mathCategory->id,
            'question' => '100 / 4 = ?',
            'option_a' => '20',
            'option_b' => '25',
            'option_c' => '30',
            'option_d' => '35',
            'correct_answer' => 'b',
            'is_active' => true,
        ]);

        // Fizika savollari
        Question::create([
            'category_id' => $physicsCategory->id,
            'question' => 'Yorug\'lik tezligi necha m/s?',
            'option_a' => '299,792,458',
            'option_b' => '300,000,000',
            'option_c' => '299,792,458',
            'option_d' => '298,000,000',
            'correct_answer' => 'c',
            'is_active' => true,
        ]);

        Question::create([
            'category_id' => $physicsCategory->id,
            'question' => 'Tortishish tezlanishi qancha?',
            'option_a' => '9.8 m/s²',
            'option_b' => '10 m/s²',
            'option_c' => '9.6 m/s²',
            'option_d' => '9.9 m/s²',
            'correct_answer' => 'a',
            'is_active' => true,
        ]);

        // Kimyo savollari
        Question::create([
            'category_id' => $chemistryCategory->id,
            'question' => 'Suvning kimyoviy formulasi qanday?',
            'option_a' => 'H2O',
            'option_b' => 'CO2',
            'option_c' => 'NaCl',
            'option_d' => 'HCl',
            'correct_answer' => 'a',
            'is_active' => true,
        ]);

        Question::create([
            'category_id' => $chemistryCategory->id,
            'question' => 'Kislorodning kimyoviy belgisi?',
            'option_a' => 'O',
            'option_b' => 'K',
            'option_c' => 'H',
            'option_d' => 'N',
            'correct_answer' => 'a',
            'is_active' => true,
        ]);

        // Test yaratish
        Test::create([
            'title' => 'Umumiy bilim testi',
            'description' => 'Matematika, Fizika va Kimyo fanlaridan umumiy bilim testi',
            'categories_questions' => [
                $mathCategory->id => 2,
                $physicsCategory->id => 1,
                $chemistryCategory->id => 1,
            ],
            'duration_minutes' => 10,
            'start_time' => now(),
            'end_time' => now()->addDays(30),
            'max_attempts' => 3,
            'is_active' => true,
        ]);
    }
}
