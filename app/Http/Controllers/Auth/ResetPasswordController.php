<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Hash;
use DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function resetPassword($token,Request $request)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }


    public function reset(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $usuario = Usuario::whereEmail($request->input('email'))->first();

        if(isset($usuario)){
            $pasword_reset = DB::table('password_resets')->where([
                'email' => $request->email,
                'token' => $request->token
            ])->first();

            if(!$pasword_reset){
                return back()->withInput()->with('error', 'No se ha podido realizar el cambio de contraseña');
            }
            $usuario->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where(['email'=> $request->email])->delete();

            return redirect('login')->with(
                [
                    'message' => 'La contraseña se ha cambiado correctamente'
                ]
            );
        }
    }
}
