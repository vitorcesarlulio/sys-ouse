/* Letras maisculuas */
$(document).ready(function () {
    $("#loginUserRegister").keyup(function () {
        $(this).val($(this).val().toUpperCase());
    });
});

// Envaindo os dados via Ajax para ver se ja existe o usuario
function findLogin() {
    var dados = $('#loginUserRegister').serialize();
    $.ajax({
        type: "POST",
        url: "/usuarios/verificar-existencia-usuario",
        data: dados,
        processData: false,
        success: function (returnAjax) {
            if (returnAjax == true) {
                toastr.error('Erro: usuário já existente no banco de dados!');
                $('.btn-register-user').attr('disabled', true);
            } else {
                $('.btn-register-user').attr('disabled', false);
            }
        },
        error: function () {
            toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!');
        }
    });
}

// Função para exibir a senha no Cadastro 
function showPassword() {
    if ($("#passwordUserRegister").is(":password")) {
        $("#passwordUserRegister").prop('type', 'text');
        $("#iconPasswordRegister").prop('class', 'far fa-eye-slash');
    } else {
        $("#passwordUserRegister").prop('type', 'password');
        $("#iconPasswordRegister").prop('class', 'far fa-eye');
    }
}
// Função para exibir a confirm senha no Cadastro 
function showPasswordConfirm() {
    if ($("#confirmationPasswordRegister").is(":password")) {
        $("#confirmationPasswordRegister").prop('type', 'text');
        $("#iconPasswordRegisterConfirm").prop('class', 'far fa-eye-slash');
    } else {
        $("#confirmationPasswordRegister").prop('type', 'password');
        $("#iconPasswordRegisterConfirm").prop('class', 'far fa-eye');
    }
}

/* Esquema dos botoes de permissao */
$("#modalRegisterUser #permitionUserRegister").click(function () {
    $('#modalRegisterUser #permitionAdminRegister').attr('checked', false);
    $('#modalRegisterUser #divPermitionAdminRegister').attr('class', 'btn btn-secondary');
    $('#modalRegisterUser #permitionUserRegister').attr('checked', true);
});

$("#modalRegisterUser #permitionAdminRegister").click(function () {
    $('#modalRegisterUser #permitionUserRegister').attr('checked', false);
    $('#modalRegisterUser #divPermitionUserRegister').attr('class', 'btn btn-secondary');
    $('#modalRegisterUser #permitionAdminRegister').attr('checked', true);
});

/* Esquema dos botoes de status */
$("#modalRegisterUser #statusActiveUserRegister").click(function () {
    $('#modalRegisterUser #statusInactiveRegister').attr('checked', false);
    $('#modalRegisterUser #divStatusInactiveUserRegister').attr('class', 'btn btn-secondary');
    $('#modalRegisterUser #statusActiveUserRegister').attr('checked', true);
});

$("#modalRegisterUser #statusInactiveRegister").click(function () {
    $('#modalRegisterUser #statusActiveUserRegister').attr('checked', false);
    $('#modalRegisterUser #divStatusActiveUserRegister').attr('class', 'btn btn-secondary');
    $('#modalRegisterUser #statusInactiveRegister').attr('checked', true);
});

/* Editar Usuario */
$(document).on('click', '.btn-edit-user', function () {
    var id = $(this).attr("id");
    $('#modalEditUser #idUserEdit').val(id);
    $.ajax({
        url: "/usuarios/listar-editar",
        type: 'POST',
        data: {
            idUserEdit: $(this).attr("id")
        },
        success: function (data) {
            if (JSON.parse(data).length) {
                var dadosJson = JSON.parse(data)[0];

                $('#modalEditUser #nameUserEdit').val(dadosJson.nameUser);
                $('#modalEditUser #surnameUserEdit').val(dadosJson.surnameUser);
                $('#modalEditUser #loginUserEdit').val(dadosJson.loginUser);
                $('#modalEditUser #loginUserEdit').val(dadosJson.loginUser);

                if (dadosJson.permitionUser === "admin") {
                    $('#modalEditUser #permitionUserEdit').attr('checked', false);
                    $('#modalEditUser #labelUserPermition').attr('class', 'btn btn-secondary');

                    $('#modalEditUser #permitionAdminEdit').val(dadosJson.permitionUser);
                    $('#modalEditUser #labelAdminPermition').attr('class', 'btn btn-secondary active');
                    $('#modalEditUser #permitionAdminEdit').attr('checked', '');
                } else {
                    $('#modalEditUser #permitionAdminEdit').attr('checked', false);
                    $('#modalEditUser #labelAdminPermition').attr('class', 'btn btn-secondary');

                    $('#modalEditUser #permitionUserEdit').val(dadosJson.permitionUser);
                    $('#modalEditUser #labelUserPermition').attr('class', 'btn btn-secondary active');
                    $('#modalEditUser #permitionUserEdit').attr('checked', true);
                }

                if (dadosJson.statusUser === "I") {
                    $('#modalEditUser #statusActiveUserEdit').attr('checked', false);
                    $('#modalEditUser #labelUserStatusActive').attr('class', 'btn btn-secondary');

                    //$('#modalEditUser #statusInactiveUserEdit').val(dadosJson.statusUser);
                    $('#modalEditUser #labelUserStatusInactive').attr('class', 'btn btn-secondary active');
                    $('#modalEditUser #statusInactiveUserEdit').attr('checked', '');
                } else {
                    $('#modalEditUser #statusInactiveUserEdit').attr('checked', false);
                    $('#modalEditUser #labelUserStatusInactive').attr('class', 'btn btn-secondary');

                    //$('#modalEditUser #statusActiveUserEdit').val(dadosJson.statusUser);
                    $('#modalEditUser #labelUserStatusActive').attr('class', 'btn btn-secondary active');
                    $('#modalEditUser #statusActiveUserEdit').attr('checked', true);
                }

                $('#modalEditUser').modal('show');
            }
        }
    });
});

// Função para exibir a senha no editar 
function showPasswordEdit() {
    if ($("#passwordUserEdit").is(":password")) {
        $("#passwordUserEdit").prop('type', 'text');
        $("#iconPasswordEdit").prop('class', 'far fa-eye-slash');
    } else {
        $("#passwordUserEdit").prop('type', 'password');
        $("#iconPasswordEdit").prop('class', 'far fa-eye');
    }
}

// Função para exibir a confirm senha no editar 
function showPasswordConfirmEdit() {
    if ($("#confirmationPasswordEdit").is(":password")) {
        $("#confirmationPasswordEdit").prop('type', 'text');
        $("#iconPasswordEditConfirm").prop('class', 'far fa-eye-slash');
    } else {
        $("#confirmationPasswordEdit").prop('type', 'password');
        $("#iconPasswordEditConfirm").prop('class', 'far fa-eye');
    }
}

//quando ele clicar em um dos botoes faz o inverso com o outro
$("#modalEditUser #permitionUserEdit").click(function () {
    $('#modalEditUser #permitionAdminEdit').attr('checked', false);
    $('#modalEditUser #permitionUserEdit').attr('checked', true);
});

$("#modalEditUser #permitionAdminEdit").click(function () {
    $('#modalEditUser #permitionUserEdit').attr('checked', false);
    $('#modalEditUser #permitionAdminEdit').attr('checked', true);
});

//quando ele clicar em um dos botoes faz o inverso com o outro
$("#modalEditUser #statusActiveUserEdit").click(function () {
    $('#modalEditUser #statusInactiveUserEdit').attr('checked', false);
    $('#modalEditUser #statusActiveUserEdit').attr('checked', true);
});

$("#modalEditUser #statusInactiveUserEdit").click(function () {
    $('#modalEditUser #statusActiveUserEdit').attr('checked', false);
    $('#modalEditUser #statusInactiveUserEdit').attr('checked', true);
});


$(document).ready(function () {
    var dataTable = $("#listUsers").DataTable({
        "deferRender": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/usuarios/listar",
            "type": "POST",
            "data": function (data) {
                var startDate = $('#formFiltersUsers #startDate').val();
                var endDate = $('#formFiltersUsers #endDate').val();
                var statusUser = $('#formFiltersUsers #statusUser').val();
                var accessLevel = $('#formFiltersUsers #accessLevel').val();
                var filterLogin = $('#formFiltersUsers #filterLogin').val();

                data.startDate = startDate;
                data.endDate = endDate;
                data.statusUser = statusUser;
                data.accessLevel = accessLevel;
                data.filterLogin = filterLogin;
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
                autoClose: true, //fechar o modalzinho
                buttons:
                    [
                        { extend: 'pageLength', text: 'Resultados por página' },
                        {
                            extend: 'pdfHtml5',
                            key: { key: 'p', altKey: true },
                            text: '<u>P</u>DF &nbsp; <i class="far fa-file-pdf"></i>',
                            orientation: 'portrait',
                            pageSize: 'A4',
                            download: 'open',
                            header: true,
                            exportOptions: { columns: [0, 1, 2, 3, 4], order: "applied" },
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
                                            { alignment: 'left', text: ['Criado em: ', { text: jsDate.toString() }] },
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
                            key: { key: 'e', altKey: true },
                            exportOptions: { columns: [0, 1, 2, 3, 4] },
                        },
                        {
                            collectionTitle: 'Visibilidade da coluna', text: 'Visibilidade da coluna', extend: 'colvis', collectionLayout: 'two-column'
                        },
                    ]
            }
        ]
    });
    $('#formFiltersUsers #startDate').keyup(function () {
        dataTable.draw();
    });
    $('#formFiltersUsers #endDate').keyup(function () {
        dataTable.draw();
    });
    $('#formFiltersUsers #statusUser').change(function () {
        dataTable.draw();
    });
    $('#formFiltersUsers #accessLevel').change(function () {
        dataTable.draw();
    });
    $('#formFiltersUsers #filterLogin').change(function () {
        dataTable.draw();
    });
});