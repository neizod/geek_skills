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


class User {
    protected $db;

    public static function show_all() {
        global $db;
        $users = [];
        $sql = contents('sql/show_users.sql');
        foreach ($db->query($sql) as $row) {
            $users[] = ['uid' => $row['uid'], 'name' => $row['name']];
        }
        return $users;
    }

    public static function create($name) {
        global $db;
        $name = $db->escape_string($name);
        $sql = contents('sql/create_user.sql', ['{name}' => $name]);
        if ($db->query($sql)) {
            return $db->insert_id;
        }
        return 0;
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
        if (!isset ($this->name)) {
            $this->name = 'none';
            $this->more = '/!\\ the user for this uid does not exists';
        }
    }

    public function click_skill($sid) {
        $sql = contents('sql/user_sel_skill.sql', ['{sid}' => $sid,
                                                   '{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $data_exists) {
            return $this->del_skill($sid);
        }
        return $this->add_skill($sid);
    }

    public function add_skill($sid) {
        $sql = contents('sql/user_add_skill.sql', ['{sid}' => $sid,
                                                   '{uid}' => $this->uid]);
        return $this->db->query($sql);
    }

    public function del_skill($sid) {
        $sql = contents('sql/user_del_skill.sql', ['{sid}' => $sid,
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

    public function learnable() {
        $skills = [];
        $sql = contents('sql/user_learnable.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = 'learnable';
        }
        return $skills;
    }

    public function unforgettable() {
        $skills = [];
        $sql = contents('sql/user_unforgettable.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = 'unforgettable';
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
        $skills = $this->unforgettable();
        $skills += $this->skilled();
        $skills += $this->unobtainable();
        $skills += $this->learnable();
        return $skills;
    }

    public function achievements() {
        $achievements = [];
        $sql = contents('sql/user_achievements.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $achievements[] = $row;
        }
        return $achievements;
    }
}
