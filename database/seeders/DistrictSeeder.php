<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::unguard();
        if(!District::find(1)) {
            $path = __DIR__.'/sql-script/district.sql';
            DB::unprepared(file_get_contents($path));
            //$this->command->info('Country table seeded!');
        }
    }
}
