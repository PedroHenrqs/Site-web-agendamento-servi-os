<?php

namespace Database\Seeders;

use App\Models\Availability;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        $horarios = ["09:00", "10:00", "11:00", "14:00", "15:00", "16:00"];

        for ($dia = 1; $dia <= 5; $dia++) {
            $data = Carbon::today()->addDays($dia)->toDateString();

            foreach ($horarios as $hora) {
                Availability::firstOrCreate(
                    ["date" => $data, "time" => $hora],
                    ["available" => true]
                );
            }
        }
    }
}
