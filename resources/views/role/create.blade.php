@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Add New Role</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
<form action="{{ route('roles.store') }}" method="POST" role="form">
      <div class="card-body">
        <div class="form-group">
           @csrf
          <label for="name">Name</label>
          <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" placeholder="Enter Name">
          {!! $errors->first('name', '<p class="error invalid-feedback">:message</p>') !!}
        </div>
        <div class="row">
        @foreach($permissions as $permission)
          <div class="form-check col-3">
            <input class="form-check-input" type="checkbox" value="{{ $permission->name }}" name="permissions[]">
            <label class="form-check-label" for="flexCheckDefault">
              {{ $permission->name }}
            </label>
          </div>
        @endforeach
          
        </div>
      </div>

      </div>
      <!-- /.card-body -->
      

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
        </div>
    </div>
</div>
@endsection


