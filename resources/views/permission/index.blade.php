@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 offset-md-9">
            <a class="btn btn-block btn-primary btn-lg" href="{{ route('permissions.create') }}">Add Permission</a>
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-12">
            <div class="card">
            <form action="{{ route('permissions.index') }}">
                <div class="card-header">
                    <div class="row">
                      <div class="col-6">
                          <h3 class="card-title">permissions</h3>

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
                        <th>Name</th>
                        <th style="width: 200px">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($permissions as $brand)
                      <tr>
                            <td>{{ $brand->id }}</td>
                            <td>{{ $brand->name }}</td>
                            <td class="d-flex">
                                <a class="btn btn-warning btn-sm m-auto" href="{{ route('permissions.edit',$brand->id) }}"><i class="fas fa-edit"></i>Edit</a>
                                <form action="{{ route('permissions.destroy',$brand->id) }}"
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
                        {{ $permissions->links() }}
                </div>
              </div>
        </div>
    </div>
    @include('partials.delete') 
    
</div>
@endsection
