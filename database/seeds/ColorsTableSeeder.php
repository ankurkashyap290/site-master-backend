<?php

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Config::get('colors') as $id => $data) {
            $color = new \App\Models\Color();
            $color->id = $id;
            $color->value = $data['value'];
            $color->type = $data['type'];
            $color->save();
        }
    }
}
