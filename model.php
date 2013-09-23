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

    public function skills() {
        $skills = [];
        $sql = "SELECT * FROM user_skill us WHERE us.uid = {$this->uid}";
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = 'skilled';
        }
        return $skills;
    }

    public function skills_status() {
        global $skill;
        $tree = $skill->tree();
        $skills = $this->skills();

        foreach (array_keys($skills) as $sid) {
            unset ($tree[$sid]);
        }
        foreach ($tree as &$node) {
            foreach (array_keys($skills) as $sid) {
                unset ($node[$sid]);
            }
            $node = empty ($node) ? null : 'n/a' ;
        }
        return $skills + $tree;
    }
}
