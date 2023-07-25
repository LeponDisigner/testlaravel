<h1> Hi {{ $name }} pleace confirm your email! </h1>
<p>
    pleace activate your account by copying and pasting activation code.
    <br> activation code: {{ $activation_code }}.<br>
    Or click by following link : <br>
    <a href="{{ route('App_activation_account_link', ['token'=> $activation_token]) }}" target="_blank">confirm your account</a>
</p>
