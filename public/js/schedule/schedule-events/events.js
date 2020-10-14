$(document).ready(function () {
    var dataTable = $("#listEvents").DataTable({
        "deferRender": true, //Os elementos serão criados somente quando necessários
        "processing": true,
        "serverSide": true, //importante

        "ajax": {
            "url": "/agenda/eventos/listar",
            "type": "POST",
            "data": function (data) {
                //Filtros
                // Valor dos campos
                var startDate = $('#formFiltersEvent #startDate').val();
                var endDate = $('#formFiltersEvent #endDate').val();
                var status = $('#formFiltersEvent #status').val();
                var event = $('#formFiltersEvent #event').val();
                var period = $('#formFiltersEvent #period').val();

                // Anexar aos dados
                data.startDate = startDate;
                data.endDate = endDate;
                data.status = status;
                data.event = event;
                data.period = period;
            }

        },
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json"
        },

                /*  PINTAR CELULA
                rowCallback: function(row, data) {
            if (data[3] == "Ativo") {
              $('td:eq(3)', row).css('background-color','#99ff9c');
              //$(row).css('background-color','#99ff9c'); pintar a linha
            }
          }, */ 

        "autoWidth": false, //Largura automática
        //Largura e tirar ordenaçao das colunas
        "columnDefs": [
            { "targets": 2, "width": "10%" },
            { "targets": 3, "width": "10%" },
            { "targets": 4, "width": "10%" },
            { "targets": 5, "width": "10%" },
            { "targets": 6, "width": "10%", "orderable": false, "searchable": false },
        ],

        "responsive": true,

        "lengthChange": true, //Usuario aumentar ou diminuir largura da coluna
        "keys": true, //usar teclas para navegar bna tabela e atalhos

        "fixedHeader": true,
        "colReorder": true, //arrastar colunas,
        "paging": false, //Paginaçao
        "order": [2, 'desc'], //ordenar coluna
        "paging": true, //mostra "10 resultados por página", mas esta oculto no css se nao quebra o design

        "dom": 'B <"clear"> lfrtip',
        //"dom": 'Bfrtip',
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
                        {
                            extend: 'pageLength',
                            text: 'Resultados por página',
                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Relatório de Eventos',
                            key: {
                                key: 'p',
                                altKey: true
                            },
                            text: '<u>P</u>DF &nbsp; <i class="far fa-file-pdf"></i>',
                            orientation: 'portrait', //portrait RETRADO //landscape
                            pageSize: 'A4',
                            download: 'open', //abrir pdf em uma nova aba, so que o nome do arquivo é modificado
                            //filename: 'Oi', //nome do arquivo 
                            //footer: true, //incluir roda pe
                            header: true, //incluir topo da tabela
                            //messageBottom: "BLA BLA BLA", //Mensagem abaixo da tabela
                            //messageTop: "BLA BLA BLA", //Mensagem acima da tabela, so funciona sem o w
                            //message: "BLA BLA BLA",
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5], //MUDAR 
                                //modifier: {page: 'current'} //salvar apenas os dados mostrados na página atual
                                //search: "applied",
                                order: "applied"
                            },
                            customize: function (doc) {
                                doc.content[1].table.widths = [ //MUDAR
                                    '18%',
                                    '30%',
                                    '13%',
                                    '13%',
                                    '13%',
                                    '13%',
                                ];

                                //doc.defaultStyle.font = 'Arial';

                                // 38 é o roda pe 
                                doc.pageMargins = [20, 65, 20, 35]; //margins do documento //esqueda, cima, direita, baixo
                                doc.defaultStyle.fontSize = 10;
                                doc.styles.tableHeader.fontSize = 12;
                                doc.styles.tableHeader.fillColor = '#ea0029';
                                /*doc.watermark = {
                                    text: 'test watermark', 
                                    color: 'blue', 
                                    opacity: 0.3, 
                                    bold: true, 
                                    italics: false 
                                };*/

                                //tira titulo datablade
                                doc.content.splice(0, 1);
                                //doc.content[1].table.color = "#0984e3";

                                doc.defaultStyle.alignment = 'center';
                                //doc.tableBodyEven.background = '#add8e6';

                                //Pegando o campo que contem a descrição do relatorio
                                var inputDescriptionReport = document.getElementById('descriptionReport');
                                //Guardando em uma Var
                                var descriptionReport = inputDescriptionReport.value;

                                doc['header'] = (function () {
                                    return {
                                        columns: [
                                            {
                                                image: logoPDF,
                                                width: 130
                                            },
                                           /*  {
                                                alignment: 'center',
                                                italics: true,
                                                text: 'TESTE',
                                                fontSize: 13,
                                                margin: [10, 0]
                                            }, */
                                            {
                                                alignment: 'right',
                                                fontSize: 13,
                                                text: descriptionReport
                                            },
                                        ],
                                        margin: 20
                                    }
                                });

                                //Pegando a data
                                var now = new Date();
                                var jsDate = now.getDate() + '/' + (now.getMonth() + 1) + '/' + now.getFullYear();

                                //Colocanda a data no rodapé
                                doc['footer'] = (function (page, pages) {
                                    return {
                                        columns: [
                                            {
                                                alignment: 'left',
                                                text: ['Criado em: ', { text: jsDate.toString() }]
                                            },
                                            {
                                                alignment: 'center',
                                                text: 'Ouse - Inteligência em Marcas'
                                            },
                                            {
                                                alignment: 'right',
                                                text: ['Página: ', { text: page.toString() }, ' de: ', { text: pages.toString() }]
                                            }
                                        ],
                                        margin: [20, 10, 20, 10]
                                    }
                                });

                                /*doc.content.splice(1, 0, { //img 
                                    margin: [0, 0, 0, 12],
                                    alignment: 'center',
                                    width: 24,
                                    image: logo
                                });


                            /*var cols = [];
                            cols[0] = {text: 'Left part', alignment: 'left', margin:[20] };
                            cols[1] = {text: 'Right part', alignment: 'right', margin:[0,0,20] };
                            var objFooter = {};
                            objFooter['columns'] = cols;
                            doc['footer']=objFooter;
                            doc.content.splice(1, 0,
                                {
                                    margin: [0, 0, 0, 12],
                                    alignment: 'center',
                                    image: 'data:image/png;base64,...',
                                }
                            );*/
                            }
                        },
                        {
                            extend: 'excel',
                            text: '<u>E</u>xcel &nbsp; <i class="far fa-file-excel"></i>',
                            key: {
                                key: 'e', //ctrl + shift + e
                                altKey: true
                            }
                        },
                        {
                            collectionTitle: 'Visibilidade da coluna',
                            text: 'Visibilidade da coluna',
                            extend: 'colvis',
                            collectionLayout: 'two-column'
                        },

                        /*{ Ao clicar ele oculta somente uma coluna
                            text: 'Toggle salary',
                            action: function (e, dt, node, config) {
                                dt.column(-1).visible(!dt.column(-1).visible());
                            }
                        }*/
                    ]
            }
        ]
    });

    //A cada click é uma requição Ajax
    $('#formFiltersEvent #startDate').change(function () {
        dataTable.draw();
    });
    $('#formFiltersEvent #endDate').change(function () {
        dataTable.draw();
    });

    $('#formFiltersEvent #status').change(function () {
        dataTable.draw();
    });

    $('#formFiltersEvent #event').change(function () {
        dataTable.draw();
    });
    $('#formFiltersEvent #period').change(function () {
        dataTable.draw();
    });

});

/* Visualizar Evnto */
$(document).on('click', '.btn-view-event', function () {
    $.ajax({
        url: "/agenda/calendario/listar",
        type: 'GET',
        data: {
            id: $(this).attr("id")
        },
        success: function (data) {
            if (JSON.parse(data).length) { //se exitir o dado > 0 
                var dadosJson = JSON.parse(data)[0];

                $('#modalViewEvent #title').text(dadosJson.title);
                $('#modalViewEvent #start').text(dadosJson.dateStart + " " + dadosJson.hourStart + "h");
                $('#modalViewEvent #end').text(dadosJson.dateStart + " " + dadosJson.hourEnd + "h");

                document.getElementById('P').remove();
                document.getElementById('R').remove();

                //Status
                if (dadosJson.status == "P") {
                    $('#modalViewEvent #status').append(`<span id="P" class="badge badge-warning">Pendente</span> <span id="R" class="badge badge-success" style="display:none">Realizado</span>`);
                } else {
                    $('#modalViewEvent #status').append(`<span id="R" class="badge badge-success">Realizado</span> <span id="P" class="badge badge-warning" style="display:none">Pendente</span>`);
                }

                $('#modalViewEvent #name').text(dadosJson.name + " " + dadosJson.surname);

                //Celular
                if (dadosJson.cellphone != "") {
                    $('#modalViewEvent #cellphone').text(dadosJson.cellphoneFormatted);
                    $('#modalViewEvent #cellphone').attr('href', `tel: +55${dadosJson.cellphone}`);
                } else {
                    $("#modalViewEvent #dtCellphone").hide();
                    $("#modalViewEvent #ddCellphone").hide();
                }

                //Telefone
                if (dadosJson.telephone != "") {
                    $('#modalViewEvent #telephone').text(dadosJson.telephoneFormatted);
                    $('#modalViewEvent #telephone').attr('href', `tel: +55${dadosJson.telephone}`);
                } else {
                    $("#modalViewEvent #dtTelephone").hide();
                    $("#modalViewEvent #ddTelephone").hide();
                }

                //Email
                if (dadosJson.email != "") {
                    $('#modalViewEvent #email').text(dadosJson.email);
                    $('#modalViewEvent #email').attr('href', `malito:${dadosJson.email}`);
                } else {
                    $("#modalViewEvent #dtEmail").hide();
                    $("#modalViewEvent #ddEmail").hide();
                }

                //Endereço 
                var adressJoin = dadosJson.logradouro + ", " + dadosJson.number + " - " + dadosJson.bairro + " " + dadosJson.localidade + " - " + dadosJson.uf + " " + dadosJson.cep;
                var adressLink = dadosJson.logradouro + "+" + dadosJson.number + "+" + dadosJson.bairro + "+" + dadosJson.localidade + "+" + dadosJson.uf + "+" + dadosJson.cep;
                $('#modalViewEvent #address').text(adressJoin);
                $('#modalViewEvent #address').attr('href', `https://www.google.com/maps/search/?api=1&query=${adressLink}`);

                //Edificio, bloco e Apartamento
                if (dadosJson.edifice && dadosJson.block && dadosJson.apartment != "") {
                    $('#modalViewEvent #edifice').text(dadosJson.edifice);
                    $('#modalViewEvent #block').text(dadosJson.block);
                    $('#modalViewEvent #apartment').text(dadosJson.apartment);
                } else {
                    $("#modalViewEvent #dtEdifice").hide();
                    $("#modalViewEvent #edifice").hide();
                    $("#modalViewEvent #dtBlock").hide();
                    $("#modalViewEvent #block").hide();
                    $("#modalViewEvent #dtApartment").hide();
                    $("#modalViewEvent #apartment").hide();
                } /* OU if (dadosJson.edifice != "") {$('#modalViewEvent #edifice').append(`<dt class="col-sm-3">Edificio:</dt>`);$('#modalViewEvent #edifice').append(`<dd class="col-sm-8">${dadosJson.edifice}</dd>`);} */

                //Rua do Condominio
                if (dadosJson.streetCondominium != "") {
                    $('#modalViewEvent #streetCondominium').text(dadosJson.streetCondominium);
                } else {
                    $("#modalViewEvent #dtStreetCondominium").hide();
                    $("#modalViewEvent #streetCondominium").hide();
                }

                //Observação
                if (dadosJson.observation != "") {
                    $('#modalViewEvent #observation').text(dadosJson.observation);
                } else {
                    $("#modalViewEvent #divObservation").hide();
                    $("#modalViewEvent #dtObservation").hide();
                }

                //Momento do dia (bom dia, boa tarde...)
                varDate = new Date();
                hour = varDate.getHours();
                if (hour < 5) {
                    var momentDay = "Boa noite, ";
                }
                else
                    if (hour < 8) {
                        var momentDay = "Bom dia, ";
                    }
                    else
                        if (hour < 12) {
                            var momentDay = "Bom dia, ";
                        }
                        else
                            if (hour < 18) {
                                var momentDay = "Boa tarde, ";
                            }
                            else {
                                var momentDay = "Boa noite, ";
                            }

                //Mensagem WhatsApp                        
                if (dadosJson.edifice && dadosJson.block && dadosJson.apartment != "") {
                    var msgWhatsapp = momentDay + dadosJson.name + " " + dadosJson.surname + "! %0AVocê agendou uma visita para o *Dia:* " + dadosJson.dateStart + " das " + dadosJson.hourStart + " às " + dadosJson.hourEnd +
                        " no *Endereço:* " + adressJoin + " *Edifício:* " + dadosJson.edifice + " *Bloco:* " + dadosJson.block + " *Apartamento:* " + dadosJson.apartment + " . Até mais, Gesso Cidade Nova.";
                } else {
                    var msgWhatsapp = momentDay + dadosJson.name + " " + dadosJson.surname + "! %0AVocê agendou uma visita para o *Dia:* " + dadosJson.dateStart + " das " + dadosJson.hourStart + " às " + dadosJson.hourEnd +
                        " no *Endereço:* " + adressJoin + ". Até mais, Gesso Cidade Nova.";
                }

                $("#btnWpp").attr("href", "https://api.whatsapp.com/send?phone=+55" + dadosJson.cellphone + "&text=" + msgWhatsapp);

                $('#modalViewEvent').modal('show');
            }
        }
    });
});


