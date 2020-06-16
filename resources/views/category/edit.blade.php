@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-secondary">
    <div class="card-header">
      <h3 class="card-title">Show Category</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
<form action="{{ route('categories.update',$category->id) }}" method="POST" role="form">
      <div class="card-body">
        <div class="form-group">
           @csrf
           @method('put')
           <input type="hidden"  class="form-control" value="{{ $category->id }}" id="id" name="id" >

          <label for="name">Name</label>
          <input type="text"  class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" value="{{ $category->name }}" id="name" name="name" placeholder="Enter Name">
          {!! $errors->first('name', '<p class="error invalid-feedback">:message</p>') !!}
       
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="description">Description</label>
                <textarea class="form-control text-left {{ $errors->has('description') ? 'is-invalid' : ''}}" id="description" name="description" placeholder="Description">
                    {{ $category->description }}
                </textarea>
                {!! $errors->first('description', '<p class="error invalid-feedback">:message</p>') !!}
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


