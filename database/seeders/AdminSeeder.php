<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
         $admin =
            [
                [
                    'name' => 'Admin',
                    'email' =>'admin@admin.com',
                    'password' => Hash::make('admin@ujjivan'),
                    'role' => 'admin'
                ],
                [
                    'name' => 'Ujjivan',
                    'email' =>'user@ujjivan.com',
                    'password' => Hash::make('ujjivan'),
                    'role' => 'ujjivan'
                ],
                [
                    'name' => 'Super Admin',
                    'email' =>'superadmin@netiapps.com',
                    'password' => Hash::make('Notices@netiapps'),
                    'role' => 'ujjivan'
                ],
                
            
            ];

             foreach ($admin as $key => $value) {
               $user = User::create($value);
             }
    }
}
