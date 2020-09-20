$(document).ready(function () {
  $('#formRegisterPeople').validate({
    rules: {
      cpf: {
        required: true,
        cpfBR: true,
      },
      cnpj: {
        required: true,
        cnpjBR: true,
      },
      name: {
        required: true
      },
      surname: {
        required: true
      },
      companyName: {
        required: true
      },
      fantasyName: {
        required: true
      },
      cep: {
        required: true
      },
      typeResidence: {
        required: true
      },
      streetCondominium: {
        required: true
      },
      number: {
        required: true
      },
      block: {
        required: true
      },
      apartment: {
        required: true
      }
    },

    messages: {
      cpf: { required: "Digite o CPF.", cpfBR: "CPF inválido."},
      cnpj: { required: "Digite o CNPJ.", cnpjBR: "CNPJ inválido."},
      name: { required: "Digite o Nome." },
      surname: { required: "Digite o Sobrenome." },
      companyName: { required: "Digite a Razão Social." },
      fantasyName: { required: "Digite o Nome Fantasia." },
      cep: { required: "Digite CEP." },
      typeResidence: { required: "Selecione uma opção." },
      streetCondominium: { required: "Digite a rua do Condomínio." },
      number: { required: "Digite o número." },
      block: { required: "Digite o Bloco." },
      apartment: { required: "Digite o Apartamento." }
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
          if (returnAjax === 'insertPhysicalPerson') {
            toastr.success('Sucesso: pessoa física cadastrada!');
            $('#modalRegisterPeople').modal('hide');
            $('#formRegisterPeople').each(function () { this.reset(); });
            $('#listPeople').DataTable().ajax.reload();

          } else if (returnAjax === 'noInsertPhysicalPerson') {
            toastr.error('Erro: pessoa física não cadastrada!');
            
          } else if (returnAjax === 'insertPhysicalLegal') {
            toastr.success('Sucesso: pessoa jurídica cadastrada!');
            $('#modalRegisterPeople').modal('hide');
            $('#formRegisterPeople').each(function () { this.reset(); });
            $('#listPeople').DataTable().ajax.reload();

          } else if (returnAjax === 'noInsertPhysicalLegal') {
            toastr.error('Erro: pessoa jurídica não cadastrada!');
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
