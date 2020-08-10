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
                url: "/login/verificar",
                data: dados,
                processData: false
            });
            return false;
        }
    });
});
