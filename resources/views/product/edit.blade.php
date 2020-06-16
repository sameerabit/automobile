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
<form action="{{ route('products.update',$product->id) }}" method="POST" role="form">
      <div class="card-body">
        <div class="form-group">
           @csrf
           @method('put')
           <input type="hidden"  class="form-control" value="{{ $product->id }}" id="id" name="id" >

          <label for="name">Name</label>
          <input type="text"  class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" value="{{ $product->name }}" id="name" name="name" placeholder="Enter Name">
          {!! $errors->first('name', '<p class="error invalid-feedback">:message</p>') !!}
       
        </div>
        <div class="form-group">
            <label for="categories">Categories</label>
            <select class="form-control" id="categories" name="category_id">
                @foreach ($categories as $category)
                    <option @if($category->id ==  $product->category_id) selected @endif value="{{$category->id}}">{{ $category->name }}</option>
                @endforeach
            </select>
            {!! $errors->first('category_id', '<p class="error invalid-feedback">:message</p>') !!}

          </div>
          <div class="form-group">
            <label for="categories">Brands</label>
            <select class="form-control" id="brands" name="brand_id">
                @foreach ($brands as $brand)
                    <option @if($brand->id ==  $product->brand_id) selected @endif value="{{$brand->id}}">{{ $brand->name }}</option>
                @endforeach
            </select>
            {!! $errors->first('brand_id', '<p class="error invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group row {{ $errors->has('phone') ? 'has-error' : ''}}">
            <label for="phone">Image</label>
            <img src="{{ asset($product->image_url) }}" alt="">
            <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : ''}}" id="image" name="image" placeholder="Upload an image">
            {!! $errors->first('image', '<p class="error invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="description">Description</label>
                <textarea class="form-control text-left {{ $errors->has('description') ? 'is-invalid' : ''}}" id="description" name="description" placeholder="Description">
                    {{ $product->description }}
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


