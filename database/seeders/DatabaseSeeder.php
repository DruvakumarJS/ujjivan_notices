<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin =
            [
                [
                    'name' => 'SuperAdmin',
                    'email' =>'admin@admin.com',
                    'password' => Hash::make('admin')
                ],
                
            
            ];

             foreach ($admin as $key => $value) {
               $user = User::create($value);
             }
    }
}
