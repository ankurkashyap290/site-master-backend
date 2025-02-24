<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Config::get('roles') as $name => $id) {
            $role = new \App\Models\Role();
            $role->id = $id;
            $role->name = $name;
            $role->save();
        }
    }
}
