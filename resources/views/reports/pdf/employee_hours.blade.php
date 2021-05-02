<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Employee Hours</title>
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
                            <h3 class="card-title">Employee Hours - {{ $date }}</h3>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
                <div class="card-body">

                    <div id="details">
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
                                    <?php $total +=  $jobCardDetail->actual_cost; ?>
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