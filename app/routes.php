<?php

Route::get('/', 'HomeController@index');
Route::get('skills', 'HomeController@skills');
Route::get('login', 'HomeController@login_github');
