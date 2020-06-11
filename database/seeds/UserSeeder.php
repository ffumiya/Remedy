<?php

use App\Models\User;
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
        factory(User::class, 10)->create();
        User::create([
            'name' => 'remedy',
            'email' => 'remedy@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'api_token' => 'remedy_token',
            'remember_token' => Str::random(10),
        ]);
    }
}
