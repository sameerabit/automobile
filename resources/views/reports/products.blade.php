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
              <div class="col-4">
                <input type="text" class="form-control" name="q" placeholder="Search by Name">
              </div>
              <div class="col-1">
                <input type="submit" class="btn btn-primary" value="Search">
              </div>
              <div class="col-1">
                <input id="pdf" type="button" class="btn btn-primary" value="PDF">
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
                <td>{{ $productBatch->quantity }}</td>
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
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js" integrity="sha512-s/XK4vYVXTGeUSv4bRPOuxSDmDlTedEpMEcAQk0t/FMd9V6ft8iXdwSBxV0eD60c6w/tjotSlKu9J2AAW1ckTA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

<script>
  $(document).ready(function() {


    $('#pdf').on('click', function() {
      var divHeight = $('#listTable').height();
      var divWidth = $('#listTable').width();
      var ratio = divHeight / divWidth;
      html2canvas(document.getElementById("listTable"), {
        onrendered: function(canvas) {
          var image = canvas.toDataURL("image/jpeg");
          var doc = new jsPDF(); // using defaults: orientation=portrait, unit=mm, size=A4
          console.log(doc);
          var width = doc.internal.pageSize.width;    
          var height = doc.internal.pageSize.height;
          height = ratio * width;
          doc.addImage(image, 'JPEG', 0, 0, width-20, height-10);
          doc.save('myPage.pdf'); //Download the rendered PDF.
        }
      });
    });
  });
</script>
@endpush
@endsection