<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\EmailService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
       /* Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();*/
        $email = $input['email'];
        //generer le token pour l'activation du compte
        $activation_token = md5(uniqid()).$email.sha1($email);

        //code d'activation du token

        $activation_code = "";
        $length_code = 6;
        for($i = 0; $i < $length_code; $i++)
        {
            $activation_code.= mt_rand(0,9);
        }

        $name = $input['firstname']. ' ' .$input['lastname'];

        //instatiation du service
        $mailsend = new EmailService;
        //$mailsend = new EmailService;
        $suject = 'Activate your Account';

        //= "hi ".$name." pleace active your account ".$activation_code." or click the link ".$activation_token;
        $message = view('mail/confirm_mail')
                    ->with([
                       'name' => $name,
                        'activation_code' => $activation_code,
                        'activation_token' =>  $activation_token
                     ]);
        $mailsend->sendEmail($suject, $email, $name, true, $message);
       // $mailsend->sendEmail($suject, $email, $name, false, $message);

        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($input['password']),
            'activation_code' => $activation_code,
            'activation_token' => $activation_token
        ]);
    }
}
