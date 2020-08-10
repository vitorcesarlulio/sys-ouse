

$(document).ready(function () {
  $('#formRegisterUser').validate({
    rules: {
      nameUserRegister: { required: true, lettersonly: true },
      surnameUserRegister: { required: true, lettersonly: true },
      loginUserRegister: { required: true, lettersonly: true },
      passwordUserRegister: { required: true, minlength: 6, equalTo: "#confirmationPasswordRegister" },
      confirmationPasswordRegister: { required: true, minlength: 6, equalTo: "#passwordUserRegister" },
    },

    messages: {
      nameUserRegister: { required: "Digite o Nome", lettersonly: "Digite apenas letras" },
      surnameUserRegister: { required: "Digite o Sobrenome", lettersonly: "Digite apenas letras" },
      loginUserRegister: { required: "Digite o Login", lettersonly: "Digite apenas letras" },
      passwordUserRegister: { required: "Digite a Senha", minlength: "Digite pelo menos 6 caracteres", equalTo: "Senhas diferentes" },
      confirmationPasswordRegister: { required: "Digite a Confirmação da Senha", minlength: "Digite pelo menos 6 caracteres", equalTo: "Senhas diferentes" },
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
        url: "/usuarios/cadastrar",
        data: dados,
        processData: false,
        success: function () {
          toastr.success('Sucesso: usuário cadastrado!');
          $('#modalRegisterUser').modal('hide');
          $('#formRegisterUser').each(function () { this.reset(); });
          $('#listUsers').DataTable().ajax.reload();
        },
        error: function () {
          toastr.error('Erro: usuário não cadastrado!');
          $('#modalRegisterUser').modal('hide');
          $('#formRegisterUser').each(function () { this.reset() });
          $('#listUsers').DataTable().ajax.reload();
        }
      });
      return false;
    }
  });
});
