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
        $password = 'password';
        User::insert([
            [
                User::NAME => 'm-tanaka',
                User::EMAIL => 'm-tanaka@example.com',
                User::EMAIL_VERIFIED_AT => now(),
                User::PASSWORD => Hash::make($password),
                User::ROLE => config('role.admin.value'),
                User::API_TOKEN => str_random(60),
                User::REMEMBER_TOKEN => Str::random(10),
                User::CLINIC_ID => 0,
                USER::CREATED_AT => $now,
                USER::UPDATED_AT => $now
            ],
            [
                User::NAME => 'patient',
                User::EMAIL => 'patient@example.com',
                User::EMAIL_VERIFIED_AT => now(),
                User::PASSWORD => Hash::make($password),
                User::ROLE => config('role.patient.value'),
                User::API_TOKEN => null,
                User::REMEMBER_TOKEN => Str::random(10),
                User::API_TOKEN => str_random(60),
                User::CLINIC_ID => 1,
                USER::CREATED_AT => $now,
                USER::UPDATED_AT => $now
            ],
            [
                User::NAME => 'doctor',
                User::EMAIL => 'doctor@example.com',
                User::EMAIL_VERIFIED_AT => now(),
                User::PASSWORD => Hash::make($password),
                User::ROLE => config('role.doctor.value'),
                User::API_TOKEN => null,
                User::REMEMBER_TOKEN => Str::random(10),
                User::API_TOKEN => str_random(60),
                User::CLINIC_ID => 1,
                USER::CREATED_AT => $now,
                USER::UPDATED_AT => $now
            ],
        ]);
    }
}
