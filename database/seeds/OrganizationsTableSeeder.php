<?php

use App\Models\Organization\Organization;
use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    public function run()
    {
        $organization = new Organization();
        $organization->name = 'Silver Pine Ltd.';
        $organization->facility_limit = 3;
        $organization->save(['unprotected' => true]);

        $organization = new Organization();
        $organization->name = 'Golden Years Inc.';
        $organization->save(['unprotected' => true]);
    }
}
