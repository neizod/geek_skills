<?php

use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface {

    protected $fillable = array('name', 'gh_id');

    public function getAuthIdentifier() {
        return $this->getKey();
    }

    public function getAuthPassword() {
        return $this->password;
    }

    public function skills() {
        return $this->belongsToMany('Skill', 'learnings', 'uid', 'sid');
    }

    public function tree() {
        $tree = array_fill_keys($this->skills->lists('id'), 0b11);
        foreach (Prerequisite::all() as $p) {
            $r = @$tree[$p->rid];
            $s = @$tree[$p->sid];
            if ($r & 0b10) {
                $tree[$p->sid] = 0b10;
            } else if ($s & 0b10 and ($r == 0b01 or is_null($r))) {
                $tree[$p->rid] = 0b01;
            } else {
                $tree[$p->rid] = 0b00;
            }
        }
        $tree += array_fill(1, Skill::count(), 0b01);
        return $tree;
    }

}
