@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
@endpush
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3">
            <x-menu-sidebar></x-menu-sidebar>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>
                        Calendario Periodico
                    </h3>
                    <div class="pull-right">
                        <div class="row">
                            <div class="col-md-4">
                                <div class='d-flex'>
                                    <img src="{{asset('img/fontawesome/pdf2.png')}}" height='28' class='mr-1'>
                                    <p class='pt-2 mr-1'>
                                        Extraordinario
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class='d-flex'>
                                    <img src="{{asset('img/fontawesome/pdf1.png')}}" height='28' class='mr-1'>
                                    <p class='pt-2 mr-1'>
                                        Ordinario
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class='d-flex'>
                                    <img src="{{asset('img/fontawesome/pdf3.png')}}" height="28" class='mr-1'>
                                    <p class='pt-2 mr-1'>
                                        Secciones
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <x-custom-alert></x-custom-alert>

                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/es.js"></script>
<script> 
    var calendar = $('#calendar').fullCalendar({
        themeSystem: "bootstrap4",
        displayEventTime: false,
        editable: true,
        defaultView: "listMonth",
        eventRender: function (event, element, view) {
            if (event.allDay === 'true') {
                event.allDay = true;
            } else {
                event.allDay = false;
            }
        },
        locale: 'es',
        allDaySlot: false,
        eventSources: [{
            url: `{{route('calendar-events')}}`,
			type: "GET",
			data: function () {
				
			},
			error: function () {
				alert("there was an error while fetching events!");				
			},
        }],
        eventRender: function (event, element, view) {
            event.allDay = false;
            // let textCenter = $('.fc-center > h2').html()
            // textCenter = textCenter.charAt(0).toUpperCase() + textCenter.slice(1)
            // $('.fc-center > h2').html(textCenter) 
            element.find("td.fc-list-item-title").prepend(`<img src='${event.icon}' width='24' height='24'> `);

        },
        select: function (start, end, allDay) {

        },
        eventDrop: function (event, delta) {

        },
        eventClick: function (event) {
            window.open(event.file)
        },
		buttonText: {
			month: "Mes",
			week: "Semanal",
			agendaDay: "Hoy",
            today: 'Hoy',
            listMonth: 'Lista'
		},
		header: {
			left: "listMonth agendaWeek month",
			center: "title",
			right: "today, prev,next",
		},
    })

    // calendar.fullCalendar("refetchEvents");

    function dayClick(date, jsEvent, view) {	
        // console.log(view)
    }

    function onEventClick(calEvent, jsEvent, view) {
        console.log(calEvent)
    }

    function viewRender(view, element) {
		// if (view.name === "month") {
		// 	calendar.fullCalendar("option", "height", 420);
		// } else {
		// 	calendar.fullCalendar("option", "height", "auto");
		// }
	}
</script>
@endpush