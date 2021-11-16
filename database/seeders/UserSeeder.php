<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminEamil = "tonystark@ironman.ms";

        if(User::where('email', $adminEamil)->count() === 0) {
            User::create([
                'name'  => 'Tony Stark',
                'role'  => 'admin',
                'email'  => $adminEamil,
                'password'  => Hash::make('HelloJarvis'),
            ]);
        }
    }
}
