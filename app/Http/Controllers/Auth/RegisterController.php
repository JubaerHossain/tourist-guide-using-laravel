<?php

namespace App\Http\Controllers\Auth;
use Brian2694\Toastr\Facades\Toastr;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    
    protected $redirectTo = '/';
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
          //dd($data);
         if ($data['role'] == 'customer') {
            $this->redirectTo = 'user/dashboard';
            $role_id = 3;
        } else {
            $this->redirectTo = 'guide/dashboard';
            $role_id = 2;
        }
     $user = User::create([
         'name' => $data['name'],
         'email' => $data['email'],
         'password' => Hash::make($data['password']),
         'phone' => $data['phone'],
     ]);
         if ($data['role'] == 'customer') {
            $customer = new \App\Customer();
            $customer->user_id = $user->id;
            $customer->name =$data['name'];
            $customer->country = $data['country'];
            $customer->state = $data['state'];
            $customer->save();
         }else{
         $guide = new \App\Guide();
            $guide->user_id = $user->id;
            $guide->name =$data['name'];
            $guide->country = $data['country'];
            $guide->state = $data['state'];
            $guide->save();
         }
         $Account = new \App\Account();
            $Account->user_id = $user->id;
            $Account->save();
         $Balance = new \App\Balance();
            $Balance->user_id = $user->id;
            $Balance->save();
         $role = new \App\User_role();
            $role->user_id = $user->id;
            $role->role_id = $role_id;
            $role->save();
            Toastr::success('Verification code sent you email', 'Success');
     return $user;
    }
}
