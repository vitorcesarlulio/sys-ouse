$(document).ready(function () {
    var dataTable = $("#listPeople").DataTable({
        "deferRender": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/pessoas/listar",
            "type": "POST",
            "data": function (data) {
                var startDate = $('#formFiltersPeople #startDate').val();
                var endDate = $('#formFiltersPeople #endDate').val();

                data.startDate = startDate;
                data.endDate = endDate;
            }
        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        },
        "autoWidth": false,
        "columnDefs": [
            { "targets": 5, "width": "10%", "orderable": false, "searchable": false },
            { "targets": 4, "width": "12%" },
        ],
        "responsive": true,
        "lengthChange": true,
        "keys": true,
        "fixedHeader": true,
        "colReorder": true,
        "order": [4, 'asc'],
        "dom": 'B <"clear"> lfrtip',
        lengthMenu: [
            [10, 25, 50, 100, -1],
            ['10', '25', '50', '100', 'Tudo']
        ],
        "buttons": [
            {
                extend: 'collection',
                text: 'Controle',
                autoClose: true,
                buttons:
                    [
                        {
                            extend: 'pageLength',
                            text: 'Resultados por página',
                        },
                        {
                            extend: 'pdfHtml5',
                            key: {
                                key: 'p',
                                altKey: true
                            },
                            text: '<u>P</u>DF &nbsp; <i class="far fa-file-pdf"></i>',
                            orientation: 'landscape',
                            pageSize: 'A4',
                            download: 'open',
                            header: true,
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4],
                                order: "applied"
                            },
                            customize: function (doc) {
                                doc.content[1].table.widths = [
                                    '25%',
                                    '25%',
                                    '15%',
                                    '15%',
                                    '20%'
                                ];
                                doc.pageMargins = [20, 65, 20, 35];
                                doc.defaultStyle.fontSize = 10;
                                doc.styles.tableHeader.fontSize = 12;
                                doc.styles.tableHeader.fillColor = '#ea0029';
                                doc.content.splice(0, 1);
                                doc.defaultStyle.alignment = 'center';
                                var inputDescriptionReport = document.getElementById('descriptionReport');
                                var descriptionReport = inputDescriptionReport.value;

                                doc['header'] = (function () {
                                    return {
                                        columns: [
                                            { image: logoPDF, width: 130 },
                                            { alignment: 'right', fontSize: 13, text: descriptionReport },
                                        ],
                                        margin: 20
                                    }
                                });
                                var now = new Date();
                                var jsDate = now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear();
                                doc['footer'] = (function (page, pages) {
                                    return {
                                        columns: [
                                            {
                                                alignment: 'left', text: ['Criado em: ', { text: jsDate.toString() }]
                                            },
                                            { alignment: 'center', text: 'Ouse - Inteligência em Marcas' },
                                            { alignment: 'right', text: ['Página: ', { text: page.toString() }, ' de: ', { text: pages.toString() }] }
                                        ],
                                        margin: [20, 10, 20, 10]
                                    }
                                });
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<u>E</u>xcel &nbsp; <i class="far fa-file-excel"></i>',
                            key: {
                                key: 'e',
                                altKey: true
                            },
                            exportOptions: { columns: [0, 1, 2, 3, 4], },
                        },
                        {
                            collectionTitle: 'Visibilidade da coluna', text: 'Visibilidade da coluna', extend: 'colvis', collectionLayout: 'two-column'
                        }
                    ]
            }
        ]
    });
    $('#formFiltersPeople #startDate').change(function () {
        dataTable.draw();
    });
    $('#formFiltersPeople #endDate').change(function () {
        dataTable.draw();
    });
});

/* Opção Pessoas Fisica ou Juridica no Cadastro*/
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

// Existe CPF no banco de dados?
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

// Existe CNPJ no banco de dados?
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

/* Letras maisculuas */
$(document).ready(function () {
    $("#companyName").keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });
    $("#fantasyName").keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });
});

// Trazendo via API dados do CNPJ
function ckeckCnpj(cnpj) {
    $.ajax({
        'url': 'https://www.receitaws.com.br/v1/cnpj/' + cnpj.replace(/[^0-9]/g, ''),
        'type': "GET",
        'dataType': 'jsonp',
        'success': function (data) {
            $('#formRegisterPeople #companyName').val(data.nome);
            $('#formRegisterPeople #fantasyName').val(data.fantasia);
            //var cep = data.cep.replace(/[^0-9]/g, '');
            var cep = data.cep.replace(/\.|\-/g, '');
            $('#formRegisterPeople #cep').val(cep);
        }
    })
}

/* Tipo de Redidencia - Cadastro */
function optionTypeResidence() {
    var optionHome = document.getElementById("optionHome").checked;
    var optionCondominium = document.getElementById("optionCondominium").checked;
    $('#edifice').val("");
    $('#block').val("");
    $('#apartment').val("");
    $('#streetCondominium').val("");
    $('#number').val("");

    if (optionHome) {
        $("#divEdifice").hide();
        $("#divBlock").hide();
        $("#divApartment").hide();
        $("#divStreetCondominium").hide();
        $("#divNumber").show();
    } else if (optionCondominium) {
        $("#divEdifice").hide();
        $("#divBlock").hide();
        $("#divApartment").hide();
        $("#divStreetCondominium").show();
        $("#divNumber").show();
    } else {
        $("#divEdifice").show();
        $("#divBlock").show();
        $("#divApartment").show();
        $("#divStreetCondominium").hide();
        $("#divNumber").hide();
    }
}

/* Editar Pessoa */
$(document).on('click', '.btn-edit-people', function () {
    var idPeople = $(this).attr("id");

    $.ajax({
        url: "/pessoas/listar-contatos",
        type: 'POST',
        data: { idPeople: idPeople },
        dataType: 'json',
        success: function (response) {
            if (response) {
                //remover as div de contato quando eu clico em outro contato p nao ir contatos que nao é daquela pessoa
                $("#trContacts").remove();
                for (people of response) {
                    $("#tBodyTableContact").append(
                        `<tr id="trContacts">
                            <td>` + people.cont_tipo + `</td>
                            <td>` + people.cont_responsavel + `</td>
                            <td>` + people.cont_contato + `</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" name="deleteContact" class="btn btn-danger btn-delete-contact" id="` + people.cont_codigo + `"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>`
                    );
                }
                //Atribuindo o id da pessoa no btn para poder pegar ele e fazer o cadastro
                $(".btn-save-contact").attr("id", idPeople);
            }
        }
    });

    // Trazendo os dados da pessoa
    $.ajax({
        url: "/pessoas/listar-editar",
        type: 'POST',
        data: { idPeopleEdit: idPeople },
        success: function (data) {
            if (JSON.parse(data).length) {
                var dadosJson = JSON.parse(data)[0];

                $('#modalEditPeople #idPeopleEdit').val(dadosJson.pess_codigo);

                if (dadosJson.pess_tipo === "F") {
                    $("#modalEditPeople #divPhysicalPersonEdit").show();
                    $("#modalEditPeople #divNameEdit").show();
                    $("#modalEditPeople #divSurnameEdit").show();
                    $("#modalEditPeople #divTypeResidenceEdit").show();

                    $('#modalEditPeople #cpfEdit').val(dadosJson.pess_cpfcnpj);
                    $('#modalEditPeople #nameEdit').val(dadosJson.pess_nome);
                    $('#modalEditPeople #surnameEdit').val(dadosJson.pess_sobrenome);
                    $('#modalEditPeople #cepEdit').val(dadosJson.pess_cep);
                    $('#modalEditPeople #logradouroEdit').val(dadosJson.pess_logradouro);
                    $('#modalEditPeople #bairroEdit').val(dadosJson.pess_bairro);
                    $('#modalEditPeople #localidadeEdit').val(dadosJson.pess_cidade);
                    $('#modalEditPeople #ufEdit').val(dadosJson.pess_estado);

                    $("#modalEditPeople #physicalLegalEdit").hide();
                    $("#modalEditPeople #divCompanyNameEdit").hide();
                    $("#modalEditPeople #divFantasyNameEdit").hide();
                    $("#modalEditPeople #divNumberEdit").hide();

                    if (dadosJson.pess_edificio !== "") {
                        $("#modalEditPeople #optionBuildingEdit").prop("checked", true);

                        $("#modalEditPeople #divEdificeEdit").show();
                        $("#modalEditPeople #divBlockEdit").show();
                        $("#modalEditPeople #divApartmentEdit").show();
                        $("#modalEditPeople #divStreetCondominiumEdit").hide();
                        $("#modalEditPeople #divNumberEdit").hide();
                    } else if (dadosJson.pess_logradouro_condominio !== "") {
                        $("#modalEditPeople #optionCondominiumEdit").prop("checked", true);

                        $("#modalEditPeople #divStreetCondominiumEdit").show();
                        $("#modalEditPeople #divNumberEdit").show();
                        $('#modalEditPeople #modalEditPeople #numberEdit').val(dadosJson.pess_log_numero);

                        $("#modalEditPeople #divEdificeEdit").hide();
                        $("#modalEditPeople #divBlockEdit").hide();
                        $("#modalEditPeople #divApartmentEdit").hide();
                    } else if (dadosJson.pess_log_numero !== "" && dadosJson.pess_logradouro_condominio == "") {
                        $("#modalEditPeople #optionHomeEdit").prop("checked", true);

                        $("#modalEditPeople #divNumberEdit").show();
                        $('#modalEditPeople #numberEdit').val(dadosJson.pess_log_numero);
                        $("#modalEditPeople #divEdificeEdit").hide();
                        $("#modalEditPeople #divBlockEdit").hide();
                        $("#modalEditPeople #divApartmentEdit").hide();
                        $("#modalEditPeople #divStreetCondominiumEdit").hide();
                    }

                } else {
                    $("#modalEditPeople #physicalLegalEdit").show();
                    $("#modalEditPeople #divCompanyNameEdit").show();
                    $("#modalEditPeople #divFantasyNameEdit").show();
                    $("#modalEditPeople #divNumberEdit").show();

                    $('#modalEditPeople #cnpjEdit').val(dadosJson.pess_cpfcnpj);
                    $('#modalEditPeople #companyNameEdit').val(dadosJson.pess_razao_social);
                    $('#modalEditPeople #fantasyNameEdit').val(dadosJson.pess_nome_fantasia);
                    $('#modalEditPeople #cepEdit').val(dadosJson.pess_cep);
                    $('#modalEditPeople #logradouroEdit').val(dadosJson.pess_logradouro);
                    $('#modalEditPeople #bairroEdit').val(dadosJson.pess_bairro);
                    $('#modalEditPeople #localidadeEdit').val(dadosJson.pess_cidade);
                    $('#modalEditPeople #ufEdit').val(dadosJson.pess_estado);
                    $('#modalEditPeople #numberEdit').val(dadosJson.pess_log_numero);

                    $("#modalEditPeople #divPhysicalPersonEdit").hide();
                    $("#modalEditPeople #divNameEdit").hide();
                    $("#modalEditPeople #divSurnameEdit").hide();
                    $("#modalEditPeople #divTypeResidenceEdit").hide();
                }

                $('#modalEditPeople #dateInsertEdit').val(dadosJson.pess_data_cadastro);
                $('#modalEditPeople #observationEdit').val(dadosJson.pess_observacao);

                $('#modalEditPeople').modal('show');
            }
        }
    });
});

// Salvar Contato
$(document).on('click', '.btn-save-contact', function () {
    var typeContact = $('#tBodyTableContact #selectTypeContact').val();
    var responsibleContact = $('#tBodyTableContact #responsibleContact').val();
    if ($('#tBodyTableContact #cellphoneContact').val() !== "" && $('#tBodyTableContact #cellphoneContact').val() !== null) {
        var contact = $('#tBodyTableContact #cellphoneContact').val();
    } else if ($('#tBodyTableContact #telephoneContact').val() !== "" && $('#tBodyTableContact #telephoneContact').val() !== null) {
        var contact = $('#tBodyTableContact #telephoneContact').val();
    } else {
        var contact = $('#tBodyTableContact #emailContact').val();
    }
    var idPeopleContact = $(this).attr("id");

    $.ajax({
        url: "/pessoas/cadastrar-contato",
        type: 'POST',
        data: { typeContact: typeContact, responsibleContact: responsibleContact, contact: contact, idPeopleContact: idPeopleContact },
        success: function (retunAjax) {
            if (retunAjax === true) {
                toastr.success('Sucesso: contato cadastrado!');
                //$('.btn-save-contact').prop("disabled",true);
                $("#tBodyTableContact").append(
                    `<tr id="trContacts">
                    <td>` + typeContact + `</td>
                    <td>` + responsibleContact + `</td>
                    <td>` + contact + `</td>
                    <td> 
                        <div class="btn-group btn-group-sm">
                            <a href="/pessoas"><button type="button" name="saveContact" class="btn btn-primary"><i class="fas fa-sync-alt"></i></button></a>
                        </div>
                    </td>
                </tr>`);
                $('#tBodyTableContact #responsibleContact').val("");
                $('#tBodyTableContact #cellphoneContact').val("");
                $('#tBodyTableContact #telephoneContact').val("");
                $('#tBodyTableContact #emailContact').val("");
            }
            else if (retunAjax === false) { toastr.error('Erro: contato não cadastrado!'); }
            else { toastr.warning('Preencha todos os campos!'); }
        },
        error: function () { toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!'); }
    });
});

// Tipo de Contato
window.onload = function () {
    var select = document.getElementById("selectTypeContact").addEventListener('change', function () {
        if (this.value == 'Celular') {
            $("#tBodyTableContact #tdTelephone").hide();
            $("#tBodyTableContact #tdEmail").hide();
            $("#tBodyTableContact #tdCellphone").show();
        } else if (this.value == 'Telefone') {
            $("#tBodyTableContact #tdCellphone").hide();
            $("#tBodyTableContact #tdEmail").hide();
            $("#tBodyTableContact #tdTelephone").show();
        } else {
            $("#tBodyTableContact #tdCellphone").hide();
            $("#tBodyTableContact #tdTelephone").hide();
            $("#tBodyTableContact #tdEmail").show();
        }
    });
}

// Deletar Contato
$(document).on('click', '.btn-delete-contact', function () {
    var idContact = $(this).attr("id");
    $.ajax({
        url: "/pessoas/deletar-contato",
        type: 'POST',
        data: { idContact: idContact },
        success: function (retunAjax) {
            if (retunAjax === true) {
                toastr.success('Sucesso: contato apagado!');
                //Remover o contato do html sem recarregar a pagina
                $('#' + idContact).remove();
            } else {
                toastr.error('Erro: contato não apagado!');
            }
        },
        error: function () {
            toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!');
        }
    });
});

// Busca CEP do editar
function callbackCep(conteudo) {
    if (!("erro" in conteudo)) {
        $('#modalEditPeople #logradouroEdit').val(conteudo.logradouro);
        $('#modalEditPeople #bairroEdit').val(conteudo.bairro);
        $('#modalEditPeople #localidadeEdit').val(conteudo.localidade);
        $('#modalEditPeople #ufEdit').val(conteudo.uf);
    }
    else {
        alert("CEP não encontrado.");
    }
}
function pesquisaCep(valor) {
    var cep = valor.replace(/\D/g, '');
    if (cep != "") {
        var validaCep = /^[0-9]{8}$/;
        if (validaCep.test(cep)) {
            var script = document.createElement('script');
            script.src = '//viacep.com.br/ws/' + cep + '/json/?callback=callbackCep';
            document.body.appendChild(script);
        }
        else {
            alert("Formato de CEP inválido.");
        }
    }
    else {
        alert("Informe o CEP.");
    }
};

/* Tipo de Redidencia - Cadastro */
function optionTypeResidenceEdit() {
    var optionHomeEdit = document.getElementById("optionHomeEdit").checked;
    var optionCondominiumEdit = document.getElementById("optionCondominiumEdit").checked;
    $('#modalEditPeople #edificeEdit').val("");
    $('#modalEditPeople #blockEdit').val("");
    $('#modalEditPeople #apartmentEdit').val("");
    $('#modalEditPeople #streetCondominiumEdit').val("");
    $('#modalEditPeople #numberEdit').val("");

    if (optionHomeEdit) {
        $("#modalEditPeople #divEdificeEdit").hide();
        $("#modalEditPeople #divBlockEdit").hide();
        $("#modalEditPeople #divApartmentEdit").hide();
        $("#modalEditPeople #divStreetCondominiumEdit").hide();
        $("#modalEditPeople #divNumberEdit").show();
    } else if (optionCondominiumEdit) {
        $("#modalEditPeople #divEdificeEdit").hide();
        $("#modalEditPeople #divBlockEdit").hide();
        $("#modalEditPeople #divApartmentEdit").hide();
        $("#modalEditPeople #divStreetCondominiumEdit").show();
        $("#modalEditPeople #divNumberEdit").show();
    } else {
        $("#modalEditPeople #divEdificeEdit").show();
        $("#modalEditPeople #divBlockEdit").show();
        $("#modalEditPeople #divApartmentEdit").show();
        $("#modalEditPeople #divStreetCondominiumEdit").hide();
        $("#modalEditPeople #divNumberEdit").hide();
    }
}

/* Excluir Pessoa */
/* $(document).on('click', '.btn-delete-people', function () {
    let idPeople = $(this).attr('data-id');
    $('#modalonfirmDeletePeople').modal('show');
    $('#ppp').text(idPeople);

     $(document).on('click', '#btnConfirmDeletePeople', function () {
        alert(idPeople);
   
         $.ajax({
            url: "/pessoas/apagar",
            method: "POST",
            data: { idPeople: idPeople },
            success: function (retunAjax) {
                if (retunAjax === true) {
                    toastr.success('Sucesso: pessoas apagada!');
                    $('#listPeople').DataTable().ajax.reload();
                    return;
                } else {
                    toastr.error('Erro: pessoas não apagada!');
                    //$('#listPeople').DataTable().ajax.reload();
                    return;
                }
            },
            error: function () {
                toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!');
            }
        }); 
    }); 
 
    
}); */

function deletePeople(pess_codigo) {
    console.log(pess_codigo);
    $('#modalonfirmDeletePeople').modal('show');

    $(document).on('click', '#btnConfirmDeletePeople', function () {
        alert(pess_codigo);

        $.ajax({
            url: "/pessoas/apagar",
            method: "POST",
            data: { idPeople: pess_codigo },
            success: function (retunAjax) {
                if (retunAjax === true) {
                    toastr.success('Sucesso: pessoa deletada!');
                    $('#listPeople').DataTable().ajax.reload();
                    return;
                } else {
                    toastr.error('Erro: pessoa não deletada!');
                    return;
                }
            },
            error: function () {
                toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!');
            }
        });
    });
}


