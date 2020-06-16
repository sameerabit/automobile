@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Show Product</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
<form action="{{ route('products.store') }}" method="POST" role="form">
      <div class="card-body">
        <div class="form-group">
           @csrf
          <label for="name">Name</label>
          <input type="text" disabled class="form-control" value="{{ $product->name }}" id="name" name="name" placeholder="Enter Name">
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="description">Description</label>
                <textarea disabled class="form-control text-left {{ $errors->has('description') ? 'is-invalid' : ''}}" id="description" name="description" placeholder="Description">
                    {{ $product->description }}
                </textarea>
                {!! $errors->first('description', '<p class="error invalid-feedback">:message</p>') !!}
            </div>
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <a class="btn btn-primary btn-lg" href="{{ route('products.edit',$product->id) }}" class="btn btn-primary">Edit</a>
      </div>
    </form>
  </div>
        </div>
    </div>
</div>
@endsection


