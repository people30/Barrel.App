<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    protected $tables = [
        'prefectures',
        'areas',
        'cities',
        'brewers',
        'brewer_post_categories',
        'links',
        'designations',
        'tastes',
        'sakes',
        'sizes'
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
            \DB::statement(file_get_contents(database_path('queries/' . $this->tables[$i] . '.create.sql')));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        for($i = count($this->tables) - 1; $i >= 0 ; $i--)
        {
            \Schema::drop($this->tables[$i]);
        }
    }
}
