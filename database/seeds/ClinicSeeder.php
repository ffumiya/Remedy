<?php

use App\Models\Clinic;
use Illuminate\Database\Seeder;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();
        $tel = "000 - 000 - 0000";
        $address = "○○県○○市○○区○○○○";

        Clinic::insert([
            [
                Clinic::NAME => "日本第一病院",
                Clinic::TEL => $tel,
                Clinic::ADDRESS => $address,
                CLINIC::CREATED_AT => $now,
                CLINIC::UPDATED_AT => $now
            ],
            [
                Clinic::NAME => "日本第二病院",
                Clinic::TEL => $tel,
                Clinic::ADDRESS => $address,
                CLINIC::CREATED_AT => $now,
                CLINIC::UPDATED_AT => $now
            ],
            [
                Clinic::NAME => "日本第三病院",
                Clinic::TEL => $tel,
                Clinic::ADDRESS => $address,
                CLINIC::CREATED_AT => $now,
                CLINIC::UPDATED_AT => $now
            ],

        ]);
    }
}
