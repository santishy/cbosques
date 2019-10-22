<?php

use Illuminate\Database\Seeder;
use App\Cycle;
use Carbon\Carbon;
use App\Budget;


class CyclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Budget::truncate();
        // Cycle::truncate();
        $now = Carbon::now();
        Cycle::Create(['created_at'=>$now,'finalized_at'=>$now->addMonths(2),'active'=>1]);
    }
}
