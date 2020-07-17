@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Show Employee</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
<form action="{{ route('employees.update',$employee->id) }}" method="POST" enctype="multipart/form-data" role="form">
      <div class="card-body">
        <div class="form-group">
            <img height="200px" width="200px;" src="{{ asset('storage/'.$employee->image_url) }}" alt="">
        </div>
        <div class="form-group">
            @csrf
            @method('put')
           <input type="hidden"  class="form-control" value="{{ $employee->id }}" id="id" name="id" >
           <label for="name">Name</label>
           <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" value="{{ $employee->name }}" placeholder="Enter Name">
           {!! $errors->first('name', '<p class="error invalid-feedback">:message</p>') !!}
         </div>
         <div class="form-group">
          <label for="name">Address</label>
          <input type="text" class="form-control {{ $errors->has('address') ? 'is-invalid' : ''}}" id="address" name="address" value="{{ $employee->address }}" placeholder="Enter Address">
          {!! $errors->first('address', '<p class="error invalid-feedback">:message</p>') !!}
        </div>
          
          <div class="form-group row {{ $errors->has('image') ? 'has-error' : ''}}">
            <label for="phone">Image</label>
            <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : ''}}" id="image" name="image" value="{{ $employee->image }}" placeholder="Upload an image">
            {!! $errors->first('image', '<p class="error invalid-feedback">:message</p>') !!}
          </div>
  
          <div class="form-group">
              <label for="name">NIC</label>
              <input type="text" class="form-control {{ $errors->has('nic') ? 'is-invalid' : ''}}" id="nic" name="nic" value="{{ $employee->nic }}" placeholder="Enter NIC">
              {!! $errors->first('nic', '<p class="error invalid-feedback">:message</p>') !!}
            </div>
  
          <div class="form-group">
            <label for="name">Phone 1</label>
            <input type="text" class="form-control {{ $errors->has('phone_1') ? 'is-invalid' : ''}}" id="phone_1" name="phone_1" value="{{ $employee->phone_1 }}" placeholder="Enter Phone 1">
            {!! $errors->first('phone_1', '<p class="error invalid-feedback">:message</p>') !!}
          </div>
  
          <div class="form-group">
            <label for="name">Phone 2</label>
            <input type="text" class="form-control {{ $errors->has('phone_2') ? 'is-invalid' : ''}}" id="phone_2" name="phone_2" value="{{ $employee->phone_2 }}" placeholder="Enter Phone 2">
            {!! $errors->first('phone_2', '<p class="error invalid-feedback">:message</p>') !!}
          </div>
        
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>    
        </div>
    </form>
  </div>
        </div>
    </div>
</div>
@endsection


