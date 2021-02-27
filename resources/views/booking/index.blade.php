@extends('layouts.app')
@push('stylesheets')
<link href="{{ asset('fullcalendar/main.css') }}" rel='stylesheet' />
<link href="{{ asset('scheduler/main.css') }}" rel='stylesheet' />

<style>
      .hide{
            display:none;
        }

        .total-row .jsgrid-control-field {
            display: none;
        }

        .select2-container .select2-selection--single {
            height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px;
            right: 7px;
        }

        .total-row button {
            display:  none
        }
</style>

@endpush
@section('content')
<div class="container">
  
<div id='calendar'></div>
    
</div>

<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add Booking</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form class="needs-validation" action="#" id="addItemToTableForm">

                <div class="modal-body">
                      <div class="form-group col-md-6">
                                <label for="vehicle">Vehicle</label>
                                <select id="vehicle_id" class="form-control">
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->reg_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                          <div class="form-group">
                            <label for="quantity" class="col-form-label">Start Time</label>
                            <input type="datetime-local" class="form-control" id="start" name="start">
                          </div>
                          <div class="form-group">
                          <label for="quantity" class="col-form-label">End Time</label>
                            <input type="datetime-local" class="form-control" id="end" name="end">
                          </div>
                          <div class="form-group">
                          <label for="quantity" class="col-form-label">Note</label>
                            <input type="text" class="form-control" id="title" name="title">
                          </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" id="bookButton" class="btn btn-primary">ADD</button>
                </div>
                </form>
              </div>
            </div>
          </div>

@push('scripts')
    <script type="text/javascript" src="{{ asset('fullcalendar/main.js') }}"></script>
    <script src="{{ asset('scheduler/main.js')}}"></script>

    <script>

        $(function(){
          $.ajax({
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            url: '/bookings-json',
            success: function(response) {
                var bookings = [];
                response.forEach(function(booking){
                    bookings.push(JSON.parse(booking.event));
                });
                
            },
            error: function(response) {

            },
            dataType: 'json'
          });
        });

        $('#bookButton').on('click',function(e){
          e.preventDefault();
          var event = {
            'start' : $('#start').val(),
            'end' : $('#end').val(),
            'title' : $('#title').val()
          };
          $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('input[name=_token]').val()
            },
            data: {
                vehicle_id : $('#vehicle_id').val(),
                event : JSON.stringify(event)
            },
            url: '/bookings',
            success: function(response) {
                return response;
            },
            error: function(response) {

            },
            dataType: 'json'
          });
        });


        $('#vehicle_id').select2();
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
                text: 'Add Booking',
                click: function() {
                  $('#bookingModal').modal('toggle');
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
            events: {
              url: '/bookings-json',
              data: function(response) { // a function that returns an object
                var bookings = [];
                response.forEach(function(booking){
                    bookings.push(JSON.parse(booking.event));
                });
                console.log(response);
                return bookings;
              }
            },
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
