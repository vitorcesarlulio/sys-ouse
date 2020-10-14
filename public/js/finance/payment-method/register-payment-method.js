$(document).ready(function () {
    $('#formRegisterPaymentMethod').validate({
        rules: {
            descriptionRegister: {
                required: true
            },
            installmentRegister: { required: true, integer: true, digits: true, positiveNumber: true, max: 100 }
        },

        messages: {
            descriptionRegister: { required: "Selecione a Descrição." },
            installmentRegister: { required: "Digite a(s) parcela(s).", integer: "Digite apenas números inteiros.", digits: "Digite apenas números.", positiveNumber: "Digite apenas números positivos.", max: "Número de parcelas excedido." }
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
                url: "/financeiro/formas-de-pagamento/cadastar",
                data: dados,
                processData: false,
                success: function (returnAjax) {
                    if (returnAjax) {
                        toastr.success('Sucesso: forma de pagamento cadastrada!');
                        $('#modalRegisterPaymentMethod').modal('hide');
                        $('#formRegisterPaymentMethod').each(function () { this.reset(); });
                        $('#listPaymentMethod').DataTable().ajax.reload()
                    } else { toastr.error('Erro: forma de pagamento não cadastrada!'); }
                },
                error: function () {
                    toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!');
                }
            });
            return false;
        }
    });
});
