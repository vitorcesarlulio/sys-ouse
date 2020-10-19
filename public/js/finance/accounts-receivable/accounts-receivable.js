function showDivPayday() {
    if ($('#settledRegister').is(":checked"))
        $("#divPaydayRegister").show();
    else
        $("#divPaydayRegister").hide();
}

function showSettledRegister() {
    if ($("#installmentRegister").val() === "1") {
        $("#divSettledRegister").show();
    }else{
        $("#divSettledRegister").hide();
    }
}

$(document).ready(function() {
    $("#amountRegister").inputmask('decimal', {
        radixPoint: ",",
        groupSeparator: ".",
        autoGroup: true,
        digits: 2,
        digitsOptional: false,
        placeholder: '0',
        rightAlign: false,
        onBeforeMask: function (value, opts){
            return value;
        }
    });
}); 

window.onload = function () {
    var select = document.getElementById("statusRegister").addEventListener('change', function () {
        if (this.value === "Outro") {
            $("#divOtherStatus").show();
        } else {
            $("#divOtherStatus").hide();
        }
    });
}

$(document).ready(function () {
    var dataTable = $("#listAccountsReceivable").DataTable({
        "deferRender": true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/financeiro/contas-a-receber/listar",
            "type": "POST",
            "data": function (data) {
            }
        },
        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json" },
        "autoWidth": false,
        "columnDefs": [
            { "targets": 4, "width": "10%", "orderable": false, "searchable": false },
            { "targets": 0, "width": "15%" },
        ],
        "responsive": true,
        "lengthChange": true,
        "keys": true,
        "fixedHeader": true,
        "colReorder": true,
        "order": [0, 'desc'], //ordenar coluna
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
                            orientation: 'portrait',
                            pageSize: 'A4',
                            download: 'open',
                            header: true,
                            exportOptions: {
                                columns: [0, 1, 2, 3],
                                order: "applied"
                            },
                            customize: function (doc) {
                                doc.content[1].table.widths = [
                                    '10%',
                                    '28%',
                                    '12%',
                                    '50%'
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
                            exportOptions: { columns: [0, 1, 2, 3, 4], },
                        },
                        {
                            collectionTitle: 'Visibilidade da coluna', text: 'Visibilidade da coluna', extend: 'colvis', collectionLayout: 'two-column'
                        }
                    ]
            }
        ]
    });
});