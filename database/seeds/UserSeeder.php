<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                User::NAME => '管理者用アカウント',
                User::SEX => 1,
                User::HEIGHT => 170,
                User::WEIGHT => 65,
                User::EMAIL => 'admin@example.com',
                User::EMAIL_VERIFIED_AT => now(),
                User::PASSWORD => Hash::make($password),
                User::ROLE => config('role.admin.value'),
                User::API_TOKEN => str_random(60),
                User::REMEMBER_TOKEN => Str::random(10),
                User::CLINIC_ID => 1,
                USER::CREATED_AT => $now,
                USER::UPDATED_AT => $now
            ],
            [
                User::NAME => '患者用テストアカウント',
                User::SEX => 1,
                User::HEIGHT => 170,
                User::WEIGHT => 65,
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
                User::NAME => '医師用テストアカウント',
                User::SEX => 1,
                User::HEIGHT => 170,
                User::WEIGHT => 65,
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
