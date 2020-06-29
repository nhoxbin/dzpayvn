<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Ref;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    private function quickRandom($length = 16) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length) . time()), 0, $length);
    }

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
    protected $redirectTo = '/dashboard';

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $tested = [];
        do {
            $ref_code = $this->quickRandom();
            if (in_array($ref_code, $tested)) {
                continue;
            }
            array_push($tested, $ref_code);
            $count = DB::table('users')->where('ref_code', $ref_code)->count();
        } while($count > 0);

        $new_user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'ref_code' => $ref_code,
        ]);

        if ($ref_code = request()->ref) {
            $u = User::where('ref_code', $ref_code)->first();
            if ($u !== null) {
                Ref::create([
                    'user_id' => $new_user->id,
                    'ref_at' => $u->id
                ]);
            }
        }

        return $new_user;
    }

    public function checkExists(Request $request, $field, $value)
    {
        if (!$request->ajax()) {
            return response(null, 400);
        }
        if ($field === 'email' || $field === 'phone') {
            $user = User::where($field, $value)->first();
            if ($user !== null) { // exists
                return response(['error' => false, 'exists' => true], 200);
            } else {
                return response(['error' => false, 'exists' => false], 200);
            }
        } else {
            return response('Chỉ kiểm tra tồn tại email và phone!', 200);
        }
    }
}
