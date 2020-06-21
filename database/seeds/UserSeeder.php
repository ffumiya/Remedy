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
        factory(User::class, 20)->create();

        $now = new DateTIme();
        User::insert([
            [
                'name' => 'm-tanaka',
                'email' => 'm-tanaka@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => config('role.admin.value'),
                'api_token' => str_random(60),
                'remember_token' => Str::random(10),
                'clinic_id' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'patient',
                'email' => 'patient@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => config('role.patient.value'),
                'api_token' => null,
                'remember_token' => Str::random(10),
                'api_token' => str_random(60),
                'clinic_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'doctor',
                'email' => 'doctor@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => config('role.doctor.value'),
                'api_token' => null,
                'remember_token' => Str::random(10),
                'api_token' => str_random(60),
                'clinic_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
    }
}
