<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::unguard();
        if(!Province::find(1)) {
            $path = __DIR__.'/sql-script/province.sql';
            DB::unprepared(file_get_contents($path));
            //$this->command->info('Country table seeded!');
        }
    }
}
