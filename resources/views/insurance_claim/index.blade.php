@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
        <div class="col-md-3 offset-md-9">
            <a class="btn btn-block btn-primary btn-lg" href="{{ route('insurance_claim.create') }}">Add Claim</a>
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-12">
            <div class="card">
            <form action="{{ route('job_cards.index') }}">
                <div class="card-header">
                    <div class="row">
                      <div class="col-6">
                          <h3 class="card-title">Insurance Claims</h3>
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
                        <th>Company Name</th>
                        <th>Agent Name</th>
                        <th>Date</th>
                        <th style="width: 200px">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($insuranceClaims as $insuranceClaim)
                      <tr>
                            <td>{{ $insuranceClaim->id }}</td>
                            <td>{{ $insuranceClaim->vehicle->reg_no }}</td>
                            <td>{{ $insuranceClaim->company->name }}</td>
                            <td>{{ $insuranceClaim->agent_name }}</td>
                            <td>{{ $insuranceClaim->date }}</td>
                            <td class="d-flex">
                                <a class="btn btn-warning btn-sm m-auto" href="{{ route('insurance_claim.edit',$insuranceClaim->id) }}"><i class="fas fa-edit"></i>Edit</a>
                                <form action="{{ route('insurance_claim.destroy',$insuranceClaim->id) }}"
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
                        {{ $insuranceClaims->links() }}
                </div>
              </div>
        </div>
    </div>
    @include('partials.delete')

</div>
@endsection
