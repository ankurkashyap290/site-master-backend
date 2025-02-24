<?php

use Illuminate\Database\Migrations\Migration;

use App\Models\Color;

class UpdateColors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (Config::get('colors') as $id => $data) {
            $color = Color::find($id);
            if (!$color) {
                continue;
            }
            $color->value = $data['value'];
            $color->type = $data['type'];
            $color->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
