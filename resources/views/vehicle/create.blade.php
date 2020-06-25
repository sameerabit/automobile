@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Add New Vehicle</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
<form action="{{ route('vehicles.store') }}" method="POST" role="form" enctype="multipart/form-data">
      <div class="card-body">
        <div class="form-group">
           @csrf
          <label for="name">Name</label>
          <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" placeholder="Enter Name">
          {!! $errors->first('name', '<p class="error invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
         <label for="name">Vehicle No</label>
         <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="reg_no" name="reg_no" placeholder="Enter Vehicle No">
         {!! $errors->first('reg_no', '<p class="error invalid-feedback">:message</p>') !!}
       </div>
       <div class="form-group">
        <label for="name">Chassis No</label>
        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" id="chassis" name="chassis" placeholder="Enter Chassis No">
        {!! $errors->first('chassis', '<p class="error invalid-feedback">:message</p>') !!}
      </div>
        
        <div class="form-group row {{ $errors->has('image') ? 'has-error' : ''}}">
          <label for="phone">Image</label>
          <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : ''}}" id="image" name="image" placeholder="Upload an image">
          {!! $errors->first('image', '<p class="error invalid-feedback">:message</p>') !!}
        </div>

        <div class="form-group">
          <label for="name">Owner Name</label>
          <input type="text" class="form-control {{ $errors->has('owner_name') ? 'is-invalid' : ''}}" id="owner_name" name="owner_name" placeholder="Enter Owner Name">
          {!! $errors->first('owner_name', '<p class="error invalid-feedback">:message</p>') !!}
        </div>

        <div class="form-group">
          <label for="name">Owner Address</label>
          <input type="text" class="form-control {{ $errors->has('owner_address') ? 'is-invalid' : ''}}" id="owner_address" name="owner_address" placeholder="Enter Owner Address">
          {!! $errors->first('owner_address', '<p class="error invalid-feedback">:message</p>') !!}
        </div>

        <div class="form-group">
          <label for="name">Owner Phone</label>
          <input type="text" class="form-control {{ $errors->has('owner_phone') ? 'is-invalid' : ''}}" id="owner_phone" name="owner_phone" placeholder="Enter Owner Address">
          {!! $errors->first('owner_phone', '<p class="error invalid-feedback">:message</p>') !!}
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


