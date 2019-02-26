<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // \DB::statement(file_get_contents(database_path('queries/tables.create.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        \DB::drop('sizes');
        \DB::drop('sakes');
        \DB::drop('tastes');
        \DB::drop('designations');
        \DB::drop('links');
        \DB::drop('brewer_post_categories');
        \DB::drop('featured_brewers');
        \DB::drop('brewers');
        \DB::drop('cities');
        \DB::drop('areas');
        \DB::drop('prefectures');
    }
}
