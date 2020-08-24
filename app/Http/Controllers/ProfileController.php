<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Mail\SendStudentPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends RegisterController
{
    public function index()
    {
        $user = auth()->user();

        return view('profile', compact('user'));
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $password = '123';

        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'nickname' => $request->nickname,
            'city' => $request->city,
            'phone' => $request->phone,
            'email' => $request->email,
            'role_id' => 3,
            'password' => bcrypt($password),
            'representative_email' => auth()->user()->email,
            'email_verified_at' => now(),
        ];

        $user = $this->create($data);

        Mail::to($user)->send(new SendStudentPassword($user, $password));

        return $this->respondSuccess();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'max:255'],
            'nickname' => ['max:255'],
            'city' => ['max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ];

        return Validator::make($data, $rules);
    }
}
