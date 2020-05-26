@extends('templates.default')

@section('title', 'Agenda')

@section('head')
<!-- fullCalendar -->
<link href="<?= DIRPLUGINS . 'packages/core/main.css' ?>" rel="stylesheet" >
<link href="<?= DIRPLUGINS . 'packages/daygrid/main.css' ?>" rel="stylesheet" >

<script src="<?= DIRPLUGINS . 'packages/core/main.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'packages/interaction/main.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'packages/daygrid/main.js' ?>"></script>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'list' ],
      header: {
        left: 'prevYear,prev,next,nextYear today',
        center: 'title',
        right: 'dayGridMonth,dayGridWeek,dayGridDay'
      },
      defaultDate: '2020-02-12',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
        {
          title: 'All Day Event',
          start: '2020-02-01'
        },
        {
          title: 'Long Event',
          start: '2020-02-07',
          end: '2020-02-10'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-02-09T16:00:00'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-02-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2020-02-11',
          end: '2020-02-13'
        },
        {
          title: 'Meeting',
          start: '2020-02-12T10:30:00',
          end: '2020-02-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2020-02-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2020-02-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2020-02-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2020-02-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2020-02-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2020-02-28'
        }
      ]
    });

    calendar.render();
  });

</script>
@endsection



@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="sticky-top mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Draggable Events</h4>
                    </div>
                    <div class="card-body">
                        <!-- the events -->
                        <div id="external-events">
                            <div class="external-event bg-success">Lunch</div>
                            <div class="external-event bg-warning">Go home</div>
                            <div class="external-event bg-info">Do homework</div>
                            <div class="external-event bg-primary">Work on UI design</div>
                            <div class="external-event bg-danger">Sleep tight</div>
                            <div class="checkbox">
                                <label for="drop-remove">
                                    <input type="checkbox" id="drop-remove">
                                    remove after drop
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Event</h3>
                    </div>
                    <div class="card-body">
                        <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                            <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                            <ul class="fc-color-picker" id="color-chooser">
                                <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                                <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                                <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                                <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                                <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                            </ul>
                        </div>
                        <!-- /btn-group -->
                        <div class="input-group">
                            <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                            <div class="input-group-append">
                                <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                            </div>
                            <!-- /btn-group -->
                        </div>
                        <!-- /input-group -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-body p-0">
                    <!-- THE CALENDAR -->
                    <div id="calendar">

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
@endsection

