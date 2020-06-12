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
                "name" => "clinic1",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "name" => "clinic2",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "name" => "clinic3",
                "created_at" => $now,
                "updated_at" => $now
            ],

        ]);
    }
}
