<?php

use Illuminate\Database\Migrations\Migration;

class Skillrequirement extends Migration {

    public function up() {
        Schema::create('prerequisites', function($table) {
            $table->increments('id');
            $table->integer('rid')->unsigned();
            $table->integer('sid')->unsigned();
            $table->foreign('rid')->references('id')->on('skills');
            $table->foreign('sid')->references('id')->on('skills');
            $table->unique(array('rid', 'sid'));
            $table->timestamps();
        });
        Schema::table('skills', function($table) {
            $table->string('abbr')->after('id');
        });
    }

    public function down() {
        Schema::drop('prerequisites');
        Schema::table('skills', function($table) {
            $table->dropColumn('abbr');
        });
    }

}
