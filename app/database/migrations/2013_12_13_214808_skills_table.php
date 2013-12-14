<?php

use Illuminate\Database\Migrations\Migration;

class SkillsTable extends Migration {

    public function up() {
        Schema::create('skills', function($table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::drop('skills');
    }

}
