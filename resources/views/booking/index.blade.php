@extends('layouts.app')
@push('stylesheets')
<link href="{{ asset('fullcalendar/main.css') }}" rel='stylesheet' />
<link href="{{ asset('scheduler/main.css') }}" rel='stylesheet' />
@endpush
@section('content')
<div class="container">
  
<div id='calendar'></div>
    
</div>

@push('scripts')
    <script type="text/javascript" src="{{ asset('fullcalendar/main.js') }}"></script>
    <script src="{{ asset('scheduler/main.js')}}"></script>

    <script>  
        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar');
          var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
              left: 'dayGridMonth,timeGridWeek,timeGridDay custom1',
              center: 'title',
              right: 'custom2 prevYear,prev,next,nextYear'
            },
            footerToolbar: {
              left: 'listDay,listWeek,listMonth',
              center: '',
              right: 'prev,next'
            },
            customButtons: {
              custom1: {
                text: 'custom 1',
                click: function() {
                  alert('clicked custom button 1!');
                }
              },
              custom2: {
                text: 'custom 2',
                click: function() {
                  alert('clicked custom button 2!');
                }
              }
            },
            views: {
              listDay: { buttonText: 'list day' },
              listWeek: { buttonText: 'list week' },
              listMonth: { buttonText: 'list month' }
            },
            events: 'https://fullcalendar.io/demo-events.json',
            eventClick: function(info) {
              var eventObj = info.event;
              console.log(eventObj);                
            },
          });
          calendar.render();
        });
    </script>
@endpush
@endsection
