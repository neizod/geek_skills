<?php

class HomeController extends BaseController {

    public function index() {
        return View::make('welcome');
    }

    public function skills() {
        return View::make('skills');
    }

    public function login() {
        $uid = Session::get('uid');
        if (empty($uid)) {
            return $this->login_github();
        }
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
            Session::set('uid', $user->id);

            // redirect somewhere? TODO
        } else {
            $url = $gh->getAuthorizationUri();
            return Response::make()->header('Location', (string) $url);
        }
    }

}
