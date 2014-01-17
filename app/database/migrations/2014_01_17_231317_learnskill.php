<?php

use Illuminate\Database\Migrations\Migration;

class Learnskill extends Migration {

    public function up() {
        Schema::create('learnings', function($table) {
            $table->increments('id');
            $table->integer('uid')->unsigned();
            $table->integer('sid')->unsigned();
            $table->foreign('uid')->references('id')->on('users');
            $table->foreign('sid')->references('id')->on('skills');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('learnings');
    }

}
