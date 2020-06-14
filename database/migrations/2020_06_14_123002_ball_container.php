<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BallContainer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->integer("container_setting_id");
            $table->timestamps();
        });

        Schema::create('container_setting', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->integer("is_verified");
            $table->bigInteger("limit")->default(5);
            $table->timestamps();
        });
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
