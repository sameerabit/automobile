@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Show Company</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
<form action="{{ route('insurance_companies.update',$insurance_company->id) }}" method="POST" role="form">
      <div class="card-body">
        <div class="form-group">
           @csrf
           @method('put')
           <input type="hidden"  class="form-control" value="{{ $insurance_company->id }}" id="id" name="id" >

          <label for="name">Name (Company/Shop)</label>
          <input type="text"  class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" value="{{ $insurance_company->name }}" id="name" name="name" placeholder="Enter Name">
          {!! $errors->first('name', '<p class="error invalid-feedback">:message</p>') !!}
       
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Address</label>
          <input type="text"  class="form-control {{ $errors->has('address') ? 'is-invalid' : ''}}" value="{{ $insurance_company->address }}" id="address" name="address" placeholder="Address">
          {!! $errors->first('address', '<p class="error invalid-feedback">:message</p>') !!}
        
        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <label for="phone">Phone Number</label>
                <input type="text"  class="form-control {{ $errors->has('phone') ? 'is-invalid' : ''}}" value="{{ $insurance_company->phone }}" id="phone" name="phone" placeholder="Phone Number">
                {!! $errors->first('phone', '<p class="error invalid-feedback">:message</p>') !!}
            </div>
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


