$(document).ready(function () {
    $('#formUpDateAccountReceivable').validate({
        rules: {
            numberDocumentUpDate: { required: true },
            peopleUpDate: { required: true },
            paymentMethodUpDate: { required: true },
            installmentUpDate: { required: true, integer: true, digits: true, positiveNumber: true, max: 100 },
            amountUpDate: { required: true },
            dateIssueUpDate: { required: true },
            dateExpiryUpDate: { required: true },
            statusUpDate: { required: true },
            payDayUpDate: {required: true},
            categoryUpDate: {required: true},
        },
        messages: {
            numberDocumentUpDate: { required: "Digite o número de um documento." },
            peopleUpDate: { required: "Selecione uma pessoa." },
            paymentMethodUpDate: { required: "Selecione um tipo de pagamento." },
            installmentUpDate: { required: "Digite a(s) parcela(s).", integer: "Digite apenas números inteiros.", digits: "Digite apenas números.", positiveNumber: "Digite apenas números positivos.", max: "Número de parcelas excedido." },
            amountUpDate: { required: "Digite um total." },
            dateIssueUpDate: { required: "Digite uma data de emissão." },
            dateExpiryUpDate: { required: "Digite uma data de vencimento." },
            statusUpDate: { required: "Selecione um status." },
            payDayUpDate: { required: "Digite uma data de pagamento." },
            categoryUpDate: { required: "Selecione uma categoria." },
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
                url: "/financeiro/contas-a-receber/editar",
                data: dados,
                processData: false,
                success: function () {
                    toastr.success('Sucesso: conta(s) a receber editada(s)!');
                    $('#formUpDateAccountReceivable')[0].reset();
                    //$('#formUpDateAccountReceivable').each(function () { this.reset(); });
                    $('#modalUpDateAccountReceivable').modal('hide');
                    $('#listAccountsReceivable').DataTable().ajax.reload();
                },
                error: function () { toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!'); }
            });
            return false;
        }
    });
});
