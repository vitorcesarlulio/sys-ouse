$(document).ready(function () {
  $('#formRegisterEvent').validate({
    rules: {
      startDateRegister: { required: true },
      startTimeRegister: { required: true, time: true },
      endTimeRegister: { required: true, greaterThan: '#startTimeRegister' }, //metodo lessThan se fosse menor
      nameRegister: { required: true },
      surnameRegister: { required: true },
      cellphoneRegister: { require_from_group: [1, ".contact"] },
      telephoneRegister: { require_from_group: [1, ".contact"] },
      emailRegister: { email: true },
      cep: { required: true, postalcodeBR: true },
      logradouro: { required: true },
      bairro: { required: true },
      localidade: { required: true },
      uf: { required: true },
      typeResidence: { required: true },
      numberRegister: { required: true },
      streetCondominiumRegister: { required: true },
      edificeRegister: { required: true },
      blockRegister: { required: true },
      apartmentRegister: { required: true },
      bairro: { required: true },
      clientRegister: { required: true }
      //digits: true somente numeros
    },

    messages: {
      startDateRegister: { required: "Digite a Data Inicial." },
      startTimeRegister: { required: "Digite a Hora Inicial.", time: "Tempo errado" },
      endTimeRegister: { required: "Digite a Hora Final.", greaterThan: "informe um horário superior." },
      nameRegister: { required: "Digite um Nome.", minlength: "No mínimo 2 letras" },
      surnameRegister: { required: "Digite um Sobrenome." },
      cellphoneRegister: { require_from_group: "Digite um Celuar ou Telefone." },
      telephoneRegister: { require_from_group: "Digite um Celuar ou Telefone." },
      emailRegister: { email: "Digite um endereço de e-mail válido." },
      cep: { required: "Digite um CEP." },
      logradouro: { required: "Digite o Logradouro." },
      bairro: { required: "Digite o Bairro." },
      localidade: { required: "Digite a Cidade." },
      uf: { required: "Digite o Estado." },
      typeResidence: { required: "Selecione uma opção." },
      numberRegister: { required: "Digite o número da casa." },
      streetCondominiumRegister: { required: "Digite a rua do Condomínio." },
      edificeRegister: { required: "Digite o Edifício." },
      blockRegister: { required: "Digite o Bloco." },
      apartmentRegister: { required: "Digite o Apartamento." },
      bairro: { required: "Digite o Bairro" },

      clientRegister: { required: "Selecione uma Pessoa." }
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
        url: "/agenda/calendario/cadastar",
        data: dados,
        processData: false,
        success: function (returnAjax) {
          if (returnAjax === 'insertEventBudget') {
            toastr.success('Sucesso: evento e orçamento cadastrados!');
            $('#modalRegisterEvent').modal('hide');
          } else if (returnAjax === 'noInsertEventBudget') {
            toastr.error('Erro: evento e orçamento não cadastrados!');
            $('#modalRegisterEvent').modal('hide');
          } else if (returnAjax === 'insertEvent') {
            toastr.success('Sucesso: evento cadastrado!');
            $('#modalRegisterEvent').modal('hide');
          } else if (returnAjax === 'noInsertEvent') {
            toastr.error('Erro: evento não cadastrado!');
            $('#modalRegisterEvent').modal('hide');
          } else if (returnAjax === 'insertBudget') {
            toastr.success('Sucesso: orçamento cadastrado!');
            $('#modalRegisterEvent').modal('hide');
          } else if (returnAjax === 'noInsertBudget') {
            toastr.error('Erro: orçamento não cadastrado!');
            $('#modalRegisterEvent').modal('hide');
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
