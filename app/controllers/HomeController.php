<?php

class HomeController extends BaseController {

    public function index() {
        return View::make('welcome');
    }

    public function skills() {
        return View::make('skills');
    }

    public function login_github() {
        $code = Input::get('code');
        $gh = OAuth::consumer('GitHub');

        if (!empty($code)) {
            $gh->requestAccessToken($code);
            $result = json_decode($gh->request('user'), true);
            dd($result);
        } else {
            $url = $gh->getAuthorizationUri();
            return Response::make()->header('Location', (string) $url);
        }
    }

}
