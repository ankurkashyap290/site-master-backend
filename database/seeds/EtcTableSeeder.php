<?php

use Illuminate\Database\Seeder;

use App\Models\ETC\ExternalTransportationCompany;

class EtcTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ExternalTransportationCompany::class)->make()->save(['unprotected' => true]);
        factory(ExternalTransportationCompany::class)->make()->save(['unprotected' => true]);
    }
}
