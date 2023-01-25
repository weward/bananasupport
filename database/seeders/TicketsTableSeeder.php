<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::beginTransaction();

        try {
            // Closed tickets
            Ticket::factory()->closed()->count(700)->hasComments(3)->create();
            // Open tickets (with comments)
            Ticket::factory()->open()->count(300)->hasComments(3)->create();
            // Open tickets (without comments)
            Ticket::factory()->open()->count(200)->create();

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();

            echo "FAILED seeding 'tickets' table! \n -> {$th->getMessage()}";
        }
    }
}
