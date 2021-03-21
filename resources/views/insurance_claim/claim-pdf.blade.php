<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Insurance Claim</title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
  </head>
  <body>
    <div class="container">
        <div class="row py-2">
            <div class="col-md-12">
                <div class="card">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="card-title">Insurance Claim</h3>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    <div class="card-body">
                        <div class="form-row">
                            <table>
                                <tr>
                                    <td>Vehicle : {{ $insuranceClaim->vehicle->name }}</td>
                                </tr>
                                <tr>
                                    <td>Date : {{ $insuranceClaim->date }}</td>
                                </tr>
                                <tr>
                                    <td>Company : {{ $insuranceClaim->company->name }}</td>
                                </tr>
                                <tr>
                                    <td>Agent : {{ $insuranceClaim->agent_name }}</td>
                                </tr>
                                <tr>
                                    <td>Phone 1 : {{ $insuranceClaim->phone_1 }}</td>
                                </tr>
                                <tr>
                                    <td>Phone 2 : {{ $insuranceClaim->phone_2 }}</td>
                                </tr>
                            </table>
                            
                        </div>
                        
                        <div id="details">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Estimation Cost</th>
                                    <th>Actual Cost</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($insuranceClaim->details as $claim)
                                    <tr>
                                        <td>{{ $claim->item }}</td>
                                        <td>{{ $claim->est_cost }}</td>
                                        <td>{{ $claim->actual_cost }}</td>
                                        <td>{{ $claim->reason }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
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