$(function () {
    /*
    * Inicializar os eventos externos
    */
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

    /*
    * Inicialize o calendário
    */
    //Data dos eventos do calendário (dados simulados)
    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear()

    var Calendar = FullCalendar.Calendar;
    //var Draggable = FullCalendarInteraction.Draggable;

    var containerEl = document.getElementById('external-events');
    //var checkbox = document.getElementById('drop-remove');
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
            listWeek: { buttonText: 'Lista Semana'}
        },

        navLinks: true,
        defaultView: 'timeGridDay', //quando abrir calendario abrir no dia
        allDaySlot: false, //evento dia todo, tanto na hora de trazer o horario quanto na hr de visualizar no dia 
        //weekends: false, //se deseja incluir colunas de sábado / domingo em qualquer uma das visualizações de calendário.

        eventLimit: true, //Somente 3 eventos por dia serão visualizados
        'themeSystem': 'bootstrap',
        //defaultTimedEventDuration: '00:50:00',
        //forceEventDuration: true,
        //defaultEventMinutes: 40,
        /*//
        
        eventTimeFormat: { // like '14:30:00'
            hour: '2-digit',
            minute: '2-digit',
        },*/

        businessHours: {
            //Dias da semana. uma matriz de números inteiros do dia da semana com base em zero (0 = domingo)
            daysOfWeek: [1, 2, 3, 4, 5], //Segunda, Terça...

            startTime: '08:00', //se colocar 08 mas nao colocar mintime ele vai mostrar o horario 07h mas nao vai deixar clicar
            endTime: '17:00',
        },

        //selectConstraint: "businessHours", //se ativado n da pra clicar no dia pelo calendario 

        minTime: "08:00:00", //ocultar do calendario as horas que n devem ser preenchidas
        maxTime: "17:00:00", //nao deixa clicar nas horas n permitidas

        //slotDuration: '00:25:00', //de quanto em quanto tempo a agenda (2 em 2 horas).

        eventSources: [{
            url: '/agenda/calendario/listar', //Rota para listar os eventos 
            type: 'POST',
            backgroundColor: '#FFC107', //Cor padrão ao cadastrar um evento
            borderColor: '#FFC107', //Cor padrão ao cadastrar um evento
            //textColor:,

            failure: function () {
                alert('there was an error while fetching events!');
            },
        }],

        /* EventClick - ao clicar no evento abre um modal para exibir as informações do evento */
        
        eventClick: function (info) {
            $("#deleteEvent").attr("href", "/agenda/calendario/apagar/" + "?id=" + info.event.id);
            info.jsEvent.preventDefault();

            //Visualizar
            $('#modalViewEvent #id').text(info.event.id);
            $('#modalViewEvent #title').text(info.event.title);
            $('#modalViewEvent #start').text(info.event.start.toLocaleString());
            $('#modalViewEvent #end').text(info.event.end.toLocaleString());

            $('#modalViewEvent #client').text(info.event.extendedProps.client); //add sobre
            $('#modalViewEvent #phone').attr('href', `tel: +55 ${info.event.extendedProps.phone}`);
            $('#modalViewEvent #address').attr('href', `https://www.google.com/maps/search/?api=1&query=${info.event.extendedProps.address}`);
            $('#modalViewEvent #observation').text(info.event.extendedProps.observation);

            $('#modalViewEvent').modal('show');
            //$('#modalEdit').modal('hide');
        },

        selectable: true, //dia é clicavel

        //Traz os dados do dia selecionado (data e hora do dia)
        select: function (info) {


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
    // $('#calendar').fullCalendar()
})

/*
 * Cadastrar um Evento
 * registerEvent = id do Formulario de cadastro
 * event.preventDefault(); = não fecha o modal sem autorizar
 */
$(document).ready(function () {

    $("#formRegisterEvent").on("submit", function (event) {
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
    });


    //Efeito botão Cancelar do modal Visualizar
    $('.btn-canc-vis').on("click", function () {
        $('.visevent').slideToggle();
        $('.formedit').slideToggle();
    });

    //Efeito botão Editar do modal Visualizar
    $('.btn-canc-edit').on("click", function () {
        $('.formedit').slideToggle();
        $('.visevent').slideToggle();
    });

    /*
    $('.btn-canc-vis').on('click', function(){
        $('#modalEdit').modal('show');
        $('#modalView').modal('hide');
      }); */

});

/* Função para mostrar ou ocultar campo de acordo com seleção (Marcar horário?) */
function selTypeRegister() {
    var optionRegisterBasic = document.getElementById("optionRegisterBasic").checked;
    if (optionRegisterBasic) {
        document.getElementById("divTitleEvent").style.display = "block";
        document.getElementById("divColorEvent").style.display = "block";
        document.getElementById("divStartEvent").style.display = "block";
        document.getElementById("divEndEvent").style.display = "block";
        document.getElementById("start").value = "";
        document.getElementById("end").value = "";
    } else {
        document.getElementById("divTitleEvent").style.display = "none";
        document.getElementById("divColorEvent").style.display = "none";
        document.getElementById("divStartEvent").style.display = "none";
        document.getElementById("divEndEvent").style.display = "none";
    }
}

/* Função para mostrar ou ocultar campo de acordo com seleção (Tipo de residencia) */
function selTypeResidence() {
    var optionHome = document.getElementById("optionHome").checked;
    var optionCondominium = document.getElementById("optionCondominium").checked;
    if (optionHome) {
        document.getElementById("edifice").style.display = "none";
        document.getElementById("block").style.display = "none";
        document.getElementById("apartment").style.display = "none";
        document.getElementById("streetCondominium").style.display = "none";
        document.getElementById("number").style.display = "block";
    } else if (optionCondominium) {
        document.getElementById("edifice").style.display = "none";
        document.getElementById("block").style.display = "none";
        document.getElementById("apartment").style.display = "none";
        document.getElementById("streetCondominium").style.display = "block";
        document.getElementById("number").style.display = "block";

    } else {
        document.getElementById("number").style.display = "none";
        document.getElementById("streetCondominium").style.display = "none";
        document.getElementById("edifice").style.display = "block";
        document.getElementById("block").style.display = "block";
        document.getElementById("apartment").style.display = "block";

    }
}

/* Date Picker */
$(document).ready(function() {
    //var inputEndDate = $('input[name="endDate"]'); //our date input has the name "date"
    var inputStartDate = $('input[name="startDate"]'); //our date input has the name "date"
    var container = $('.form-group form').length > 0 ? $('.form-group form').parent() : "body";

    /* inputEndDate.datepicker({
         format: 'dd/mm/yyyy',
         container: container,
         todayHighlight: true,
         autoclose: true,
         startDate: 'd',
         language: 'pt-BR',
         daysOfWeekDisabled: [0, 6],
     })*/

    inputStartDate.datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
        startDate: 'd',
        language: 'pt-BR',
        daysOfWeekDisabled: [0, 6],
    })
});

$(document).ready(function () {
/*Ao clicar nos campos, esconder teclado mobile */
(function($) {
    // Create plugin that prevents showing the keyboard
    $.fn.preventKeyboard = function() {
        return this
            .filter('input')
            .on('focus', function() {
                $(this)
                    .attr('readonly', 'readonly')
                    .blur()
                    .removeAttr('readonly');
            });
    };

    $(document).ready(function($) {
        // Prevent showing keyboard for the date field.
        //$('input[name=endDate]').preventKeyboard();
        $('input[name=startDate]').preventKeyboard();
    });
}(jQuery));
});

/* Depois de um tempo ocultar o alerta de cadastro/apagado/editado */
setTimeout(function () {
    var a = document.getElementById("toast-container");
    a.style.display = "none"
}, 4000);
