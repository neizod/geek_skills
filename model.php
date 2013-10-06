<?php if (!defined('HIDESOURCE')) exit ('No direct script access allowed.');


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


class User {
    protected $db;

    public function __construct($uid) {
        global $db;
        $this->db = $db;
        $this->uid = $uid;
    }

    public function add_skill($sid) {
        $sql = "INSERT INTO user_skill VALUES ({$this->uid}, $sid)";
        $this->db->query($sql);
    }

    public function reset_all() {
        $sql = "DELETE FROM user_achievement WHERE uid={$this->uid}";
        $this->db->query($sql);
        $sql = "DELETE FROM user_skill WHERE uid={$this->uid}";
        $this->db->query($sql);
    }

    public function skilled() {
        $skills = [];
        $sql = file_get_contents('sql/user_skilled.sql');
        $sql = str_replace('{uid}', $this->uid, $sql);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = 'skilled';
        }
        return $skills;
    }

    public function unskilled() {
        $skills = [];
        $sql = file_get_contents('sql/user_unskilled.sql');
        $sql = str_replace('{uid}', $this->uid, $sql);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = null;
        }
        return $skills;
    }

    public function unobtainable() {
        $skills = [];
        $sql = file_get_contents('sql/user_unobtainable.sql');
        $sql = str_replace('{uid}', $this->uid, $sql);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = 'n/a';
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
