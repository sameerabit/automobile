@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 offset-md-9">
            <a class="btn btn-block btn-primary btn-lg" href="{{ route('booking.index') }}">Add Booking</a>
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-12">
            <div class="card">
            <form action="{{ route('booking.all') }}">
                <div class="card-header">
                    <div class="row">
                      <div class="col-6">
                          <h3 class="card-title">Bookings</h3>

                      </div>
                      <div class="col-5">
                          <input type="text" class="form-control" name="q" placeholder=" Search by Name">
                      </div>
                      <div class="col-1">
                        <input type="submit" class="btn btn-primary" value="Search">
                      </div>
                    </div>
                  <div>
                  </div>
                </div>
              </form>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered" id="listTable">
                    <thead>                  
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Vehicle</th>
                        <th>Owner</th>
                        <th>Desc.</th>
                        <th>Start</th>
                        <th>End</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($bookings as $booking)
                      <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->vehicle->name }}</td>
                            <td>{{ $booking->vehicle->owner_name }}</td>
                            <td>{{ json_decode($booking->event)->title }}</td>
                            <td>{{ json_decode($booking->event)->start }}</td>
                            <td>{{ json_decode($booking->event)->end }}</td>
                            <td><a href="{{route('job_cards.edit',$booking->jobCard->id) }}">
                              Go to Job Card
                            </a></td>
                          </tr>
                      @endforeach  
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                        {{ $bookings->links() }}
                </div>
              </div>
        </div>
    </div>
    @include('partials.delete') 
    
</div>
@endsection
