$(document).ready(function(){
    var idPeople = $('#idPeople').attr("value");
    console.log(idPeople);
 });

/**
* Opção Pessoas Fisica ou Juridica 
*/
function selTypePerson() {
    var optionPhysicalPerson = document.getElementById("optionPhysicalPerson").checked;
    if (optionPhysicalPerson) {
        $("#physicalLegal").hide();
        $("#divCompanyName").hide();
        $("#divFantasyName").hide();
        $("#divNumber").hide();

        $("#divPhysicalPerson").show();
        $("#divName").show();
        $("#divSurname").show();
        $("#divTypeResidence").show();
        $("#cnpj").val("");
    } else {
        $("#divPhysicalPerson").hide();
        $("#divName").hide();
        $("#divSurname").hide();
        $("#divTypeResidence").hide();

        $("#physicalLegal").show();
        $("#divCompanyName").show();
        $("#divFantasyName").show();
        $("#divNumber").show();
        $("#cpf").val("");
    }
}

// Envaindo os dados via Ajax para ver se ja existe o usuario
$('#cnpj').blur(function () {
    var dados = $('#cnpj').serialize();
    $.ajax({
        type: "POST",
        url: "/pessoas/verificar-existencia-pessoa",
        data: dados,
        processData: false,
        success: function (returnAjax) {
            if (returnAjax === 'foundCnpj') {
                toastr.warning('Erro: CNPJ já existente no banco de dados!');
                $('#btnRegisterPeople').hide();
            } else {
                $('#btnRegisterPeople').show();
            }
        },
        error: function () {
            toastr.error('Erro: não foi possível verificar a pessoa, contate o administrador do sistema!');
        }
    });
});

function findCPF() {
    var dados = $('#cpf').serialize();
    $.ajax({
        type: "POST",
        url: "/pessoas/verificar-existencia-pessoa",
        data: dados,
        processData: false,
        success: function (returnAjax) {
            if (returnAjax === 'foundCpf') {
                toastr.warning('Erro: CPF já existente no banco de dados!');
                $('#btnRegisterPeople').hide();
            } else {
                $('#btnRegisterPeople').show();
            }
        },
        error: function () {
            toastr.error('Erro: não foi possível verificar a pessoa, contate o administrador do sistema!');
        }
    });
}

function ckeckCnpj(cnpj) {
    $.ajax({
        'url': 'https://www.receitaws.com.br/v1/cnpj/' + cnpj.replace(/[^0-9]/g, ''),
        'type': "GET",
        'dataType': 'jsonp',
        'success': function (data) {
            $('#formRegisterPeople #companyName').val(data.nome);
            $('#formRegisterPeople #fantasyName').val(data.fantasia);
            var cep = data.cep.replace(/[^0-9]/g, '');
            $('#formRegisterPeople #cep').val(cep);
        }
    })
}

/* Letras maisculuas */
$(document).ready(function () {
    $("#companyName").keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });
    $("#fantasyName").keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });
});

/* Função para mostrar ou ocultar campo de acordo com seleção (Tipo de residencia) */
function optionTypeResidence() {
    var optionHome = document.getElementById("optionHome").checked;
    var optionCondominium = document.getElementById("optionCondominium").checked;
    if (optionHome) {
        $('#edifice').val("");
        $('#block').val("");
        $('#apartment').val("");
        $('#streetCondominium').val("");
        $('#number').val("");

        $("#divEdifice").hide();
        $("#divBlock").hide();
        $("#divApartment").hide();
        $("#divStreetCondominium").hide();
        $("#divNumber").show();
    } else if (optionCondominium) {
        $('#edifice').val("");
        $('#block').val("");
        $('#apartment').val("");
        $('#streetCondominium').val("");
        $('#number').val("");

        $("#divEdifice").hide();
        $("#divBlock").hide();
        $("#divApartment").hide();
        $("#divStreetCondominium").show();
        $("#divNumber").show();
    } else {
        $('#edifice').val("");
        $('#block').val("");
        $('#apartment').val("");
        $('#streetCondominium').val("");
        $('#number').val("");

        $("#divEdifice").show();
        $("#divBlock").show();
        $("#divApartment").show();
        $("#divStreetCondominium").hide();
        $("#divNumber").hide();
    }
}