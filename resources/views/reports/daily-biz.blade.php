<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Job Card</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row py-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <table style="width: 100%;  border: 0px solid black !important;">
                            <tr style="background-color: gainsboro;">
                                <td width="200px">
                                    <img class="center" height="90px" width="200px" src="{{ $image_path }}" alt="">
                                </td>
                                <td>
                                    <p style="text-align:center">Amith Automobiles <br> 147/1, Bandaranayake Place, Thalapitiya, Galle</p>

                                </td>
                                <td>
                                    <p style="text-align:center">077 639 54 40</p>
                                </td>
                            </tr>

                        </table>

                    </div>
                    <div class="row">

                        <div class="col-6">
                            <h3 class="card-title">Daily Business - {{ $date }}</h3>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <table>

                        </table>

                    </div>

                    <div id="details">
                    <h3>Services</h3>
          <table class="table table-bordered" width="100%">
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
          <table class="table table-bordered" width="100%">
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
          <table class="table table-bordered" width="100%">
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
                </div>
            </div>
        </div>
    </div>
</body>

</html>