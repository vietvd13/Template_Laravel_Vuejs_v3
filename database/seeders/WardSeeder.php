<?php

namespace Database\Seeders;

use App\Models\Ward;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ward::unguard();
        if(!Ward::find(1)) {
            $path = __DIR__.'/sql-script/ward.sql';
            DB::unprepared(file_get_contents($path));
            //$this->command->info('Country table seeded!');
        }
    }
}
