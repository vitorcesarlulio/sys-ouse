$(document).ready(function () {
  $('#formEditPeople').validate({
    rules: {
      cpfEdit: {
        required: true,
        cpfBR: true,
      },
      cnpjEdit: {
        required: true,
        cnpjBR: true,
      },
      nameEdit: {
        required: true
      },
      surnameEdit: {
        required: true
      },
      companyNameEdit: {
        required: true
      },
      fantasyNameEdit: {
        required: true
      },
      cepEdit: {
        required: true
      },
      typeResidenceEdit: {
        required: true
      },
      streetCondominiumEdit: {
        required: true
      },
      numberEdit: {
        required: true
      },
      blockEdit: {
        required: true
      },
      apartmentEdit: {
        required: true
      }
    },

    messages: {
      cpfEdit: { required: "Digite o CPF.", cpfBR: "CPF inválido."},
      cnpjEdit: { required: "Digite o CNPJ.", cnpjBR: "CNPJ inválido."},
      nameEdit: { required: "Digite o Nome." },
      surnameEdit: { required: "Digite o Sobrenome." },
      companyNameEdit: { required: "Digite a Razão Social." },
      fantasyNameEdit: { required: "Digite o Nome Fantasia." },
      cepEdit: { required: "Digite CEP." },
      typeResidenceEdit: { required: "Selecione uma opção." },
      streetCondominiumEdit: { required: "Digite a rua do Condomínio." },
      numberEdit: { required: "Digite o número." },
      blockEdit: { required: "Digite o Bloco." },
      apartmentEdit: { required: "Digite o Apartamento." }
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
        url: "/pessoas/editar",
        data: dados,
        processData: false,
        success: function (returnAjax) {
          if (returnAjax === "upDatePeople") {
            toastr.success('Sucesso: pessoa editada!');
            $('#modalEditPeople').modal('hide');
            $('#formEditPeople').each(function () { this.reset(); });
            $('#listPeople').DataTable().ajax.reload();
          } else if(returnAjax === "noUpDatePeople") {
            toastr.error('Erro: pessoa não editada!');
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
