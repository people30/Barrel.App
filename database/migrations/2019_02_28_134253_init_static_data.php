<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitStaticData extends Migration
{
    protected $tables = [
        'designations',
        'prefectures',
        'areas',
        'tastes'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        for($i = 0; $i < count($this->tables); $i++)
        {
            \DB::statement(file_get_contents(database_path('queries/' . $this->tables[$i] . '.insert_static_data.sql')));
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
        try
        {
            \DB::statement('set foreign_key_checks = 0');

            for($i = 0; $i < count($this->tables); $i++)
            {
                \DB::table($this->tables[$i])->truncate();
            }
        }
        catch(\Throwable $th)
        {
            throw $th;
        }
        finally
        {
            \DB::statement('set foreign_key_checks = 1');
        }
    }
}
