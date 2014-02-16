<?php

class User extends Eloquent {

    protected $fillable = array('name', 'gh_id');

    public function skills() {
        return $this->belongsToMany('Skill', 'learnings', 'uid', 'sid');
    }

}
