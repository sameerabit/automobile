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
        <form action="{{ route('report.employee-working-time') }}">
          <div class="card-header">
            <div class="row">
              <div class="col-5">
                <h3 class="card-title">Employee Hours</h3>
              </div>
              <div class="col-4">
                <input type="date" class="form-control" name="date" value="{{ $date }}" placeholder="Search by Name">
              </div>
              <div class="col-1">
                <input type="submit" class="btn btn-primary" value="Search">
              </div>
              <div class="col-2">
                <a class="btn btn-primary" href="{{ route('report.employee-working-time') }}?export=pdf&date={{ $date }}">Export to PDF</a>
              </div>
            </div>
            <div>
            </div>
          </div>
        </form>
        <!-- /.card-header -->
        <div class="card-body">
                    <table class="table table-bordered" width="100%">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Employee Name</th>
                            <th>Hours /h</th>
                            <th>Cost</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $total = 0; ?> 
                        @foreach ($jobCardDetails as $jobCardDetail)
                        <tr>
                            <td>{{ $jobCardDetail->id }}</td>
                            <td>{{ $jobCardDetail->name }}</td>
                            <td align="right">{{ number_format($jobCardDetail->time/(1000*60*60),2) }}</td>
                            <td align="right">{{ number_format($jobCardDetail->actual_cost,2) }}</td>
                            <?php $total+=  $jobCardDetail->actual_cost; ?> 
                        </tr>
                        @endforeach
                        </tbody>
                    </table></div>
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