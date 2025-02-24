<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(ColorsTableSeeder::class);
        if (App::environment('prod')) {
            $this->call(ProductionUsersTableSeeder::class);
            return;
        }
        $this->call(OrganizationsTableSeeder::class);
        $this->call(FacilitiesTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(EtcTableSeeder::class);
        $this->call(EventsTableSeeder::class);
    }
}
