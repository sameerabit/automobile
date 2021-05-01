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
        <form action="{{ route('report.daily-business') }}">
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <h3 class="card-title">Products</h3>
              </div>
              <div class="col-4">
                <input type="date" value="{{ $date }}" class="form-control" name="date" placeholder="Search by Date">
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
          <h3>Services</h3>
          <table class="table table-bordered" id="listTable">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Employee Name</th>
                <th>Job Desc.</th>
                <th>Actual Cost</th>
              </tr>
            </thead>
            <tbody>
             <?php $card_total = 0; ?> 
              @foreach ($jobCardDetails as $jobCardDetail)
              <tr>
                <td>{{ $jobCardDetail->id }}</td>
                <td>{{ $jobCardDetail->employee_name }}</td>
                <td>{{ $jobCardDetail->job_desc }}</td>
                <td align="right">{{ number_format($jobCardDetail->actual_cost,2) }}</td>
                <?php $card_total+=  $jobCardDetail->actual_cost; ?> 
              </tr>
              @endforeach
            </tbody>
          </table>


          <h3>Sales</h3>
          <table class="table table-bordered" id="listTable">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Return Qty.</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
             <?php $sale_total = 0; ?> 

              @foreach ($jobSales as $jobSales)
              <tr>
                <td>{{ $jobSales->id }}</td>
                <td>{{ $jobSales->name }}</td>
                <td align="right">{{ number_format($jobSales->price,2) }}</td>
                <td align="right">{{ number_format($jobSales->quantity,2) }}</td>
                <td align="right">{{ number_format($jobSales->return_qty,2) }}</td>
                <td align="right">{{ number_format((($jobSales->quantity - $jobSales->return_qty) *$jobSales->price) ,2) }}</td>
                <?php $sale_total+= ($jobSales->quantity - $jobSales->return_qty) *$jobSales->price; ?> 
              
            </tr>
              @endforeach
            </tbody>
          </table>

          <h3>Payments</h3>
          <hr>
          <table class="table table-bordered" id="listTable">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Owner</th>
                <th>Payment</th>
              </tr>
            </thead>
            <tbody>
             <?php $payment_total = 0; ?> 
              @foreach ($payments as $payment)
              <tr>
                <td>{{ $payment->id }}</td>
                <th>{{ $payment->owner_name }}</th>
                <td align="right">{{  number_format($payment->amount,2) }}</td>
             <?php $payment_total += $payment->amount; ?> 

              @endforeach
            </tbody>
          </table>
        <br>
          <table style="width: 400px;" class="table table-bordered">
              <tr>
                  <td>Service Total:</td>
                  <td>{{ number_format($card_total,2) }}</td>
              </tr>
              <tr>
                  <td>Sales Total:</td>
                  <td>{{ number_format($sale_total,2) }}</td>
              </tr>
              <tr>
                  <td>Payment Total:</td>
                  <td>{{ number_format($payment_total,2) }}</td>
              </tr>
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