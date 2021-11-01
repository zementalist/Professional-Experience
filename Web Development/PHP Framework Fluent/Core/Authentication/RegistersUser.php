<?php

namespace Core\Authentication;

trait RegistersUser {

    /**
     * Return Registration view
     *
     * @return Core\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Run registration process
     *
     * @param  Core\Request  $request
     * @return mixed
     */
    public function register(Request $request) {
        $this->validate($request->all());

        $user = $this->create($request->all());

        Auth::login($user);  
        
        if($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson() ? response()->json([], 200) : response()->redirect(static::REDIRECT_TO);
    }

    /**
     * Return custom response on registration success
     *
     * @param  Core\Request  $request
     * @param  App\Models\User $user
     * @return mixed
     */
    protected function registered(Request $request, $user) {

    }

}

?>