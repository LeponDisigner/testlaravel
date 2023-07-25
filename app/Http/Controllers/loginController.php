<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateTime;
use App\services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime as UtilsDateTime;

class loginController extends Controller
{
    protected $request;
    function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function existemail()
    {
        $email = $this->request->input('email');
        $user = User::where('email', $email)
            ->first();

        $response = '';
        if($user)
        {
            $response = 'exist';
        }
        else
        {
            $response = 'not_exist';
        }
        return response()->json([
            'response' => $response
        ]);
    }

    public function ActivationCode($token)
    {
        //une variable qui recupere le token de l'utilisateur en base de donnee
        $user = user::where('activation_token', $token)->first();
        if(!$user)
        {
            return redirect()->route('login')->with('danger', 'this token doesn\'t match any user');
        }

        if($this->request->isMethod('post'))
        {
            //une variable qui recupere le code de l'utilisateur en base de donnee
            $code = $user->activation_code;
            //une variable qui recupere le code de l'utilisateur envoyer par email
            $activation_code_sendmail = $this->request->input('activation_code');

            if($activation_code_sendmail != $code)
            {
                return back()->with([
                    'danger' => 'this code is invalid',
                    'activation_code_sendmail' => $activation_code_sendmail
                ]);
            }
            else
            {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                       'is_verified' => 1,
                       'activation_code' => '',
                       'activation_token' => '',
                       'email_verified_at' => new \DateTimeImmutable,
                       'updated_at' => new \DateTimeImmutable
                    ]);
                    return redirect()->route('login')->with('succes', 'your activate accout thanks');
            }
        }
        else
        {
            return view('auth.activation_code', [
                'token' => $token
            ]);
        }


    }

    public function Userchecked()
    {
        $activation_token = Auth::user()->activation_token;
        $is_verified = Auth::user()->is_verified;

        if($is_verified != 1)
        {
            Auth::logout();

            return redirect()->route('App_activation_code', ['token' =>  $activation_token])
                ->with('warning', 'your account is not activate, pleace check your mail box and activation account or confirm a message. ');
        }
        else
        {
            return redirect()->route('App_dashboard');
        }
    }

    public function ResetActivationCode($token)
    {
        $user = user::where('activation_token', $token)->first();
        $email = $user->email;
        $name = $user->name;
        $activation_token = $user->activation_token;
        $activation_code = $user->activation_code;

          $mailsend = new EmailService;
          $suject = 'Activate your Account';
          $message = view('mail/confirm_mail')
                      ->with([
                          'name' => $name,
                          'activation_code' => $activation_code,
                          'activation_token' =>  $activation_token
                      ]);
          $mailsend->sendEmail($suject, $email, $name, true, $message);
          return redirect()->route('App_activation_code', ['token'=>$token])->with('succes', 'you have just resed the activation code');
    }

    public function ActivationAccountLink($token)
    {
        $user = user::where('activation_token', $token)->first();

        if(!$user)
        {
            return redirect()->route('login')->with('danger', 'this token doesn\'t match any user');
        }

        DB::table('users')
            ->where('id', $user->id)
            ->update([
           'is_verified' => 1,
           'activation_code' => '',
           'activation_token' => '',
           'email_verified_at' => new \DateTimeImmutable,
           'updated_at' => new \DateTimeImmutable
        ]);
            return redirect()->route('login')->with('succes', 'your activate accout thanks');
    }

    public function ActivationAccountChargeEmail($token)
    {
        $user = user::where('activation_token', $token)->first();
        if($this->request->isMethod('post'))
        {
            $new_email = $this->request->input('new-email');
            $user_existe = user::where('email', $new_email);
            if($user_existe)
            {
                return back()->with([
                    'danger' => 'this adress email is already used, pleace change your email',
                    'new_email' => $new_email
                ]);
            }
            else
            {
                DB::table('users')
                ->where('id', $user->id)
                ->update([
               'email' => $new_email,
               'updated_at' => new \DateTimeImmutable
                ]);


                $name = $user->name;
                $activation_token = $user->activation_token;
                $activation_code = $user->activation_code;

                $mailsend = new EmailService;
                $suject = 'Activate your Account';
                $message = view('mail/confirm_mail')
                            ->with([
                                'name' => $name,
                                'activation_code' => $activation_code,
                                'activation_token' =>  $activation_token
                            ]);
                $mailsend->sendEmail($suject, $new_email, $name, true, $message);
                return redirect()->route('App_activation_code', [
                    'token'=>$token])
                    ->with('succes', 'you have just resed the activation code');
            }
        }
        else
        {
            return view('auth.Activation_account_change_email',['token'=>$token]);
        }
    }
}
