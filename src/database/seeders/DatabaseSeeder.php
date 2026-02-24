<?php

namespace Database\Seeders;

use App\Enums\ColocationStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
    {
        
        User::factory()->create([
            'name' => 'Lahcen Maskour',
            'email' => 'lahcen.maskour2003@gmail.com',
            'password' => Hash::make('lahcen123'),
            'role' => UserRole::ADMIN,
        ]);

        $categories = collect(['Lekra', 'Lmakla', 'Electricity', 'Internet'])
            ->map(fn($name) => Category::create(['name' => $name]));

        $coloc = Colocation::create([
            'name' => 'Dar Dyalna',
            'status' => ColocationStatus::ACTIVE,
        ]);


        $ownerUser = User::factory()->create([
            'name' => 'Owner Lahcen',
            'email' => 'lahcen.maskour@gmail.com',
            'password' => Hash::make('lahcen123'),
        ]);

        Membership::create([
            'user_id' => $ownerUser->id,
            'colocation_id' => $coloc->id,
            'is_owner' => true,
            'reputation_score' => 5,
        ]);

        $memberUser = User::factory()->create([
            'name' => 'lahcen Member',
            'email' => 'lahcen.maskour203@gmail.com',
            'password' => Hash::make('lahcen123'),
        ]);

        Membership::create([
            'user_id' => $memberUser->id,
            'colocation_id' => $coloc->id,
            'is_owner' => false,
            'reputation_score' => 2,
        ]);


        Expense::factory(10)->create([
            'colocation_id' => $coloc->id,
            'payer_id' => $ownerUser->id,
            'category_id' => $categories->random()->id,
        ]);
    }
}
