$(document).ready(function () {
  $('#formEditUser').validate({
    rules: {
      nameUserEdit: { required: true },
      surnameUserEdit: { required: true },
      loginUserEdit: { required: true, lettersonly: true },
      passwordUserEdit: { required: true, minlength: 6, equalTo: "#confirmationPasswordEdit" },
      confirmationPasswordEdit: { required: true, minlength: 6, equalTo: "#passwordUserEdit" },
    },

    messages: {
      nameUserEdit: { required: "Digite o Nome" },
      surnameUserEdit: { required: "Digite o Sobrenome" },
      loginUserEdit: { required: "Digite o Login", lettersonly: "Digite apenas letras" },
      passwordUserEdit: { required: "Digite a Senha", minlength: "Digite pelo menos 6 caracteres", equalTo: "Senhas diferentes" },
      confirmationPasswordEdit: { required: "Digite a Confirmação da Senha", minlength: "Digite pelo menos 6 caracteres", equalTo: "Senhas diferentes" },
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
        url: "/usuarios/editar",
        data: dados,
        processData: false,
        success: function (returnAjax) {
          if (returnAjax === true) {
            toastr.success('Sucesso: usuário editado!');
            $('#modalEditUser').modal('hide');
            $('#formEditUser').each(function () { this.reset(); });
            $('#listUsers').DataTable().ajax.reload();
          } else {
            toastr.error('Erro: usuário não editado!');
            $('#modalEditUser').modal('hide');
            $('#formEditUser').each(function () { this.reset() });
            $('#listUsers').DataTable().ajax.reload();
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
