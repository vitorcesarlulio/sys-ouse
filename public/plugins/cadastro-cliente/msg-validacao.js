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
        email: {
          email: true
        },
        cep: {
          required: true
        },
        cnpj: {
          required: true,
          cnpjBR: true,
        },
        cpf: {
          required: true,
          cpfBR: true,
        },
        number: {
          required: true,
        },
        edifice: {
          required: true,
        },
        block: {
          required: true,
        },
        apartment: {
          required: true,
        },
      },
      messages: {
        name: "Digite um Nome",
        surname: "Digite um Sobrenome",
        cellphone: "Digite um Celular",
        telephone: "Digite um Telefone",
        cep: "Digite um CEP",
        email: {
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
        number: {
          required: "Digite um Número"
        },
        edifice: {
          required: "Digite um Edifício"
        },
        block: {
          required: "Digite um Bloco"
        },
        apartment: {
          required: "Digite um Apartamento"
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
