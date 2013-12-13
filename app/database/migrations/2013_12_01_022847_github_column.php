<?php

use Illuminate\Database\Migrations\Migration;

class GithubColumn extends Migration {

    public function up() {
        Schema::table('users', function($table) {
            $table->dropColumn('email');
            $table->integer('gh_id')->unique();
        });
    }

    public function down() {
        Schema::table('users', function($table) {
            $table->dropColumn('gh_id');
            $table->string('email')->unique();
        });
    }

}
