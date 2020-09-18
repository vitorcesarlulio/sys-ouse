$(document).ready(function () {
  $('#formEditEvent').validate({
    rules: {
      startDateEdit: { required: true},
      startTimeEdit: { required: true, time: true },
      endTimeEdit: { required: true, greaterThan: '#startTimeEdit' }, //metodo lessThan se fosse menor

      //digits: true somente numeros
    },

    messages: {
      startDateEdit: { required: "Digite a Data Inicial." },
      startTimeEdit: { required: "Digite a Hora Inicial.", time: "Tempo errado" },
      endTimeEdit: { required: "Digite a Hora Final.", greaterThan: "informe um horário superior." },
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
        url: "/agenda/calendario/editar",
        data: dados,
        dataType: 'JSON',
        processData: false,
        success: function (retorna) {
          if (retorna['sit']) {
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
