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
            //Tornar o evento arrastável usando a interface do usuário do jQuery
            /*
            $(this).draggable({
                zIndex: 1070,
                revert: true, //Fará com que o evento volte a eles
                revertDuration: 0 //Posição original após o arrasto
            })*/
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

    /*
    * inicializar os eventos externos
    
    new Draggable(containerEl, {
        itemSelector: '.external-event',
        eventData: function (eventEl) {
            console.log(eventEl);
            return {
                title: eventEl.innerText,
                backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
            };
        }
    });*/

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br',
        plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay, listDay, listWeek'
        },

        views: {
            listDay: { buttonText: 'Lista Dia' },
            listWeek: { buttonText: 'Lista Semana' }
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
            daysOfWeek: [1, 2, 3, 4, 5, 6], //Segunda, Terça...

            startTime: '08:00', //se colocar 08 mas nao colocar mintime ele vai mostrar o horario 07h mas nao vai deixar clicar
            endTime: '17:00',
        },

        //selectConstraint: "businessHours", //se ativado n da pra clicar no dia pelo calendario 

        minTime: "08:00:00", //ocultar do calendario as horas que n devem ser preenchidas
        maxTime: "17:00:00", //nao deixa clicar nas horas n permitidas

        //slotDuration: '2:00:00', //de quanto em quanto tempo a agenda (2 em 2 horas).

        eventSources: [{
            url: '/agenda/calendario/listar', //Rota para listar os eventos 
            type: 'POST',
            backgroundColor: '#FF4500', //Cor padrão ao cadastrar um evento
            borderColor: '#FF4500', //Cor padrão ao cadastrar um evento

            error: function () {
                alert('there was an error while fetching events!');
            },
        }],

        /*
        * EventClick - ao clicar no evento abre um modal para exibir as informações do evento
        */
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
            $('#modalRegisterEvent #start').val(info.start.toLocaleString());
            $('#modalRegisterEvent #end').val(info.end.toLocaleString());

            $('#modalRegisterEvent').modal('show');
        },

        editable: true,

        /*
        droppable: true, //Isso permite que as coisas sejam colocadas no calendário!!!

        drop: function (info) {
            //A caixa de seleção "remover após soltar" está marcada?
            if (checkbox.checked) {
                //Se sim, remova o elemento da lista "Eventos arrastáveis"
                info.draggedEl.parentNode.removeChild(info.draggedEl);
            }
        }, */

        extraParams: function () {
            return {
                cachebuster: new Date().valueOf()
            };
        }
    });

    calendar.render();
    // $('#calendar').fullCalendar()
})

/**
 * Cadastrar um Evento
 * registerEvent = id do Formulario de cadastro
 * event.preventDefault(); = não fecha o modal sem autorizar
 * 
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

//Mascara para o campo data e hora

/*
* Depois de um tempo ocultar o alerta de cadastro/apagado/editado
*/
setTimeout(function () {
    var a = document.getElementById("toast-container");
    a.style.display = "none"
}, 4000);
