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

            $user = User::where('gh_id', $result['id'])->first();
            if (!empty($user)) {
                $uid = $user->id;
            } else {
                $uid = $this->create_user($result);
            }
            Session::set('uid', $uid);

            // redirect somewhere? TODO
        } else {
            $url = $gh->getAuthorizationUri();
            return Response::make()->header('Location', (string) $url);
        }
    }

    private function create_user($gh_result) {
        $user = new User;
        $user->name = $gh_result['login'];
        $user->gh_id = $gh_result['id'];
        $user->save();
        return $user->id;
    }

}
