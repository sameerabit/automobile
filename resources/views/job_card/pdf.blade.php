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
                            <h3 class="card-title">Detailed Bill</h3>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <table>
                            <tr>
                                <td>Vehicle Name:</td>
                                <td>{{ $jobCard->vehicle->name }}</td>
                            </tr>
                            <tr>
                                <td>Vehicle No:</td>
                                <td>{{ $jobCard->vehicle->reg_no }}</td>
                            </tr>
                            <tr>
                                <td>Owner No:</td>
                                <td>{{ $jobCard->vehicle->owner_name }}</td>
                            </tr>
                        </table>
                    </div>

                    <div id="details">
                        <h3>Service Details</h3>
                        <table style="width:100%">
                            <thead>
                                <tr>
                                    <th>Desc.</th>
                                    <th>Time</th>
                                    <th>Actual Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $service_cost = 0 ?>
                                @foreach($jobCard->details as $detail)
                                <tr>
                                    <td>{{ $detail->job_desc }}</td>
                                    <td style="text-align:right">{{ number_format($detail->time/(1000*60*60),2) }}</td>
                                    <td style="text-align:right">{{ number_format($detail->actual_cost,2) }}</td>
                                </tr>
                                <?php $service_cost += $detail->actual_cost; ?>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align:right;font-weight: bold;">{{ number_format($service_cost,2) }}</td>
                                </tr>
                            </tfoot>
                        </table>

                        <h3>Product Sales Details</h3>
                        <table style="width:100%">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sales_cost = 0 ?>
                                @foreach($jobCard->sales as $sale)
                                <tr>
                                    <td>{{ $sale->productBatch->product->name }}</td>
                                    <td style="text-align:right">{{ number_format(($sale->quantity - $sale->return_qty),2) }}</td>
                                    <td style="text-align:right">{{ number_format($sale->price,2) }}</td>
                                    <td style="text-align:right">{{ number_format(($sale->quantity - $sale->return_qty) * $sale->price,2) }}</td>
                                </tr>
                                <?php $sales_cost += ($sale->quantity - $sale->return_qty) * $sale->price ?>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align:right;font-weight: bold;">{{ number_format($sales_cost,2) }}</td>
                                </tr>

                                <tr>
                                    <td colspan="4" style="text-align:right;font-weight: bold;">
                                        <h4>Total: {{ number_format($sales_cost + $service_cost,2) }}
                                            <h4>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row py-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>