@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Show Role</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
<form action="{{ route('permissions.store') }}" method="POST" permission="form">
      <div class="card-body">
        <div class="form-group">
           @csrf
          <label for="name">Name</label>
          <input type="text" disabled class="form-control" value="{{ $permission->name }}" id="name" name="name" placeholder="Enter Name">
        </div>
        
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a class="btn btn-primary btn-lg" href="{{ route('permissions.edit',$permission->id) }}" class="btn btn-primary">Edit</a>
      </div>
    </form>
  </div>
        </div>
    </div>
</div>
@endsection


