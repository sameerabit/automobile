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
                        <th>Brand</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Active Stock</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($productBatches as $productBatch)
                      <tr>
                            <td>{{ $productBatch->id }}</td>
                            <td>{{ $productBatch->product->name }}</td>
                            <td>{{ $productBatch->product->brand->name }}</td>
                            <td>{{ $productBatch->supplierBillDetail ? $productBatch->supplierBillDetail->buying_price : 0 }}</td>
                            <td>{{ $productBatch->supplierBillDetail ? $productBatch->supplierBillDetail->selling_price : 0 }}</td>
                            <td>{{ $productBatch->qty() - $productBatch->returnQty() - $productBatch->salesQty() }}</td>
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
