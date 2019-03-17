<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertMasterData extends Migration
{
    protected $tables = [
        'prefectures',
        'areas',
        'cities',
        'designations',
        'tastes',
        'brewers',
        'brewer_post_categories',
        'links',
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
            $filepath = database_path('queries/' . $this->tables[$i] . '.insert_master_data.sql');
            
            if(file_exists($filepath))
            {
                \DB::statement(file_get_contents($filepath));
            }
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
