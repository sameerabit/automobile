@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 offset-md-9">
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-12">
            <div class="card">
            <form action="{{ route('supplier-returns.index') }}">
                <div class="card-header">
                    <div class="row">
                      <div class="col-6">
                          <h3 class="card-title">Stock Returns</h3>

                      </div>
                      <div class="col-5">
                          <input type="text" class="form-control" name="q" value="{{ $term }}" placeholder=" Search by Name & Phone">
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
                        <th>Supplier</th>
                        <th>Return Date</th>
                        <th>Created At</th>
                        <th style="width: 200px">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($supplierReturns as $supplierReturn)
                      <tr>
                            <td>{{ $supplierReturn->id }}</td>
                            <td>{{ $supplierReturn->supplierBill->supplier->name }}</td>
                            <td>{{ $supplierReturn->return_date }}</td>
                            <td>{{ $supplierReturn->created_at }}</td>
                            <td class="d-flex">
                                <a class="btn btn-warning btn-sm m-auto" href="{{ route('supplier-returns.edit',$supplierReturn->id) }}"><i class="fas fa-edit"></i>Edit</a>
                                <form action="{{ route('supplier-returns.destroy',$supplierReturn->id) }}"
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
                        {{ $supplierReturns->links() }}
                </div>
              </div>
        </div>
    </div>
    @include('partials.delete') 
    
</div>
@endsection
