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
            $(this).draggable({
                zIndex: 1070,
                revert: true, //Fará com que o evento volte a eles
                revertDuration: 0 //Posição original após o arrasto
            })
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
    var Draggable = FullCalendarInteraction.Draggable;

    var containerEl = document.getElementById('external-events');
    var checkbox = document.getElementById('drop-remove');
    var calendarEl = document.getElementById('calendar');

    /*
    * inicializar os eventos externos
    */
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
    });

    var calendar = new Calendar(calendarEl, {
        locale: 'pt-br',
        plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },

        eventLimit: true, //Somente 3 eventos por dia serão visualizados
        'themeSystem': 'bootstrap',

        eventSources: [{
            url: '/agenda/calendario/listar', //Rota para listar os eventos 
            type: 'POST',
            backgroundColor: '#FF4500', //Cor padrão ao cadastrar um evento
            borderColor:     '#FF4500', //Cor padrão ao cadastrar um evento
        }],

        /*//defaultTimedEventDuration:'02:00:00',
        eventTimeFormat: { // like '14:30:00'
            hour: '2-digit',
            minute: '2-digit',
        },

        businessHours: {
            //Dias da semana. uma matriz de números inteiros do dia da semana com base em zero (0 = domingo)
            daysOfWeek: [1, 2, 3, 4, 5, 6], //Segunda, Terça...

            startTime: '8:00', //Uma hora de início 
            endTime: '16:00', //um horário de término
        }, */

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
            //$('#visualizar #description').text(info.event.extendedProps.description);
            //$('#visualizar #tel').text(info.event.extendedProps.tel);

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

        droppable: true, //Isso permite que as coisas sejam colocadas no calendário!!!

        drop: function (info) {
            //A caixa de seleção "remover após soltar" está marcada?
            if (checkbox.checked) {
                //Se sim, remova o elemento da lista "Eventos arrastáveis"
                info.draggedEl.parentNode.removeChild(info.draggedEl);
            }
        },

        extraParams: function () {
            return {
                cachebuster: new Date().valueOf()
            };
        }
    });

    calendar.render();
    // $('#calendar').fullCalendar()

    /* Adiconar Eventos */
    var currColor = '#3c8dbc' //Vermelho por padrão
    //Botão seletor de cores
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
        e.preventDefault()
        //Salvar cor
        currColor = $(this).css('color')
        //Adicione efeito de cor ao botão
        $('#add-new-event').css({
            'background-color': currColor,
            'border-color': currColor
        })
    })
    $('#add-new-event').click(function (e) {
        e.preventDefault()
        //Obtenha valor e verifique se não é nulo
        var val = $('#new-event').val()
        if (val.length == 0) {
            return
        }

        //Criar eventos
        var event = $('<div />')
        event.css({
            'background-color': currColor,
            'border-color': currColor,
            'color': '#fff'
        }).addClass('external-event')
        event.html(val)
        $('#external-events').prepend(event)

        //Adicionar funcionalidade arrastável
        ini_events(event)

        //Remover evento da entrada de texto
        $('#new-event').val('')
    })
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
}, 3000);
