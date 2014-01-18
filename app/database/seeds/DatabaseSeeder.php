<?php

class DatabaseSeeder extends Seeder {

    public function run() {
        Eloquent::unguard();
        $this->call('SkillTableSeeder');
        $this->call('PrerequisiteTableSeeder');
    }

}

class SkillTableSeeder extends Seeder {

    public function run() {
        $data = array(
            array('basic',       'basic programming'),
            array('oop',         'oop programming'),
            array('functional',  'functional programming'),
            array('logic',       'logic programming'),
            array('concurrent',  'concurrent programming'),
            array('sysprog',     'system programming'),
            array('regex',       'regular expression'),
            array('netsecure',   'network security'),
            array('datastruct',  'data structure'),
            array('db',          'database'),
            array('mining',      'data mining'),
            array('mvc',         'model view controller'),
            array('mobile',      'mobile application'),
            array('webapp',      'web application'),
            array('comarch',     'computer architecture'),
            array('ai',          'artificial intelligence'),
            array('algo',        'algorithm'),
            array('complr',      'compiler'),
        );

        foreach ($data as list($abbr, $name)) {
            Skill::create(array('abbr' => $abbr, 'name' => $name));
        }
    }

}

class PrerequisiteTableSeeder extends Seeder {

    public function run() {
        function s($abbr) {
            return Skill::whereAbbr($abbr)->first()->id;
        }

        $data = array(
            array(s('algo'),        s('basic')),
            array(s('functional'),  s('basic')),
            array(s('logic'),       s('functional')),
            array(s('ai'),          s('logic')),
            array(s('ai'),          s('db')),
            array(s('db'),          s('datastruct')),
            array(s('mining'),      s('db')),
            array(s('mining'),      s('regex')),
            array(s('oop'),         s('basic')),
            array(s('mvc'),         s('oop')),
            array(s('mvc'),         s('db')),
            array(s('mobile'),      s('mvc')),
            array(s('webapp'),      s('mvc')),
            array(s('concurrent'),  s('basic')),
            array(s('concurrent'),  s('comarch')),
            array(s('sysprog'),     s('concurrent')),
            array(s('netsecure'),   s('sysprog')),
            array(s('complr'),      s('sysprog')),
            array(s('complr'),      s('regex')),
        );

        foreach ($data as list($rid, $sid)) {
            Prerequisite::create(array('rid' => $rid, 'sid' => $sid));
        }
    }

}
