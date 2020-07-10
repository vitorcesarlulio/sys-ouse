$(document).ready(function () {
  $('#formRegisterEvent').validate({
    rules: {
      startDateRegister: {
        required: true
      },
      startTimeRegister: {
        required: true
      },
      endTimeRegister: {
        required: true
      },
      nameRegister: {
        required: true
      },
      surnameRegister: {
        required: true
      },
      cellphoneRegister: {
        require_from_group: [1, ".contact"]
      },
      telephoneRegister: {
        require_from_group: [1, ".contact"]
      },
      cep: {
        required: true
      },
      logradouro: {
        required: true
      },
      bairro: {
        required: true
      },
      localidade: {
        required: true
      },
      uf: {
        required: true
      },
      numberRegister: {
        required: true
      },
      streetCondominiumRegister: {
        required: true
      },
      edificeRegister: {
        required: true
      },
      blockRegister: {
        required: true
      },
      apartmentRegister: {
        required: true
      },
      clientRegister: {
        required: true
      },
      bairro: {
        required: true
      },

      /*optionHomeRegister: {
        require_from_group: [1, ".custom-radio"]
      },
      optionBuildingRegister: {
        require_from_group: [1, ".custom-radio"]
      },
      optionCondominiumRegister: {
        require_from_group: [1, ".custom-radio"]
      }*/

    },

    messages: {
      startDateRegister: {},
      startTimeRegister: {},
      endTimeRegister: {},
      nameRegister: { required: "Digite um Nome.", minlength: "No mínimo 2 letras" },
      surnameRegister: {},
      cellphoneRegister: {},
      telephoneRegister: {},
      cep: {},
      logradouro: {},
      bairro: {},
      localidade: {},
      numberRegister: {},
      streetCondominiumRegister: {},
      edificeRegister: {},
      blockRegister: {},
      apartmentRegister: {},
      bairro: {},

      clientRegister: {},
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
        url: "/agenda/calendario/cadastar",
        data: dados,
        processData: false,
        success: function (retorna) {
          if (retorna['sit']) {
            //$("#msg-cad").html(retorna['msg']);
            location.reload();
          } else {
            $("#msg-cad").html(retorna['msg']);
          }
        }
      });
      return false;
    }
  });
});