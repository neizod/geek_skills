<?php

class HomeController extends BaseController {

    public function index() {
        return View::make('welcome');
    }

    public function skills() {
        return View::make('skills');
    }

}
