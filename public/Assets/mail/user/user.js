/**
 * la gestion de l'enregistrement des utilisateurs
 */

 $('#register-user').click(function(){
        let firstname = $('#firstname').val();
        let lastname = $('#lastname').val();
        let email = $('#email').val();
        let password = $('#password').val();
        let passwordlength = password.length;
        let password_confirm = $('#password-confirm').val();
        let agreeterms = $('#agreeterms');

         if(firstname != '' && /^[a-zA-Zâäàéèùêëîïôöçñ]+$/.test('firstname')){
                 $('#firstname').removeClass('is-invalid');
                 $('#firstname').addClass('is-valid');
                 $('#error-register-firstname').text('');
                 if(lastname != '' && /^[a-zA-Zâäàéèùêëîïôöçñ]+$/.test('lastname')){
                    $('#lastname').removeClass('is-invalid');
                    $('#lastname').addClass('is-valid');
                    $('#error-register-lastname').text('');
                    if(email != '' /*&& /^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test('email')*/){
                        $('#email').removeClass('is-invalid');
                        $('#email').addClass('is-valid');
                        $('#error-register-email').text('');
                        if(passwordlength>=8){
                            $('#password').removeClass('is-invalid');
                            $('#password').addClass('is-valid');
                            $('#error-register-password').text('');
                            if(password == password_confirm){
                                $('#password-confirm').removeClass('is-invalid');
                                $('#password-confirm').addClass('is-valid');
                                $('#error-register-password-confirm').text('');
                                if(agreeterms.is(':checked')){
                                    $('#agreeterms').removeClass('is-invalid');
                                    $('#error-register-agreeterms').text('');

                                    let resp = EmailExist(email);
                                    // (resp != 'exist') ? $('#form-register').submit()
                                    //      :  $('#email').addClass('is-invalid');
                                    //         $('#email').removeClass('is-valid');
                                    //         $('#error-register-email').text('this email adress is already used');
                                    if(resp != 'exist')
                                    {
                                        $('#form-register').submit();
                                    }
                                    else
                                    {
                                        $('#email').addClass('is-invalid');
                                        $('#email').removeClass('is-valid');
                                        $('#error-register-email').text('this email adress is already used');
                                    }
                                    /**
                                     * condition ternaire
                                     * si (condition) ? vrai : fause;
                                     */
                                     /**si tout est bon on envoies le formulaire*/

                                }else{
                                    $('#agreeterms').addClass('is-invalid');
                                    $('#error-register-agreeterms').text('your can\'t accept');
                                }
                            }else{
                                $('#password-confirm').addClass('is-invalid');
                                $('#password-confirm').removeClass('is-valid');
                                $('#error-register-password-confirm').text('your password confirm identical');
                            }
                        }else{
                            $('#password').addClass('is-invalid');
                            $('#password').removeClass('is-valid');
                            $('#error-register-password').text('your password must be it 8 charatere');
                        }
                    }else{
                        $('#email').addClass('is-invalid');
                        $('#email').removeClass('is-valid');
                        $('#error-register-email').text('your adress email is not valid');
                    }
                }else{
                    $('#lastname').addClass('is-invalid');
                    $('#lastname').removeClass('is-valid');
                    $('#error-register-lastname').text('Last name is not valid');
                }
             }else{
                 $('#firstname').addClass('is-invalid');
                 $('#firstname').removeClass('is-valid');
                 $('#error-register-firstname').text('First name is not valid');
             }

    });


    //
    $('#agreeterms').click(function(){
            let agreeterms = $('#agreeterms');
            if(agreeterms.is(':checked')){
            $('#agreeterms').removeClass('is-invalid');
            $('#error-register-agreeterms').text('');
            }else{
            $('#agreeterms').addClass('is-invalid');
            $('#error-register-agreeterms').text('your can\'t accept');
            }
    });
    //si le mail existe daja
    function EmailExist(email)
    {
        let url = $('#email').attr('url.emailExist');
        let token = $('#email').attr('token');
        let resp = '';
        $.ajax({
            type: 'post',
            url: url,
            data: {
                '_token':token,
                email: email
            },
            sucess:function(result){
                resp = result.response;
            },
            async: false
        });
        return resp;
    }

