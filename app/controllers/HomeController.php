<?php

class HomeController extends BaseController {

    public function index() {
        if (Auth::check()) {
            return View::make('skills');
        } else {
            return View::make('welcome');
        }
    }

    public function login() {
        if (Auth::check()) {
            return Redirect::to('/');
        } else {
            return $this->login_github();
        }
    }

    public function logout() {
        Auth::logout();
        return Redirect::to('/');
    }

    public function login_github() {
        $code = Input::get('code');
        $gh = OAuth::consumer('GitHub');

        if (!empty($code)) {
            $gh->requestAccessToken($code);
            $result = json_decode($gh->request('user'), true);

            $user = User::firstOrCreate(array('gh_id' => $result['id']));
            $user->name = $result['login'];
            $user->save();

            Auth::login($user);
            return Redirect::to('/');
        } else {
            $url = $gh->getAuthorizationUri();
            return Response::make()->header('Location', (string) $url);
        }
    }

}
