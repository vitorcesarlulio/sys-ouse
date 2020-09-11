$(document).ready(function () {
    $('#formRegisterPeople').validate({
      rules: {
        name: {
            required: true
          }
      },
  
      messages: {
        name: { required: "Digite o Nome" }
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
        var dados = $(form).serialize();
        $.ajax({
          type: "POST",
          url: "/pessoas/cadastrar",
          data: dados,
          processData: false,
          success: function (returnAjax) {
            if (returnAjax === true) {
              toastr.success('Sucesso: usuário cadastrado!');
              $('#formRegisterPeople').each(function () { this.reset(); });
            } else {
              toastr.error('Erro: usuário não cadastrado!');
              $('#formRegisterPeople').each(function () { this.reset() });
            }
          },
          error: function () {
            toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!');
          }
        });
        return false;
      }
    });
  });
  