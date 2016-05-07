<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core__activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subject_id')->index();
            $table->string('subject_type')->index();
            $table->string('name');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('template');
            $table->enum('privacy', ['public', 'protected', 'private']);
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('core__activities');
    }
}
