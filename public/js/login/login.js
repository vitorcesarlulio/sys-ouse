$(document).ready(function () {
    $("#userLogin").keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });
});

$(document).ready(function () {
    $('#formLogin').validate({
        rules: {
            userLogin: { required: true, lettersonly: true },
            passwordLogin: { required: true }
        },

        messages: {
            userLogin: { required: "Digite o Login", lettersonly: "Digite apenas letras" },
            passwordLogin: { required: "Digite a Senha" }
        },

        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },

        submitHandler: function (form) {
            //event.preventDefault();
            var dados = $(form).serialize();
            $.ajax({
                type: "POST",
                url: "/verificar-login",
                data: dados,
                processData: false,
                success: function (returnAjax) {
                    if (returnAjax['redirect'] === '/home' && returnAjax['attempts'] === false && returnAjax['errors'] === false) {
                        window.location.href = returnAjax['redirect']; //direciona eu para a home se o usuario existir
                    }
                    if (returnAjax['errors'] === true && returnAjax['attempts'] === false && returnAjax['redirect'] === '/home') {
                        toastr.error('Erro: usuário ou senha inválidos!');
                    }
                    if (returnAjax['attempts'] === true && returnAjax['errors'] === true && returnAjax['redirect'] === '/home') {
                        $('#btnLogin').attr('disabled','disabled');
                        $('#divErrors').html('Tentativas excedidas, tente novamente daqui 20 minutos ou entre em contato com o Administrador do sistema!');

                        /*var timeleft = 10;
                        var downloadTimer = setInterval(function () {
                            document.getElementById("countdown").innerHTML = timeleft + " segundos restantes";
                            timeleft -= 1;
                            if (timeleft <= 0) {
                                clearInterval(downloadTimer);
                                $("#countdown").hide();
                                document.getElementById("btnLogin").disabled = false;
                            }
                        }, 1000); */

                        /*
                        onLoad="relogio()" // colocar na div

                        function startTimer(duration, display) {
                            var timer = duration, minutes, seconds;
                            setInterval(function () {
                                minutes = parseInt(timer / 60, 10);
                                seconds = parseInt(timer % 60, 10);
                        
                                minutes = minutes < 10 ? "0" + minutes : minutes;
                                seconds = seconds < 10 ? "0" + seconds : seconds;
                        
                                display.text(minutes + ":" + seconds + "minutos restantes");
                        
                                if (--timer < 0) {
                                    timer = duration;
                                }
                            }, 1000);
                        }
                        
                        jQuery(function ($) {
                            var fiveMinutes = 60 * 5,
                                display = $('#countdown');
                            startTimer(fiveMinutes, display);
                        });	*/

                    }
                }
            });
            return false;
        }
    });
});
