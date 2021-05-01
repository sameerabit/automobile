@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row py-2">
        <div class="col-md-12">
            <div class="card">
            <form action="{{ route('job_cards.index') }}">
                <div class="card-header">
                    <div class="row">
                      <div class="col-6">
                          <h3 class="card-title">Job Card</h3>
                      </div>
                      <div class="col-5">
                          <input type="text" class="form-control" name="q" placeholder=" Search by Vehicle No,Name">
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
                        <th>Vehicle No.</th>
                        <th>Owner</th>
                        <th>Date</th>
                        <th>Payment Status</th>
                        <th style="width: 200px">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($jobCards as $jobCard)
                      <tr>
                            <td>{{ $jobCard->id }}</td>
                            <td>{{ $jobCard->vehicle->reg_no }}</td>
                            <td>{{ $jobCard->vehicle->owner_name }}</td>
                            <td>{{ $jobCard->date }}</td>
                            <td>{{ $jobCard->paymentStatus() == 1 ? 'To Pay' : 'Paid' }}</td>
                            <td class="d-flex">
                                <a class="btn btn-warning btn-sm m-auto" href="{{ route('job_cards.edit',$jobCard->id) }}"><i class="fas fa-edit"></i>Edit</a>
                                <form action="{{ route('job_cards.destroy',$jobCard->id) }}"
                                    method="POST" class="form form-inline js-confirm">
                                  {{ method_field('delete') }}
                                  @csrf
                                  <button class="btn btn-danger btn-sm js-tooltip delete-btn" data-toggle="modal" data-target="#modal-warning"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                            </td>
                          </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                        {{ $jobCards->links() }}
                </div>
              </div>
        </div>
    </div>
    @include('partials.delete')

</div>
@endsection
