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

        Clinic::insert([
            [
                Clinic::NAME => "clinic1",
                CLINIC::CREATED_AT => $now,
                CLINIC::UPDATED_AT => $now
            ],
            [
                Clinic::NAME => "clinic2",
                CLINIC::CREATED_AT => $now,
                CLINIC::UPDATED_AT => $now
            ],
            [
                Clinic::NAME => "clinic3",
                CLINIC::CREATED_AT => $now,
                CLINIC::UPDATED_AT => $now
            ],

        ]);
    }
}
