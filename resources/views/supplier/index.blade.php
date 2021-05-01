@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 offset-md-9">
            <a class="btn btn-block btn-primary btn-sm" href="{{ route('suppliers.create') }}">Add Supplier</a>
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-12">
            <div class="card">
            <form action="{{ route('suppliers.index') }}">
                <div class="card-header">
                    <div class="row">
                      <div class="col-6">
                          <h3 class="card-title">Suppliers</h3>

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
                        <th>Name</th>
                        <th>Phone</th>
                        <th style="width: 200px">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($suppliers as $supplier)
                      <tr>
                            <td>{{ $supplier->id }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td class="d-flex">
                                <a class="btn btn-warning btn-sm m-auto" href="{{ route('suppliers.edit',$supplier->id) }}"><i class="fas fa-edit"></i>Edit</a>
                                <form action="{{ route('suppliers.destroy',$supplier->id) }}"
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
                        {{ $suppliers->links() }}
                </div>
              </div>
        </div>
    </div>
    @include('partials.delete') 
    
</div>
@endsection
