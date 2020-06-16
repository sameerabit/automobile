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
<form action="{{ route('categories.update',$unit->id) }}" method="POST" role="form">
      <div class="card-body">
        <div class="form-group">
           @csrf
           @method('put')
           <input type="hidden"  class="form-control" value="{{ $unit->id }}" id="id" name="id" >

          <label for="name">Name</label>
          <input type="text"  class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" value="{{ $unit->name }}" id="name" name="name" placeholder="Enter Name">
          {!! $errors->first('name', '<p class="error invalid-feedback">:message</p>') !!}
       
        </div>
        <div class="form-group">
           <label for="name">Abbreviation</label>
           <input type="text" class="form-control {{ $errors->has('abbreviation') ? 'is-invalid' : ''}}" value="{{ $unit->abbreviation }}" id="abbreviation" name="abbreviation" placeholder="Enter Abbreviation">
           {!! $errors->first('abbreviation', '<p class="error invalid-feedback">:message</p>') !!}
         </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="description">Description</label>
                <textarea class="form-control text-left {{ $errors->has('description') ? 'is-invalid' : ''}}" id="description" name="description" placeholder="Description">
                    {{ $unit->description }}
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


