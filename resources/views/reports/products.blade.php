@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 offset-md-9">
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-12">
            <div class="card">
            <form action="{{ route('products.index') }}">
                <div class="card-header">
                    <div class="row">
                      <div class="col-6">
                          <h3 class="card-title">Products</h3>
                      </div>
                      <div class="col-5">
                          <input type="text" class="form-control" name="q" placeholder="Search by Name">
                      </div>
                      <div class="col-1">
                        <input type="submit" class="btn btn-primary" value="Search">
                      </div>
                    </div>
                  <div>
                  </div>
                </div>
              </form>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered" id="listTable">
                    <thead>                  
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Total Qty</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($products as $product)
                      <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->qty() - $product->returnQty() - $product->salesQty() }}</td>
                          </tr>
                      @endforeach  
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                </div>
              </div>
        </div>
    </div>
    
</div>
@endsection
