<?php

namespace Core\Authentication;
use App\Models\User;


trait AuthenticatesUser {

    /**
     * Validate availability of username and password in POST request
     *
     * @param  Core\Request  $request
     * @return bool
     */
    public function validateLogin($request) {
        $usernameKey = Auth::usernameKey();
        return $request->validate([
          "$usernameKey" => "required",
          "password" => "required"  
        ]);
    }

    /**
     * Return login view
     *
     * @return Core\View
     */
    public function showLoginForm() {
        return view("auth/login");
    }

    /**
     * Run the login process
     *
     * @param  Core\Request  $request
     * @return mixed
     */
    public function login(Request $request) {
        $this->validateLogin($request);
        $remember_me = $request->remember ?? 0;
        $credentials = $this->credentials($request);

        // Try to log the user by the input credentials
        // If success, set a session variable to hold App\Models\User
        if(Auth::attempt($credentials, $remember_me)) {
            session()->set(User::class, Auth::user());
            return $this->sendLoginResponse($request);
        }
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Send response on login success
     *
     * @param  Core\Request   $request
     * @return mixed
     */
    public function sendLoginResponse($request) {
        if($response = $this->authenticated($request, Auth::user())) {
            return $response;
        }

        return $request->wantsJson() ? response()->json([], 200) : response()->view(static::REDIRECT_PATH);
    }

    /**
     * Send response on login fail
     *
     * @param  Core\Request   $request
     * @return mixed
     */
    public function sendFailedLoginResponse($request) {
        return $request->wantsJson() 
        ? response()->json([], 401) 
        : response()->redirect(current_path());
    }

    /**
     * Return custom response on login success
     *
     * @param  Core\Request  $request
     * @param  App\Models\User   $user
     * @return mixed
     */
    public function authenticated(Request $request, $user) {

    }

    /**
     * Extract username,password from POST request
     *
     * @param  Core\Request   $request
     * @return array
     */
    public function credentials(Request $request) {
        return $request->only([Auth::usernameKey(), 'password']);
    }

}

?>