<?php

/**
 * Created by Sergio Ruiz Orodea.
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Hash;
use Mail;
use DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
	 * Devuelve la vista para enviar correo de recuperación de contraseña
	 *
	 * @access public
	 * @return View
	 */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
	 * Envía el correo de recuperación de contraseña
	 *
	 * @access public
     * @param Request $request
	 * @return Mail
	 */
    public function sendResetLinkEmail(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
        ]);

        $usuario = Usuario::whereEmail($request->input('email'))->first();
        if(isset($usuario)){
            $remember_token = Str::random(64);

            DB::table('password_resets')->where(['email'=> $request->input('email')])->delete();
            DB::table('password_resets')->insert([
                'email' => $request->input('email'),
                'token' => $remember_token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('mail.auth.recuperarPassword', ['token' => $remember_token,'usuario' => $usuario], function($message) use($request,$usuario){
                $message->to($usuario->email);
                $message->subject('Cambio de contraseña');
            });

            return redirect('password/sendReset')->with(
                [
                    'status' => 'Email de cambio de contraseña enviado correctamente'
                ]
            );
        }else{
            return redirect('password/sendReset')->withErrors(
                [
                    'status' => 'Email de cambio de contraseña no reconocido'
                ]
            );
        }
    }
}
