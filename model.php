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


class Summary {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function nos_users() {
        $sql = contents('sql/summary_nos_users.sql');
        foreach ($this->db->query($sql) as $row) {
            return $row['number'];
        }
    }

    public function nos_all_skills() {
        $sql = contents('sql/summary_nos_all_skills.sql');
        foreach ($this->db->query($sql) as $row) {
            return $row['number'];
        }
    }

    public function max_achievements() {
        $sql = contents('sql/summary_max_achvs.sql');
        foreach ($this->db->query($sql) as $row) {
            return $row['maximum'];
        }
    }

    public function avg_skills() {
        $sql = contents('sql/summary_avg_skills.sql');
        foreach ($this->db->query($sql) as $row) {
            return $row['average'];
        }
    }

    public function avg_languages() {
        $sql = contents('sql/summary_avg_langs.sql');
        foreach ($this->db->query($sql) as $row) {
            return $row['average'];
        }
    }

    public function avg_frameworks() {
        $sql = contents('sql/summary_avg_frames.sql');
        foreach ($this->db->query($sql) as $row) {
            return $row['average'];
        }
    }

    public function top_skills($nos) {
        $skills = [];
        $sql = contents('sql/summary_top_skills.sql', ['{nos}' => $nos]);
        foreach ($this->db->query($sql) as $row) {
            $skills[] = $row;
        }
        return $skills;
    }

    public function top_languages($nos) {
        $languages = [];
        $sql = contents('sql/summary_top_langs.sql', ['{nos}' => $nos]);
        foreach ($this->db->query($sql) as $row) {
            $languages[] = $row;
        }
        return $languages;
    }
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


    public function update_user($detail) {
        $this->more = $detail;
        $detail = $this->db->escape_string($detail);
        $sql = contents('sql/update_user_detail.sql', ['{uid}' => $this->uid,
                                                       '{detail}' => $detail]);
        if (!$this->db->query($sql)) {
            exit ('could not update database');
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
        return $this->db->multi_query($sql);
    }

    public function skilled() {
        $skills = [];
        $sql = contents('sql/user_skilled.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = ['stat' => 'skilled', 'name' => $row['name']];
        }
        return $skills;
    }

    public function learnable() {
        $skills = [];
        $sql = contents('sql/user_learnable.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = ['stat' => 'learnable', 'name' => $row['name']];
        }
        return $skills;
    }

    public function unforgettable() {
        $skills = [];
        $sql = contents('sql/user_unforgettable.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = ['stat' => 'unforgettable', 'name' => $row['name']];
        }
        return $skills;
    }

    public function unobtainable() {
        $skills = [];
        $sql = contents('sql/user_unobtainable.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $sid = $row['sid'];
            $skills[$sid] = ['stat' => 'unobtainable', 'name' => $row['name']];
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


    public function click_language($lid) {
        $sql = contents('sql/user_sel_lang.sql', ['{lid}' => $lid,
                                                  '{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $data_exists) {
            return $this->del_language($lid);
        }
        return $this->add_language($lid);
    }

    public function add_language($lid) {
        $sql = contents('sql/user_add_lang.sql', ['{lid}' => $lid,
                                                  '{uid}' => $this->uid]);
        return $this->db->query($sql);
    }

    public function del_language($lid) {
        $sql = contents('sql/user_del_lang.sql', ['{lid}' => $lid,
                                                  '{uid}' => $this->uid]);
        return $this->db->query($sql);
    }

    public function codable() {
        $languages = [];
        $sql = contents('sql/user_codable.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $lid = $row['lid'];
            $languages[$lid] = $row['name'];
        }
        return $languages;
    }

    public function readable() {
        $languages = [];
        $sql = contents('sql/user_readable.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $lid = $row['lid'];
            $languages[$lid] = $row['name'];
        }
        return $languages;
    }

    public function language_dependencies() {
        $languages = [];
        $sql = contents('sql/user_lang_depend.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $lid = $row['lid'];
            $languages[$lid] = $row['name'];
        }
        return $languages;
    }


    public function click_framework($fid) {
        $sql = contents('sql/user_sel_frame.sql', ['{fid}' => $fid,
                                                   '{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $data_exists) {
            return $this->del_framework($fid);
        }
        return $this->add_framework($fid);
    }

    public function add_framework($fid) {
        $sql = contents('sql/user_add_frame.sql', ['{fid}' => $fid,
                                                   '{uid}' => $this->uid]);
        return $this->db->query($sql);
    }

    public function del_framework($fid) {
        $sql = contents('sql/user_del_frame.sql', ['{fid}' => $fid,
                                                   '{uid}' => $this->uid]);
        return $this->db->query($sql);
    }

    public function buildable() {
        $languages = [];
        $sql = contents('sql/user_buildable.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $fid = $row['fid'];
            $languages[$fid] = $row['name'];
        }
        return $languages;
    }

    public function experimentable() {
        $languages = [];
        $sql = contents('sql/user_experimentable.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $fid = $row['fid'];
            $languages[$fid] = $row['name'];
        }
        return $languages;
    }

    public function framework_requirement() {
        $framworks = [];
        $sql = contents('sql/user_frame_require.sql', ['{uid}' => $this->uid]);
        foreach ($this->db->query($sql) as $row) {
            $fid = $row['fid'];
            $framworks[$fid] = $row['name'];
        }
        return $framworks;
    }
}
