<?php if (!defined('HIDESOURCE')) exit ('No direct script access allowed.');


function contents($file, $find_replaces=null) {
    $string = file_get_contents($file);
    if (!is_null($find_replaces)) {
        return str_replace(
            array_keys($find_replaces),
            array_values($find_replaces),
            $string
        );
    }
    return $string;
}


/* XXX deprecated ?
class Skill {
    protected $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    function tree() {
        $rskill = [];
        $sql = "SELECT * FROM skill_requirement";
        foreach ($this->db->query($sql) as $row) {
            $rid = $row['rid'];
            $sid = $row['sid'];
            if (empty ($rskill[$rid])) {
                $rskill[$rid] = [];
            }
            $rskill[$rid][$sid] = false;
        }
        return $rskill;
    }
}
$skill = new Skill();
*/


class User {
    protected $db;

    public static function all() {
        global $db;
        $users = [];
        $sql = contents('sql/show_users.sql');
        foreach ($db->query($sql) as $row) {
            $users[] = ['uid' => $row['uid'], 'name' => $row['name']];
        }
        return $users;
    }

    public function __construct($uid) {
        global $db;
        $this->db = $db;
        $this->uid = $uid;

        $sql = contents('sql/user_more.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $this->name = $row['name'];
            $this->more = $row['more'];
        }
    }

    public function add_skill($sid) {
        $sql = contents('sql/user_add_skill.sql', ['{sid}' => $sid,
                                                   '{uid}' => $this->uid]);
        return $this->db->query($sql);
    }

    public function reset_all() {
        $sql = contents('sql/user_reset_all.sql', ['{uid}' => $this->uid]);
        return $this->db->query($sql);
    }

    public function skilled() {
        $skills = [];
        $sql = contents('sql/user_skilled.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = 'skilled';
        }
        return $skills;
    }

    public function unskilled() {
        $skills = [];
        $sql = contents('sql/user_unskilled.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = 'unskilled';
        }
        return $skills;
    }

    public function unobtainable() {
        $skills = [];
        $sql = contents('sql/user_unobtainable.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = 'unobtainable';
        }
        return $skills;
    }

    public function skills_status() {
        $skills = $this->skilled();
        $skills += $this->unobtainable();
        $skills += $this->unskilled();
        return $skills;
    }
}
