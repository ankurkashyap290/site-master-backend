<?php

use App\Models\Organization\Facility;
use Illuminate\Database\Seeder;

class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Facility::class)->make([
            'name' => 'Evergreen Retirement Home',
            'organization_id'=> 1,
        ])->save(['unprotected' => true]);

        factory(Facility::class)->make([
            'name' => 'Silver Leaves Retirement Home',
            'organization_id'=> 1,
        ])->save(['unprotected' => true]);

        factory(Facility::class)->make([
            'name' => 'Golden Apple Retirement Home',
            'organization_id'=> 2,
        ])->save(['unprotected' => true]);
    }
}
