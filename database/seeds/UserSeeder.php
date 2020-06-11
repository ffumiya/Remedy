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

        $now = new DateTIme();
        User::insert([
            [
                'name' => 'm-tanaka',
                'email' => 'm-tanaka@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => config('role.admin'),
                'api_token' => 'token',
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'patient',
                'email' => 'patient@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => config('role.patient'),
                'api_token' => null,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'doctor',
                'email' => 'doctor@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => config('role.doctor'),
                'api_token' => null,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
