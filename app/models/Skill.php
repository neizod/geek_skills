<?php

class Skill extends Eloquent {

    protected $fillable = array('abbr', 'name');

    public function prerequisites() {
        return $this->belongsToMany('Skill', 'prerequisites', 'rid', 'sid');
    }

    public function foreruns() {
        return $this->belongsToMany('Skill', 'prerequisites', 'sid', 'rid');
    }

}
