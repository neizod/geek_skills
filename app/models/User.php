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

}
