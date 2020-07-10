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
        defaultView: 'timeGridDay', //quando abrir calendario abrir no dia
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
            $("#deleteEvent").attr("href", "/agenda/calendario/apagar/" + "?idEvent=" + info.event.id);
            info.jsEvent.preventDefault();

            //Visualizar
            //$('#modalViewEvent #id').text(info.event.id);
            $('#modalViewEvent #title').text(info.event.title);
            $('#modalViewEvent #start').text(info.event.start.toLocaleString());
            $('#modalViewEvent #end').text(info.event.end.toLocaleString());
           
            if (info.event.extendedProps.status == "P") {
                $('#modalViewEvent #status').append(`<span class="badge badge-warning">Pendente</span>`);
            }else{
                $('#modalViewEvent #status').append(`<span class="badge badge-success">Realizado</span>`);
            }

            $('#modalViewEvent #name').text(info.event.extendedProps.name + " " + info.event.extendedProps.surname); 

            //Celular
            if (info.event.extendedProps.cellphone != "") {
                $('#modalViewEvent #cellphone').text(info.event.extendedProps.cellphone);
                $('#modalViewEvent #cellphone').attr('href', `tel: +55${info.event.extendedProps.cellphone}`);
            }else{
                document.getElementById("dtCellphone").style.display = "none";
                document.getElementById("ddCellphone").style.display = "none";
            }

            //Telefone
            if (info.event.extendedProps.telephone != "") {
                $('#modalViewEvent #telephone').text(info.event.extendedProps.telephone);
                $('#modalViewEvent #telephone').attr('href', `tel: +55${info.event.extendedProps.telephone}`);
            }else{
                document.getElementById("dtTelephone").style.display = "none";
                document.getElementById("ddTelephone").style.display = "none";
            }

            //Email
            if (info.event.extendedProps.email != "") {
                $('#modalViewEvent #email').text(info.event.extendedProps.email);
                $('#modalViewEvent #email').attr('href', `malito:${info.event.extendedProps.email}`);
            }else{
                document.getElementById("dtEmail").style.display = "none";
                document.getElementById("ddEmail").style.display = "none";
            }

            //Endereço
            $('#modalViewEvent #address').text(info.event.extendedProps.logradouro + ", " + info.event.extendedProps.number + " - " + info.event.extendedProps.bairro + " " + info.event.extendedProps.localidade + " - " + info.event.extendedProps.uf + " " + info.event.extendedProps.cep);
            $('#modalViewEvent #address').attr('href', `https://www.google.com/maps/search/?api=1&query=${info.event.extendedProps.logradouro + "+" + info.event.extendedProps.number + "+" + info.event.extendedProps.bairro + "+" + info.event.extendedProps.localidade + "+" + info.event.extendedProps.uf + "+" + info.event.extendedProps.cep}`);
            
            //Edificio, bloco e Apartamento
            if (info.event.extendedProps.edifice && info.event.extendedProps.block && info.event.extendedProps.apartment != "") {
                $('#modalViewEvent #edifice').text(info.event.extendedProps.edifice);
                $('#modalViewEvent #block').text(info.event.extendedProps.block);
                $('#modalViewEvent #apartment').text(info.event.extendedProps.apartment);
            }else{
                document.getElementById("dtEdifice").style.display = "none";
                document.getElementById("edifice").style.display = "none";

                document.getElementById("dtBlock").style.display = "none";
                document.getElementById("block").style.display = "none";

                document.getElementById("dtApartment").style.display = "none";
                document.getElementById("apartment").style.display = "none";
            } /* OU if (info.event.extendedProps.edifice != "") {$('#modalViewEvent #edifice').append(`<dt class="col-sm-3">Edificio:</dt>`);$('#modalViewEvent #edifice').append(`<dd class="col-sm-8">${info.event.extendedProps.edifice}</dd>`);} */

            //Rua do Condominio
            if (info.event.extendedProps.streetCondominium != "") {
                $('#modalViewEvent #streetCondominium').text(info.event.extendedProps.streetCondominium);
            }else{
                document.getElementById("dtStreetCondominium").style.display = "none";
                document.getElementById("streetCondominium").style.display = "none";
            }

            //Observação
            if (info.event.extendedProps.observation != "") {
                $('#modalViewEvent #observation').text(info.event.extendedProps.observation);
            }else{
                document.getElementById("divObservation").style.display = "none";
                document.getElementById("dtObservation").style.display = "none";
            }

            //Editar
            $('#modalViewEvent #id').val(info.event.id);
            $('#modalViewEvent #title').val(info.event.title);
            $('#modalViewEvent #start').val(info.event.start.toLocaleString());
            $('#modalViewEvent #end').val(info.event.end.toLocaleString());
            $('#modalViewEvent #color').val(info.event.backgroundColor);


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

/*
 * Cadastrar um Evento
 * event.preventDefault(); = não fecha o modal sem autorizar
 */
$(document).ready(function () {

    /*$("#formRegisterEvent").on("submit", function (event) {
        event.preventDefault();
        $.ajax({
            method: "POST",
            url: "/agenda/calendario/cadastar",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (retorna) {
                if (retorna['sit']) {
                    //$("#msg-cad").html(retorna['msg']);
                    location.reload();
                } else {
                    $("#msg-cad").html(retorna['msg']);
                }
            }
        })
    });*/

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

    $("#formEditEvent").on("submit", function (event) {
        //event.preventDefault(); //para nao atualizar a pagina
        $.ajax({
            method: "POST",
            url: "/agenda/calendario/editar",
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (retorna) {
                if (retorna['sit']) {
                    //$("#msg-cad").html(retorna['msg']);
                    location.reload();
                } else {
                    $("#msg-edit").html(retorna['msg']);
                }
            }
        })
    });
});

/* Função para mostrar ou ocultar campos de acordo com seleção (Marcar horário?) */
function optionsScheduleTime() {
    var optionScheduleTimeYes = document.getElementById("optionScheduleTimeYes").checked;
    if (optionScheduleTimeYes) {
        document.getElementById("divTitleRegister").style.display = "block";
        document.getElementById("divStartDateRegister").style.display = "block";
        document.getElementById("divStartTimeRegister").style.display = "block";
        document.getElementById("divEndTimeRegister").style.display = "block";
    } else {
        document.getElementById("divTitleRegister").style.display = "none";
        document.getElementById("divStartDateRegister").style.display = "none";
        document.getElementById("divStartTimeRegister").style.display = "none";
        document.getElementById("divEndTimeRegister").style.display = "none";
    }
}

/* Função para mostrar ou ocultar campos de acordo com seleção (Qual evento?) */
window.onload = function () {
    var select = document.getElementById("selectionTitleRegister").addEventListener('change', function () {
        if (this.value == 'Voltar na Obra' || this.value == 'Início de Obra') {
            document.getElementById('divClientRegister').style.display = 'block';

            document.getElementById('divNameRegister').style.display = 'none';
            document.getElementById('divSurnameRegister').style.display = 'none';
            document.getElementById('divCellphoneRegister').style.display = 'none';
            document.getElementById('divTelephoneRegister').style.display = 'none';
            document.getElementById('divEmaileRegister').style.display = 'none';
            document.getElementById('divCepRegister').style.display = 'none';
            document.getElementById('divStreetRegister').style.display = 'none';
            document.getElementById('divNeighBorhoodRegister').style.display = 'none';
            document.getElementById('divCityRegister').style.display = 'none';
            document.getElementById('divStateRegister').style.display = 'none';
            document.getElementById('divTypeResidenceRegister').style.display = 'none';
            document.getElementById("divEdificeRegister").style.display = "none";
            document.getElementById("divBlockRegister").style.display = "none";
            document.getElementById("divApartamentRegister").style.display = "none";
            document.getElementById("divStreetCondominiumRegister").style.display = "none";
            document.getElementById("divNumberRegister").style.display = "none";

            document.getElementById("divScheduleTimeNo").style.display = "none";//quando clicar em realizar orçamento ele oculta "Não" na opção "Marcar Horario?"
        } else {
            document.getElementById('divClientRegister').style.display = 'none';

            document.getElementById('divNameRegister').style.display = 'block';
            document.getElementById('divSurnameRegister').style.display = 'block';
            document.getElementById('divCellphoneRegister').style.display = 'block';
            document.getElementById('divTelephoneRegister').style.display = 'block';
            document.getElementById('divEmaileRegister').style.display = 'block';
            document.getElementById('divCepRegister').style.display = 'block';
            document.getElementById('divStreetRegister').style.display = 'block';
            document.getElementById('divNeighBorhoodRegister').style.display = 'block';
            document.getElementById('divCityRegister').style.display = 'block';
            document.getElementById('divStateRegister').style.display = 'block';
            document.getElementById('divTypeResidenceRegister').style.display = 'block';

            document.getElementById("divScheduleTimeNo").style.display = "block";//quando clicar em realizar orçamento ele mostra "Não" na opção "Marcar Horario?"
        }
    });
}

/* Função para mostrar ou ocultar campo de acordo com seleção (Tipo de residencia) */
function optionTypeResidenceRegister() {
    var optionHomeRegister = document.getElementById("optionHomeRegister").checked;
    var optionCondominiumRegister = document.getElementById("optionCondominiumRegister").checked;
    if (optionHomeRegister) {
        document.getElementById("divEdificeRegister").style.display = "none";
        document.getElementById("divBlockRegister").style.display = "none";
        document.getElementById("divApartamentRegister").style.display = "none";
        document.getElementById("divStreetCondominiumRegister").style.display = "none";
        document.getElementById("divNumberRegister").style.display = "block";
    } else if (optionCondominiumRegister) {
        document.getElementById("divEdificeRegister").style.display = "none";
        document.getElementById("divBlockRegister").style.display = "none";
        document.getElementById("divApartamentRegister").style.display = "none";
        document.getElementById("divStreetCondominiumRegister").style.display = "block";
        document.getElementById("divNumberRegister").style.display = "block";
    } else {
        document.getElementById("divEdificeRegister").style.display = "block";
        document.getElementById("divBlockRegister").style.display = "block";
        document.getElementById("divApartamentRegister").style.display = "block";
        document.getElementById("divStreetCondominiumRegister").style.display = "none";
        document.getElementById("divNumberRegister").style.display = "none";
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

/* Depois de um tempo ocultar o alerta de cadastro/apagado/editado */
setTimeout(function () {
    var a = document.getElementById("toast-container");
    a.style.display = "none"
}, 5000);
