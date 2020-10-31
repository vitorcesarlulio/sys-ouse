function showDivPayday() {
    if ($('#settledRegister').is(":checked")) {
        $("#divPaydayRegister").show();
        $("#statusRegister").val("PAGO");
    } else {
        $("#divPaydayRegister").hide();
        $("#statusRegister").val("ABERTO");
    }
}

function showSettledRegister() {
    if ($("#installmentRegister").val() === "1") {
        $("#divSettledRegister").show();
    } else {
        $("#divSettledRegister").hide();
        $('#divSettledRegister').attr('checked', false);

        $("#divPaydayRegister").hide();
        $("#divPaydayRegister").val("");

        $("#statusRegister").val("ABERTO");
    }
}

$(document).ready(function () {
    $("#amountRegister").inputmask('decimal', {
        radixPoint: ",",
        groupSeparator: ".",
        autoGroup: true,
        digits: 2,
        digitsOptional: false,
        placeholder: '0',
        rightAlign: false,
        onBeforeMask: function (value, opts) {
            return value;
        }
    });
});

/* window.onload = function () {
    var select = document.getElementById("statusRegister").addEventListener('change', function () {
        if (this.value === "Outro") {
            $("#divOtherStatus").show();
        } else {
            $("#divOtherStatus").hide();
        }
    });
} */

$(document).ready(function () {
    var dataTable = $("#listAccountsReceivable").DataTable({
        "deferRender": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/financeiro/contas-a-receber/listar",
            "type": "POST",
            "data": function (data) {
                var filterExpirationDate = $('#formFiltersAccountsReceivable #filterExpirationDate').val();
                data.filterExpirationDate = filterExpirationDate;

                var filterDateIssue = $('#formFiltersAccountsReceivable #filterDateIssue').val();
                data.filterDateIssue = filterDateIssue;

                var filterPayday = $('#formFiltersAccountsReceivable #filterPayday').val();
                data.filterPayday = filterPayday;

                var filterStartDate = $('#formFiltersAccountsReceivable #filterStartDate').val();
                data.filterStartDate = filterStartDate;

                var filterEndDate = $('#formFiltersAccountsReceivable #filterEndDate').val();
                data.filterEndDate = filterEndDate;

                var dateExperyNext = $('#formFiltersAccountsReceivable #dateExperyNext').val();
                data.dateExperyNext = dateExperyNext;

                var overdueAccounts = $('#formFiltersAccountsReceivable #overdueAccounts').val();
                data.overdueAccounts = overdueAccounts;

                var filterAccountPayment = $('#formFiltersAccountsReceivable #filterAccountPayment').val();
                data.filterAccountPayment = filterAccountPayment;

                var statusFilter = $('#formFiltersAccountsReceivable #statusFilter').val();
                data.statusFilter = statusFilter;

                var filterCategory = $('#formFiltersAccountsReceivable #filterCategory').val();
                data.filterCategory = filterCategory;
            }
        },
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json" },
        drawCallback: function (settings) {
            $('#total_order').html('Total: R$ ' + settings.json.total);
        },
        rowCallback: function (row, data) {
           //Se for diferente de Pago entao eu vejo se a data de vencimento é menor que hoje e pinto de vermelho a linha
            if (data[10] != `<span class="badge badge-success badge-pay">PAGO</span>`) {
                var dateNow = moment(new Date(), 'DD/MM/YYYY');
                var dateExpiry = moment(data[7], 'DD/MM/YYYY');
                if (dateExpiry < dateNow) {
                    $(row).css('background-color', '#b11800'); //#b11800
                }
            }
        },
        "autoWidth": false,
        "columnDefs": [
            { "targets": 4, "width": "10%", "orderable": false, "searchable": false },
            { "targets": 0, "width": "15%" },
        ],
        "responsive": true,
        "lengthChange": true,
        "keys": true,
        "fixedHeader": true,
        //"colReorder": true,
        "order": [7, 'DESC'], //ordenar coluna
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
                        { extend: 'pageLength', text: 'Resultados por página' },
                        {
                            extend: 'pdfHtml5',
                            key: {
                                key: 'p',
                                altKey: true
                            },
                            text: '<u>P</u>DF &nbsp; <i class="far fa-file-pdf"></i>',
                            orientation: 'landscape',
                            pageSize: 'A4', //TABLOID
                            download: 'open',
                            header: true,
                            /* footer: true, */
                            messageTop: function () {
                                return $("#total_order").text();
                            },
                            messageBottom: function () {
                                return 'Nº de registros: ' + dataTable.rows().count();
                            },
                            /* exportOptions: {
                                columns: [0, 1, 2, 3],
                                order: "applied"
                                columns: ':visible',
                        search: 'applied',
                        order: 'applied'
                            }, */
                            customize: function (doc) {
                                /* doc.content[1].table.widths = [
                                    '10%',
                                    '28%',
                                    '12%',
                                    '50%'
                                ]; */
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
                            //exportOptions: { columns: [0, 1, 2, 3, 4], },
                        },
                        {
                            extend: 'copy',
                            text: 'Copiar',
                            exportOptions: {
                                modifier: {
                                    page: 'current'
                                }
                            }
                        },
                        {
                            extend: 'csv',
                            text: 'CSV',
                            charset: 'UTF-8',
                            fieldSeparator: ';',
                            //filename: 'export',
                            //bom: true, fica igual excel
                            //extension: '.csv',
                            exportOptions: {
                                modifier: {
                                    search: 'none'
                                }
                            }
                        },
                        {
                            collectionTitle: 'Visibilidade da coluna', text: 'Visibilidade da coluna', extend: 'colvis', collectionLayout: 'two-column'
                        }
                    ]
            }
        ]
    });

    // Data de vencimento
    $('#formFiltersAccountsReceivable #filterExpirationDate').click(function () {
        $('#formFiltersAccountsReceivable #h5DateStartDateAnd').text("Data de Vencimento");
        $('#formFiltersAccountsReceivable #divDateStart').show();
        $('#formFiltersAccountsReceivable #divDateEnd').show();
        $('#formFiltersAccountsReceivable #filterExpirationDate').val('filterExpirationDate');
        if ($('#formFiltersAccountsReceivable #filterStartDate').val != "" && $('#formFiltersAccountsReceivable #filterEndDate').val != "") {
            $('#formFiltersAccountsReceivable #filterEndDate').change(function () {
                dataTable.draw();
                var filterStartDate1 = $('#formFiltersAccountsReceivable #filterStartDate').val();
                var formatFilterStartDate = filterStartDate1.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');
                var filterEndDate1 = $('#formFiltersAccountsReceivable #filterEndDate').val();
                var formatFilterEndDate = filterEndDate1.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');
                $('#formFiltersAccountsReceivable #descriptionReport').val($('#formFiltersAccountsReceivable #descriptionReport').val() + "Data de Vencimento: de " + formatFilterStartDate + " a " + formatFilterEndDate);
            });
        };
    });

    // Data de emissão 
    $('#formFiltersAccountsReceivable #filterDateIssue').click(function () {
        $('#formFiltersAccountsReceivable #h5DateStartDateAnd').text("Data de Emissão");
        $('#formFiltersAccountsReceivable #divDateStart').show();
        $('#formFiltersAccountsReceivable #divDateEnd').show();
        $('#formFiltersAccountsReceivable #filterDateIssue').val('filterDateIssue');
        if ($('#formFiltersAccountsReceivable #filterStartDate').val != "" && $('#formFiltersAccountsReceivable #filterEndDate').val != "") {
            $('#formFiltersAccountsReceivable #filterEndDate').change(function () {
                dataTable.draw();
                var filterStartDate1 = $('#formFiltersAccountsReceivable #filterStartDate').val();
                var formatFilterStartDate = filterStartDate1.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');
                var filterEndDate1 = $('#formFiltersAccountsReceivable #filterEndDate').val();
                var formatFilterEndDate = filterEndDate1.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');
                $('#formFiltersAccountsReceivable #descriptionReport').val($('#formFiltersAccountsReceivable #descriptionReport').val() + "Data de Emissão: de " + formatFilterStartDate + " a " + formatFilterEndDate);
            });
        };
    });

    // Data de pagamento 
    $('#formFiltersAccountsReceivable #filterPayday').click(function () {
        $('#formFiltersAccountsReceivable #h5DateStartDateAnd').text("Data de Pagamento");
        $('#formFiltersAccountsReceivable #divDateStart').show();
        $('#formFiltersAccountsReceivable #divDateEnd').show();
        $('#formFiltersAccountsReceivable #filterPayday').val('filterPayday');
        if ($('#formFiltersAccountsReceivable #filterStartDate').val != "" && $('#formFiltersAccountsReceivable #filterEndDate').val != "") {
            $('#formFiltersAccountsReceivable #filterEndDate').change(function () {
                dataTable.draw();
                var filterStartDate1 = $('#formFiltersAccountsReceivable #filterStartDate').val();
                var formatFilterStartDate = filterStartDate1.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');
                var filterEndDate1 = $('#formFiltersAccountsReceivable #filterEndDate').val();
                var formatFilterEndDate = filterEndDate1.replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1');
                $('#formFiltersAccountsReceivable #descriptionReport').val($('#formFiltersAccountsReceivable #descriptionReport').val() + "Data de Pagamento: de " + formatFilterStartDate + " a " + formatFilterEndDate);
            });
        };
    });

    // Proximas ao vencimento
    $('#formFiltersAccountsReceivable #dateExperyNext').click(function () {
        $('#formFiltersAccountsReceivable #dateExperyNext').val('dateExperyNext');
        dataTable.draw();
        $('#formFiltersAccountsReceivable #descriptionReport').val("Contas próximas ao vecimento");
    });

    // Contas vencidas
    $('#formFiltersAccountsReceivable #overdueAccounts').click(function () {
        $('#formFiltersAccountsReceivable #overdueAccounts').val('overdueAccounts');
        dataTable.draw();
        $('#formFiltersAccountsReceivable #descriptionReport').val("Contas vencidas");
    });

    // Forma de Pagamento
    $('#formFiltersAccountsReceivable #filterAccountPayment').change(function () {
        dataTable.draw();
        var option = $('#filterAccountPayment').find(":selected").text();
        $('#formFiltersAccountsReceivable #descriptionReport').val("Forma de Pagamento: " + option);
    });

    // Status
    $('#formFiltersAccountsReceivable #statusFilter').change(function () {
        dataTable.draw();
        var option = $('#formFiltersAccountsReceivable #statusFilter').find(":selected").text();
        $('#formFiltersAccountsReceivable #descriptionReport').val("Status: " + option);
    });

    // Categoria
    $('#formFiltersAccountsReceivable #filterCategory').change(function () {
        dataTable.draw();
        var option = $('#filterCategory').find(":selected").text();
        $('#formFiltersAccountsReceivable #descriptionReport').val("Categoria: " + option);
    });

});

// Editar/Visualizar Parcela
function viewAccountsReceivable(idAccountReceivable) {
    $.ajax({
        url: "/financeiro/contas-a-receber/listar",
        type: 'GET',
        data: {
            idAccountReceivable: idAccountReceivable
        },
        success: function (data) {
            if (JSON.parse(data).length) {
                var dadosJson = JSON.parse(data)[0];

                /* Editar */

                /* Visualizar */
                $('#modalViewAccountReceivable #idView').text(dadosJson.crp_numero);
                $('#modalViewAccountReceivable #idBudgetView').text(dadosJson.orca_numero);
                $('#modalViewAccountReceivable #installmentView').text(dadosJson.crp_parcela);

                // Data pagamento
                if (dadosJson.crp_datapagto != null) {
                    $('#modalViewAccountReceivable #dtPayDayView').show();
                    $('#modalViewAccountReceivable #payDayView').show();
                    $('#modalViewAccountReceivable #payDayView').text(dadosJson.crp_datapagto);
                    // pago tantos dias adiantado ou atrasado

                } else {
                    $('#modalViewAccountReceivable #dtPayDayView').hide();
                    $('#modalViewAccountReceivable #payDayView').hide();
                }

                // Pessoa 
                dadosJson.pess_razao_social != "" ? $('#modalViewAccountReceivable #peopleView').text(dadosJson.pess_razao_social) : $('#modalViewAccountReceivable #peopleView').text(dadosJson.pess_nome + " " + dadosJson.pess_sobrenome);

                $('#modalViewAccountReceivable #paymentMethodView').text(dadosJson.tpg_descricao);
                $('#modalViewAccountReceivable #valueInstallmentView').text(dadosJson.crp_valor);
                $('#modalViewAccountReceivable #dateIssueView').text(dadosJson.crp_emissao);

                // Data de vencimento, verifico se nao esta pago ai mostro quantos dias faltam ou se ja venceu 
                if (dadosJson.crp_status != "PAGO") { //!=
                    var dateNow = moment(new Date(), 'DD/MM/YYYY');
                    var dateExpiry = moment(dadosJson.crp_vencimento, 'DD/MM/YYYY');
                    var diffDateNowDateExpery = dateExpiry.diff(dateNow, 'days');

                    if (dateExpiry > dateNow) {
                        console.log('vencimento > hoje');
                        $('#modalViewAccountReceivable #dateExpiryView').text(dadosJson.crp_vencimento + " (" + Math.abs(diffDateNowDateExpery) + " dia(s) restante(s))");
                    } else {
                        console.log('vencimento < hoje');
                        $('#modalViewAccountReceivable #dateExpiryView').text(dadosJson.crp_vencimento + " (" + Math.abs(diffDateNowDateExpery) + " dia(s) atrasado(s))");
                    }

                    $('#modalViewAccountReceivable #dateExpiryView').css('color', '#ffffff ');
                    //Se faltar 10 ou menos dias pinta de amarelo
                    if (diffDateNowDateExpery <= 0) {
                        $('#modalViewAccountReceivable #dateExpiryView').css('background-color', '#b11800', 'color', '#ffffff');// vermelho
                        //$('#modalViewAccountReceivable #dateExpiryView').css('color', '#ffffff ');
                    } else if (diffDateNowDateExpery >= 1 && diffDateNowDateExpery <= 7) { // se faltar 1 ou 0 dias pinta de vermelho 
                        $('#modalViewAccountReceivable #dateExpiryView').css('background-color', '#ffc107', 'color', '#ffffff '); //amarelo
                    } else { // se nao, ta sobrando dia, ai pinta de verde
                        $('#modalViewAccountReceivable #dateExpiryView').css('background-color', '#28a745', 'color', '#ffffff');
                    }
                } else {// se nao so escreve a data 
                    $('#modalViewAccountReceivable #dateExpiryView').css('background-color', '#fff');
                    $('#modalViewAccountReceivable #dateExpiryView').css('color', '#000000');
                    $('#modalViewAccountReceivable #dateExpiryView').text(dadosJson.crp_vencimento);
                }

                // Status
                $('#modalViewAccountReceivable #statusView').html("");
                $('#modalViewAccountReceivable #statusView').html(dadosJson.crp_statusBadge);

                // Categoria
                $('#modalViewAccountReceivable #categoryView').html(dadosJson.cat_descricao);

                // Observação
                if (dadosJson.crp_obs != "") {
                    $('#modalViewAccountReceivable #observationView').text(dadosJson.observation);
                } else {
                    $("#modalViewAccountReceivable #divObservationView").hide();
                    $("#modalViewAccountReceivable #dtObservationView").hide();
                }

                $('#modalViewAccountReceivable').modal('show');
            }
        },
        error: {}
    });
}