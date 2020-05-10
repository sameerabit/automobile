@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Show Supplier</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
<form action="{{ route('suppliers.update',$supplier->id) }}" method="POST" role="form">
      <div class="card-body">
        <div class="form-group">
           @csrf
           @method('put')
           <input type="hidden"  class="form-control" value="{{ $supplier->id }}" id="id" name="id" placeholder="Enter Name">

          <label for="name">Name (Company/Shop)</label>
          <input type="text"  class="form-control" value="{{ $supplier->name }}" id="name" name="name" placeholder="Enter Name">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Address</label>
          <input type="text"  class="form-control" value="{{ $supplier->address }}" id="address" name="address" placeholder="Address">
        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <label for="phone">Phone Number</label>
            <input type="text"  class="form-control" value="{{ $supplier->phone }}" id="phone" name="phone" placeholder="Phone Number">
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


