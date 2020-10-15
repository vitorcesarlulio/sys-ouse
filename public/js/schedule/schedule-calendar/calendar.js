$(function () {

    /* Inicializar os eventos externos*/
    function ini_events(ele) {
        ele.each(function () {
            //Crie um objeto de evento (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            //Não precisa ter começo nem fim
            var eventObject = {
                title: $.trim($(this).text()) //Use o texto do elemento como o título do evento
            }
            //Armazene o objeto de evento no elemento DOM para que possamos acessá-lo mais tarde
            $(this).data('eventObject', eventObject)
        })
    }

    ini_events($('#external-events div.external-event'))

    /* Inicialize o calendário */
    //Data dos eventos do calendário (dados simulados)
    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    var containerEl = document.getElementById('external-events');
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br',
        plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
        header: {
            left: 'prev,next', //, today botao para quando clicar ir ate o dia
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay, listDay, listWeek'
        },

        views: {
            dayGridMonth: { buttonText: 'M' },
            timeGridWeek: { buttonText: 'S' },
            timeGridDay: { buttonText: 'D' },
            listDay: { buttonText: 'Lista Dia' },
            listWeek: { buttonText: 'Lista Semana' }
        },

        navLinks: true,
        defaultView: 'dayGridMonth', //quando abrir calendario abrir no dia
        allDaySlot: false, //evento dia todo, tanto na hora de trazer o horario quanto na hr de visualizar no dia 

        eventLimit: true, //Somente 3 eventos por dia serão visualizados
        'themeSystem': 'bootstrap',

        businessHours: {
            //Dias da semana. uma matriz de números inteiros do dia da semana com base em zero (0 = domingo)
            daysOfWeek: [1, 2, 3, 4, 5], //Segunda, Terça...

            startTime: '08:00', //se colocar 08 mas nao colocar mintime ele vai mostrar o horario 07h mas nao vai deixar clicar
            endTime: '17:00',
        },

        //selectConstraint: "businessHours", //se ativado n da pra clicar no dia pelo calendario 

        minTime: "08:00:00", //ocultar do calendario as horas que n devem ser preenchidas
        maxTime: "17:00:00", //nao deixa clicar nas horas n permitidas

        eventSources: [{
            url: '/agenda/calendario/listar', //Rota para listar os eventos 
            type: 'POST',
            backgroundColor: '#FFC107', //Cor padrão ao cadastrar um evento
            borderColor: '#FFC107', //Cor padrão ao cadastrar um evento
        }],

        /* EventClick - ao clicar no evento abre um modal para exibir as informações do evento */
        eventClick: function (info) {

            /* Modal confirma excluir evento */
            $(document).on('click', '#deleteEvent', function () {
                $('#modalViewEvent').modal('hide');
                if (info.event.title === "Realizar Orçamento") {
                    $.confirm({
                        title: 'Atenção!',
                        content: 'Realmente deseja excluir esse evento e o orçamento veiculado a ele?',
                        type: 'red',
                        buttons: {
                            omg: {
                                text: 'Sim',
                                btnClass: 'btn-red',
                                action: function () {
                                    $.ajax({
                                        url: "/agenda/calendario/apagar",
                                        method: "POST",
                                        data: { idEventBudget: info.event.id },
                                        success: function (retorna) { retorna['sit'] ? location.reload() : $("#msg-cad").html(retorna['msg']); },
                                        error: function () { toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!'); }
                                    });
                                }
                            },
                            close: {
                                text: 'Não',
                                action: function () {
                                    $.confirm({
                                        title: 'Atenção!',
                                        content: 'Realmente deseja excluir somente o evento?',
                                        type: 'red',
                                        buttons: {
                                            omg: {
                                                text: 'Sim',
                                                btnClass: 'btn-red',
                                                action: function () {
                                                    $.ajax({
                                                        url: "/agenda/calendario/apagar",
                                                        method: "POST",
                                                        data: { idEvent: info.event.id },
                                                        success: function (retorna) { retorna['sit'] ? location.reload() : $("#msg-cad").html(retorna['msg']); },
                                                        error: function () { toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!'); }
                                                    });
                                                }
                                            },
                                            close: {
                                                text: 'Não',
                                            }
                                        }
                                    });
                                }
                            }
                        }
                    });
                } else {
                    $.confirm({
                        title: 'Atenção!',
                        content: 'Realmente deseja excluir esse evento?',
                        type: 'red',
                        buttons: {
                            omg: {
                                text: 'Sim',
                                btnClass: 'btn-red',
                                action: function () {
                                    $.ajax({
                                        url: "/agenda/calendario/apagar",
                                        method: "POST",
                                        data: { idEvent: info.event.id },
                                        success: function (retorna) { retorna['sit'] ? location.reload() : $("#msg-cad").html(retorna['msg']); },
                                        error: function () { toastr.error('Erro: dados não enviados ao servidor, contate o administrador do sistema!'); }
                                    });
                                }
                            },
                            close: {
                                text: 'Não',
                            }
                        }
                    });
                }
            });


            info.jsEvent.preventDefault();

            //Visualizar
            $('#modalViewEvent #title').text(info.event.title);
            $('#modalViewEvent #start').text(info.event.extendedProps.dateStart + " " + info.event.extendedProps.hourStart + "h");
            $('#modalViewEvent #end').text(info.event.extendedProps.dateStart + " " + info.event.extendedProps.hourEnd + "h");

            document.getElementById('P').remove();
            document.getElementById('R').remove();

            if (info.event.extendedProps.status == "P") {
                $('#modalViewEvent #status').append(`<span id="P" class="badge badge-warning">Pendente</span> <span id="R" class="badge badge-success" style="display:none">Realizado</span>`);
            } else {
                $('#modalViewEvent #status').append(`<span id="R" class="badge badge-success">Realizado</span> <span id="P" class="badge badge-warning" style="display:none">Pendente</span>`);
            }

            $('#modalViewEvent #name').text(info.event.extendedProps.name + " " + info.event.extendedProps.surname);

            //Celular
            if (info.event.extendedProps.cellphone != "") {
                $('#modalViewEvent #cellphone').text(info.event.extendedProps.cellphoneFormatted);
                $('#modalViewEvent #cellphone').attr('href', `tel: +55${info.event.extendedProps.cellphone}`);
            } else {
                $("#modalViewEvent #dtCellphone").hide();
                $("#modalViewEvent #ddCellphone").hide();
            }

            //Telefone
            if (info.event.extendedProps.telephone != "") {
                $('#modalViewEvent #telephone').text(info.event.extendedProps.telephoneFormatted);
                $('#modalViewEvent #telephone').attr('href', `tel: +55${info.event.extendedProps.telephone}`);
            } else {
                $("#modalViewEvent #dtTelephone").hide();
                $("#modalViewEvent #ddTelephone").hide();
            }

            //Email
            if (info.event.extendedProps.email != "") {
                $('#modalViewEvent #email').text(info.event.extendedProps.email);
                $('#modalViewEvent #email').attr('href', `malito:${info.event.extendedProps.email}`);
            } else {
                $("#modalViewEvent #dtEmail").hide();
                $("#modalViewEvent #ddEmail").hide();
            }

            //Endereço 
            var adressJoin = info.event.extendedProps.logradouro + ", " + info.event.extendedProps.number + " - " + info.event.extendedProps.bairro + " " + info.event.extendedProps.localidade + " - " + info.event.extendedProps.uf + " " + info.event.extendedProps.cep;
            var adressLink = info.event.extendedProps.logradouro + "+" + info.event.extendedProps.number + "+" + info.event.extendedProps.bairro + "+" + info.event.extendedProps.localidade + "+" + info.event.extendedProps.uf + "+" + info.event.extendedProps.cep;
            $('#modalViewEvent #address').text(adressJoin);
            $('#modalViewEvent #address').attr('href', `https://www.google.com/maps/search/?api=1&query=${adressLink}`);

            //Edificio, bloco e Apartamento
            if (info.event.extendedProps.edifice && info.event.extendedProps.block && info.event.extendedProps.apartment != "") {
                $('#modalViewEvent #edifice').text(info.event.extendedProps.edifice);
                $('#modalViewEvent #block').text(info.event.extendedProps.block);
                $('#modalViewEvent #apartment').text(info.event.extendedProps.apartment);
            } else {
                $("#modalViewEvent #dtEdifice").hide();
                $("#modalViewEvent #edifice").hide();
                $("#modalViewEvent #dtBlock").hide();
                $("#modalViewEvent #block").hide();
                $("#modalViewEvent #dtApartment").hide();
                $("#modalViewEvent #apartment").hide();
            } /* OU if (info.event.extendedProps.edifice != "") {$('#modalViewEvent #edifice').append(`<dt class="col-sm-3">Edificio:</dt>`);$('#modalViewEvent #edifice').append(`<dd class="col-sm-8">${info.event.extendedProps.edifice}</dd>`);} */

            //Rua do Condominio
            if (info.event.extendedProps.streetCondominium != "") {
                $('#modalViewEvent #streetCondominium').text(info.event.extendedProps.streetCondominium);

                $("#modalViewEvent #optionCondominiumEdit").prop("checked", true);
                $('#modalViewEvent #divNumberEdit').show();
                $('#modalViewEvent #divStreetCondominiumEdit').show();
                $('#modalViewEvent #numberEdit').val(info.event.extendedProps.number);
                $('#modalViewEvent #streetCondominiumEdit').val(info.event.extendedProps.streetCondominium);
            } else {
                $("#modalViewEvent #dtStreetCondominium").hide();
                $("#modalViewEvent #streetCondominium").hide();

                $('#modalViewEvent #divStreetCondominiumEdit').hide();
                $('#modalViewEvent #divNumberEdit').hide();
            }


            //Observação
            if (info.event.extendedProps.observation != "") {
                $('#modalViewEvent #observation').text(info.event.extendedProps.observation);
            } else {
                $("#modalViewEvent #divObservation").hide();
                $("#modalViewEvent #dtObservation").hide();
            }

            //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------//

            //Editar
            $('#modalViewEvent #idEvent').val(info.event.id);
            $('#modalViewEvent #idBudget').val(info.event.extendedProps.idBudget);
            if (info.event.title === "Realizar Orçamento") {
                //$('#modalViewEvent #divClientEdit').val(info.event.extendedProps.name + " " + info.event.extendedProps.surname);
                $('#modalViewEvent #optionVoltarObra').hide();
                $('#modalViewEvent #optionInicioObra').hide();
            } else if (info.event.title === "Voltar na Obra") {
                $('#modalViewEvent #optionRealizarOrcamento').hide();
                $('#modalViewEvent #optionInicioObra').hide();
            } else {
                $('#modalViewEvent #optionRealizarOrcamento').hide();
                $('#modalViewEvent #optionVoltarObra').hide();
            }

            $('#modalViewEvent #selectionTitleEdit').val(info.event.title);
            $('#modalViewEvent #startDateEdit').val(info.event.start.toLocaleString());
            $('#modalViewEvent #startTimeEdit').val(info.event.extendedProps.hourStart);
            $('#modalViewEvent #endTimeEdit').val(info.event.extendedProps.hourEnd);

            $('#modalViewEvent #nameEdit').val(info.event.extendedProps.name);
            $('#modalViewEvent #surnameEdit').val(info.event.extendedProps.surname);
            $('#modalViewEvent #cellphoneEdit').val(info.event.extendedProps.cellphone);
            $('#modalViewEvent #telephoneEdit').val(info.event.extendedProps.telephone);
            $('#modalViewEvent #emailEdit').val(info.event.extendedProps.email);

            $('#modalViewEvent #cepEdit').val(info.event.extendedProps.cep);
            $('#modalViewEvent #logradouroEdit').val(info.event.extendedProps.logradouro);
            $('#modalViewEvent #bairroEdit').val(info.event.extendedProps.bairro);
            $('#modalViewEvent #localidadeEdit').val(info.event.extendedProps.localidade);
            $('#modalViewEvent #ufEdit').val(info.event.extendedProps.uf);

            //Numero
            if (info.event.extendedProps.number != "") {
                $("#modalViewEvent #optionHomeEdit").prop("checked", true);
                $('#modalViewEvent #divNumberEdit').show();
                $('#modalViewEvent #numberEdit').val(info.event.extendedProps.number);
            } else { $('#modalViewEvent #divNumberEdit').hide(); }

            //Edificio
            if (info.event.extendedProps.edifice && info.event.extendedProps.block && info.event.extendedProps.apartment != "") {
                $("#modalViewEvent #optionBuildingEdit").prop("checked", true);
                $('#modalViewEvent #divEdificeEdit').show();
                $('#modalViewEvent #divBlockEdit').show();
                $('#modalViewEvent #divApartmentEdit').show();
                $('#modalViewEvent #edificeEdit').val(info.event.extendedProps.edifice);
                $('#modalViewEvent #blockEdit').val(info.event.extendedProps.block);
                $('#modalViewEvent #apartmentEdit').val(info.event.extendedProps.apartment);
            } else {
                $('#modalViewEvent #divEdificeEdit').hide();
                $('#modalViewEvent #divBlockEdit').hide();
                $('#modalViewEvent #divApartmentEdit').hide();
            }



            $('#modalViewEvent #observationEdit').val(info.event.extendedProps.observation);

            //Momento do dia (bom dia, boa tarde...)
            varDate = new Date();
            hour = varDate.getHours();
            if (hour < 5) { var momentDay = "Boa noite, "; }
            else
                if (hour < 8) { var momentDay = "Bom dia, "; }
                else
                    if (hour < 12) { var momentDay = "Bom dia, "; }
                    else
                        if (hour < 18) { var momentDay = "Boa tarde, "; }
                        else { var momentDay = "Boa noite, "; }

            //Mensagem WhatsApp                        
            if (info.event.extendedProps.edifice && info.event.extendedProps.block && info.event.extendedProps.apartment != "") {
                var msgWhatsapp = momentDay + info.event.extendedProps.name + " " + info.event.extendedProps.surname + "! %0AVocê agendou uma visita para o *Dia:* " + info.event.extendedProps.dateStart + " das " + info.event.extendedProps.hourStart + " às " + info.event.extendedProps.hourEnd +
                    " no *Endereço:* " + adressJoin + " *Edifício:* " + info.event.extendedProps.edifice + " *Bloco:* " + info.event.extendedProps.block + " *Apartamento:* " + info.event.extendedProps.apartment + " . Até mais, Gesso Cidade Nova.";
            } else {
                var msgWhatsapp = momentDay + info.event.extendedProps.name + " " + info.event.extendedProps.surname + "! %0AVocê agendou uma visita para o *Dia:* " + info.event.extendedProps.dateStart + " das " + info.event.extendedProps.hourStart + " às " + info.event.extendedProps.hourEnd +
                    " no *Endereço:* " + adressJoin + ". Até mais, Gesso Cidade Nova.";
            }
            $("#btnWpp").attr("href", "https://api.whatsapp.com/send?phone=+55" + info.event.extendedProps.cellphone + "&text=" + msgWhatsapp);


            $('#modalViewEvent').modal('show');
        },

        selectable: true, //dia é clicavel

        //Traz os dados do dia selecionado (data e hora do dia)
        select: function (info) {
            $('#modalRegisterEvent #startDateRegister').val(info.start.toLocaleString());
            $('#modalRegisterEvent').modal('show');
        },

        editable: true,

        extraParams: function () {
            return {
                cachebuster: new Date().valueOf()
            };
        }
    });

    calendar.render();
});

/* Ações do botão Editar e Canclar */
$(document).ready(function () {
    //Botão Cancelar
    $('.btn-edit-event').on("click", function () {
        $('.divViewEvent').slideToggle();
        $('.formedit').slideToggle();
    });

    //Botão Editar
    $('.btn-cancel-edit').on("click", function () {
        $('.formedit').slideToggle();
        $('.divViewEvent').slideToggle();
    });
});

/* Função para mostrar ou ocultar campos de acordo com seleção (Marcar horário?) */
function optionsScheduleTime() {
    var optionScheduleTimeYes = document.getElementById("optionScheduleTimeYes").checked;
    if (optionScheduleTimeYes) {
        $("#divTitleRegister").show();
        $("#divStartDateRegister").show();
        $("#divStartTimeRegister").show();
        $("#divEndTimeRegister").show();
    } else {
        $("#divTitleRegister").hide();
        $("#divStartDateRegister").hide();
        $("#divStartTimeRegister").hide();
        $("#divEndTimeRegister").hide();
    }
}

/* Função para mostrar ou ocultar campos de acordo com seleção (Qual evento?) */
window.onload = function () {
    var select = document.getElementById("selectionTitleRegister").addEventListener('change', function () {
        if (this.value == 'Voltar na Obra' || this.value == 'Início de Obra') {
            $("#divClientRegister").show();//Mostra a seleção do cliente
            $("#divNameRegister").hide();
            $("#divSurnameRegister").hide();
            $("#divCellphoneRegister").hide();
            $("#divTelephoneRegister").hide();
            $("#divEmaileRegister").hide();
            $("#divCepRegister").hide();
            $("#divStreetRegister").hide();
            $("#divNeighBorhoodRegister").hide();
            $("#divCityRegister").hide();
            $("#divStateRegister").hide();
            $("#divTypeResidenceRegister").hide();
            $("#divEdificeRegister").hide();
            $("#divBlockRegister").hide();
            $("#divApartmentRegister").hide();
            $("#divStreetCondominiumRegister").hide();
            $("#divNumberRegister").hide();
            $("#divScheduleTimeNo").hide();//quando clicar em realizar orçamento ele oculta "Não" na opção "Marcar Horario?"
        } else {
            $("#divClientRegister").hide(); //esconde a seleção do cliente
            $("#divNameRegister").show();
            $("#divSurnameRegister").show();
            $("#divCellphoneRegister").show();
            $("#divTelephoneRegister").show();
            $("#divEmaileRegister").show();
            $("#divCepRegister").show();
            $("#divStreetRegister").show();
            $("#divNeighBorhoodRegister").show();
            $("#divCityRegister").show();
            $("#divStateRegister").show();
            $("#divTypeResidenceRegister").show();
            $("#divScheduleTimeNo").show();//quando clicar em realizar orçamento ele mostra "Não" na opção "Marcar Horario?"
        }
    });
}

/* Função para mostrar ou ocultar campo de acordo com seleção (Tipo de Residência) */
function optionTypeResidenceRegister() {
    var optionHomeRegister = document.getElementById("optionHomeRegister").checked;
    var optionCondominiumRegister = document.getElementById("optionCondominiumRegister").checked;
    if (optionHomeRegister) {
        $('#edificeRegister').val("");
        $('#blockRegister').val("");
        $('#apartmentRegister').val("");
        $('#streetCondominiumRegister').val("");
        $('#numberRegister').val("");

        $("#divEdificeRegister").hide();
        $("#divBlockRegister").hide();
        $("#divApartmentRegister").hide();
        $("#divStreetCondominiumRegister").hide();
        $("#divNumberRegister").show();
    } else if (optionCondominiumRegister) {
        $('#edificeRegister').val("");
        $('#blockRegister').val("");
        $('#apartmentRegister').val("");
        $('#streetCondominiumRegister').val("");
        $('#numberRegister').val("");

        $("#divEdificeRegister").hide();
        $("#divBlockRegister").hide();
        $("#divApartmentRegister").hide();
        $("#divStreetCondominiumRegister").show();
        $("#divNumberRegister").show();
    } else {
        $('#edificeRegister').val("");
        $('#blockRegister').val("");
        $('#apartmentRegister').val("");
        $('#streetCondominiumRegister').val("");
        $('#numberRegister').val("");

        $("#divEdificeRegister").show();
        $("#divBlockRegister").show();
        $("#divApartmentRegister").show();
        $("#divStreetCondominiumRegister").hide();
        $("#divNumberRegister").hide();
    }
}

function clearCep() {
    $('#modalViewEvent #logradouroEdit').val("");
    $('#modalViewEvent #bairroEdit').val("");
    $('#modalViewEvent #localidadeEdit').val("");
    $('#modalViewEvent #ufEdit').val("");
}
function callbackCep(conteudo) {
    if (!("erro" in conteudo)) {
        $('#modalViewEvent #logradouroEdit').val(conteudo.logradouro);
        $('#modalViewEvent #bairroEdit').val(conteudo.bairro);
        $('#modalViewEvent #localidadeEdit').val(conteudo.localidade);
        $('#modalViewEvent #ufEdit').val(conteudo.uf);
    }
    else { clearCep(); alert("CEP não encontrado."); }
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
        else { clearCep(); alert("Formato de CEP inválido."); }
    }
    else { clearCep(); alert("Informe o CEP."); }
};

/* Função para mostrar ou ocultar campo de acordo com seleção (Tipo de Residência) - EDITAR */
function optionTypeResidenceEdit() {
    var optionHomeEdit = document.getElementById("optionHomeEdit").checked;
    var optionCondominiumEdit = document.getElementById("optionCondominiumEdit").checked;
    if (optionHomeEdit) {
        $('#edificeEdit').val("");
        $('#blockEdit').val("");
        $('#apartmentEdit').val("");
        $('#streetCondominiumEdit').val("");
        $('#numberEdit').val("");

        $("#divEdificeEdit").hide();
        $("#divBlockEdit").hide();
        $("#divApartmentEdit").hide();
        $("#divStreetCondominiumEdit").hide();
        $("#divNumberEdit").show();
    } else if (optionCondominiumEdit) {
        $('#edificeEdit').val("");
        $('#blockEdit').val("");
        $('#apartmentEdit').val("");
        $('#streetCondominiumEdit').val("");
        $('#numberEdit').val("");

        $("#divEdificeEdit").hide();
        $("#divBlockEdit").hide();
        $("#divApartmentEdit").hide();
        $("#divStreetCondominiumEdit").show();
        $("#divNumberEdit").show();
    } else {
        $('#edificeEdit').val("");
        $('#blockEdit').val("");
        $('#apartmentEdit').val("");
        $('#streetCondominiumEdit').val("");
        $('#numberEdit').val("");

        $("#divEdificeEdit").show();
        $("#divBlockEdit").show();
        $("#divApartmentEdit").show();
        $("#divStreetCondominiumEdit").hide();
        $("#divNumberEdit").hide();
    }
}

/* Atalhos do Calendario

$(document).keyup(function(e) { //O evento Kyeup é acionado quando as teclas são soltas
    if (e.which == 16) pressedCtrl = false; //Quando qualuer tecla for solta é preciso informar que Crtl não está pressionada
})*/

/* Fechar form Visualizar com Shift+F
$(document).keydown(function(e) { //Quando uma tecla é pressionada
    if (e.which == 67) pressedCtrl = true; //Informando que Crtl está acionado
    if ((e.which == 67 || e.keyCode == 67) && pressedCtrl == true) { //Reconhecendo tecla Enter
        $('#modalRegisterEvent').modal('show');
    }
});*/

/*
$(document).keydown(function(e) { //Quando uma tecla é pressionada
    if (e.which == 27) pressedCtrl = true; //Informando que Crtl está acionado
    if ((e.which == 27 || e.keyCode == 27) && pressedCtrl == true) { //Reconhecendo tecla Enter
        $('#modalViewEvent').modal('hide');
        $('#modalRegisterEvent').modal('hide');
    }
});*/

