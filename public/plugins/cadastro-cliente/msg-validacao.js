$(document).ready(function() {
    $.validator.setDefaults({
      submitHandler: function() {
        alert("Form successful submitted!");
        form.submit();
      }
    });
    $('#quickForm').validate({
      rules: {
        name: {
          required: true
        },
        surname: {
          required: true
        },
        cellphone: {
          required: true
        },
        telephone: {
          required: true
        },
        cep: {
          required: true
        },
        email: {
          required: true,
          email: true,
        },
        cnpj: {
          required: true,
          cnpjBR: true,
        },
        cpf: {
          required: true,
          cpfBR: true,
        },
      },
      messages: {
        name: "Digite um Nome",
        surname: "Digite um Sobrenome",
        cellphone: "Digite um Celular",
        telephone: "Digite um Telefone",
        cep: "Digite um CEP",
        email: {
          required: "Digite um endereço de e-mail",
          email: "Digite um endereço de e-mail válido"
        },
        cnpj: {
          required: "Digite um CNPJ",
          cnpjBR: "Digite um CNPJ válido"
        },
        cpf: {
          required: "Digite um CPF",
          cpfBR: "Digite um CPF válido"
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });
