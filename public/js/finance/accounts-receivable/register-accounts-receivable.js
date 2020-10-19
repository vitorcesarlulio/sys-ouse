$(document).ready(function () {
    $('#formRegisterAccountsReceivable').validate({
        rules: {
            peopleRegister: { required: true },
            paymentMethodRegister: { required: true },
            installmentRegister: { required: true, integer: true, digits: true, positiveNumber: true, max: 100 },
            amountRegister: { required: true },
            dateIssueRegister: { required: true },
            dateExpiryRegister: { required: true },
            statusRegister: { required: true },
            otherStatusRegister: { required: true },
        },
        messages: {
            peopleRegister: { required: "Selecione uma pessoa." },
            paymentMethodRegister: { required: "Selecione um tipo de pagamento." },
            installmentRegister: { required: "Digite a(s) parcela(s).", integer: "Digite apenas números inteiros.", digits: "Digite apenas números.", positiveNumber: "Digite apenas números positivos.", max: "Número de parcelas excedido." },
            amountRegister: { required: "Digite um total." },
            dateIssueRegister: { required: "Digite uma data de emissão." },
            dateExpiryRegister: { required: "Digite uma data de vencimento." },
            statusRegister: { required: "Selecione um status." },
            otherStatusRegister: { required: "Digite um status." },
            classificationRegister: { required: "Selecione uma classificação." },
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
                url: "/financeiro/contas-a-receber/cadastar",
                data: dados,
                processData: false,
                success: function () {
                    toastr.success('Sucesso: conta(s) a receber cadastrada(s)!');
                    $('#modalRegisterAccountsReceivable').modal('hide');
                    $('#formRegisterAccountsReceivable').each(function () { this.reset(); });
                    $('#listAccountsReceivable').DataTable().ajax.reload();
                },
                error: function () { toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!'); }
            });
            return false;
        }
    });
});
