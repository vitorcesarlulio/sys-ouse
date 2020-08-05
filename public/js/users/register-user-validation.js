$(document).ready(function () {
  $('#formRegisterUser').validate({
    rules: {
      nameUserRegister: { required: true },
      surnameUserRegister: { required: true },
      loginUserRegister: { required: true },
      passwordUserRegister: { required: true, minlength: 6 }

    },

    messages: {
      nameUserRegister: { required: "Digite o Nome" },
      surnameUserRegister: { required: "Digite o Sobrenome" },
      loginUserRegister: { required: "Digite o Login" },
      passwordUserRegister: { required: "Digite a Senha", minlength: "Digite pelo menos 6 caracteres" },
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
          $("#alertMessage").show();
          $('#alertMessage').html('<div id="toast-container" class="toast-top-right"><div class="toast toast-success" aria-live="polite" style=""><div class="toast-message">Sucesso: usuário cadastrado!</div></div></div>');
          $('#modalRegisterUser').modal('hide');
          $('#formRegisterUser').each(function () { this.reset(); });
          $('#listUsers').DataTable().ajax.reload();
        },
        error: function () {
          $("#alertMessage").show();
          $('#alertMessage').html('<div id="toast-container" class="toast-top-right"><div class="toast toast-success" aria-live="polite" style=""><div class="toast-message">Erro: usuário não cadastrado!</div></div></div>');
          $('#modalRegisterUser').modal('hide');
          $('#formRegisterUser').each(function () { this.reset() });
          $('#listUsers').DataTable().ajax.reload();
        }
      });
      return false;
    }
  });
});
