<?php

use App\Models\Location\Location;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Location::class)->make(['facility_id' => 1])->save(['unprotected' => true]);
        factory(Location::class)->make(['facility_id' => 1])->save(['unprotected' => true]);
        factory(Location::class)->make(['facility_id' => 1, 'one_time' => true])->save(['unprotected' => true]);
        factory(Location::class)->make(['facility_id' => 2])->save(['unprotected' => true]);
    }
}
