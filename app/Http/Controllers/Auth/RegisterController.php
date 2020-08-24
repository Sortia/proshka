<?php

namespace App\Http\Controllers\Auth;

use App\Constants\Roles;
use App\Http\Controllers\Controller;
use App\Http\Services\FileService;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required','max:255'],
            'nickname' => ['max:255'],
            'city' => ['max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => ['image'],
            'role_id' => [
                'required',
                Rule::in([3, 4]),
            ]
        ];

        // если регистрируется ученик и он являеся несовершеннолетним
        // ему требуется ввести email представителя (зарегестрированного на этом сайте)
        if (!$data['adult_checkbox'] and $data['role_id'] === '3') {
            $rules['representative_email'] = ['exists:users,email'];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if ($data['avatar'] ?? false) {
            $avatar = $data['avatar']->store('avatars');
        }

        $representativeId = User::whereEmail($data['representative_email'])->value('id');

        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'nickname' => $data['nickname'],
            'phone' => $data['phone'],
            'city' => $data['city'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'avatar' => $avatar ?? null,
            'role_id' => $data['role_id'],
            'representative_id' => $representativeId
        ]);
    }
}
