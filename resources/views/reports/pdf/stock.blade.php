<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Stock</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        table,
        th,
        td {
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
                            <h3 class="card-title">Stock Report</h3>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
                <div class="card-body">

                    <div id="details">
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
                </div>
            </div>
        </div>
    </div>
</body>

</html>