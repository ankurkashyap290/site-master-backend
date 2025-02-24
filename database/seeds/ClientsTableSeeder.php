<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Client\Client::class)->make([
            'facility_id' => 1,
        ])->save(['unprotected' => true]);

        factory(\App\Models\Client\Client::class)->make([
            'facility_id' => 1,
        ])->save(['unprotected' => true]);

        factory(\App\Models\Client\Client::class)->make([
            'facility_id' => 1,
        ])->save(['unprotected' => true]);

        factory(\App\Models\Client\Client::class)->make([
            'facility_id' => 2,
        ])->save(['unprotected' => true]);
    }
}
