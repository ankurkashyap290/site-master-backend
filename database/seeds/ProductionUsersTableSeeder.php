<?php

use Illuminate\Database\Seeder;

class ProductionUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class)->make([
            'id' => 1,
            'first_name' => 'Jonathan',
            'middle_name' => '',
            'last_name' => 'Thompson',
            'email' => 'jonathan@journeytransportation.com',
            'password' => Hash::make('Whiskey1096!'),
            'role_id' => Config::get('roles')['Super Admin'],
            'organization_id' => null
        ])->save(['unprotected' => true]);
    }
}
