<?php

namespace App\Controllers\Auth;

use Core\Authentication\RegistersUser;
use Core\Cryptography\Hash;
use Core\Validation\Validator;
use App\Models\User;
use Core\Validation\Rules\Unique;
use Core\Controller\Controller;




class RegisterController extends Controller {
    use RegistersUser;

     const REDIRECT_TO = "Home";

    public function validate(array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', new Unique(User::class)],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    public function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }
}

?>