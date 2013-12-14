<?php

class DatabaseSeeder extends Seeder {

    public function run() {
        Eloquent::unguard();
        $this->call('SkillTableSeeder');
    }

}

class SkillTableSeeder extends Seeder {

    public function run() {
        Skill::create(array('name' => 'basic programming'));
        Skill::create(array('name' => 'oop programming'));
        Skill::create(array('name' => 'functional programming'));
        Skill::create(array('name' => 'logic programming'));
        Skill::create(array('name' => 'concurrent programming'));
        Skill::create(array('name' => 'system programming'));
        Skill::create(array('name' => 'regular expression'));
        Skill::create(array('name' => 'network security'));
        Skill::create(array('name' => 'data structure'));
        Skill::create(array('name' => 'database'));
        Skill::create(array('name' => 'data mining'));
        Skill::create(array('name' => 'model view controller'));
        Skill::create(array('name' => 'mobile application'));
        Skill::create(array('name' => 'web application'));
        Skill::create(array('name' => 'computer architecture'));
        Skill::create(array('name' => 'artificial intelligence'));
        Skill::create(array('name' => 'algorithm'));
        Skill::create(array('name' => 'compiler'));
    }

}
