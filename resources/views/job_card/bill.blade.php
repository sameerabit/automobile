@extends('layouts.app')
@push('stylesheets')

<link type="text/css" rel="stylesheet" href="{{ asset('bower_components/jsgrid/dist/jsgrid.min.css') }}" />
<link type="text/css" rel="stylesheet" href="{{ asset('bower_components/jsgrid/dist/jsgrid-theme.min.css') }}" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<style>
    .hide {
        display: none;
    }

    .total-row .jsgrid-control-field {
        display: none;
    }

    .select2-container .select2-selection--single {
        height: 38px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 5px;
        right: 7px;
    }

    .total-row .jsgrid-cell .btn {
        display: none;
    }

    .select2 {
        width: 100% !important;
    }
</style>
@endpush
@section('content')
<div class="container">

    <div class="row py-2">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('units.index') }}">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-title">Job Card Billing</h3>

                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                </form>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="vehicle">Vehicle</label>
                            <select id="vehicle_id" class="form-control">
                                @foreach($vehicles as $vehicle)
                                <option @if($jobCard->vehicle_id == $vehicle->id) selected @endif value="{{ $vehicle->id }}">{{ $vehicle->reg_no }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="jobDate" placeholder="Job Date" value="{{ $jobCard->date }}">
                            <input type="hidden" id="job_card_id" value="{{ $jobCard->id }}">
                        </div>
                    </div>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-mechanic-tab" data-toggle="tab" href="#nav-mechanic" role="tab" aria-controls="nav-mechanic" aria-selected="true">Mechanical Repair &
                                Electrical</a>
                            <a class="nav-item nav-link" id="nav-service-tab" data-toggle="tab" href="#nav-service" role="tab" aria-controls="nav-service" aria-selected="false">Service</a>
                            <a class="nav-item nav-link" id="nav-tinkering-tab" data-toggle="tab" href="#nav-tinkering" role="tab" aria-controls="nav-tinkering" aria-selected="false">Tinkering & Painting</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-mechanic" role="tabpanel" aria-labelledby="nav-mechanic-tab">
                            <div class="my-2" id="mechanicJsGrid"></div>
                        </div>
                        <div class="tab-pane fade" id="nav-service" role="tabpanel" aria-labelledby="nav-service-tab">
                            <div class="my-2" id="serviceJsGrid"></div>
                        </div>
                        <div class="tab-pane fade" id="nav-tinkering" role="tabpanel" aria-labelledby="nav-tinkering-tab">
                            <div class="my-2" id="tinkeringJsGrid"></div>
                        </div>
                    </div>
                    <div class="my-1">
                        <h4>Product Sales Details</h4>
                    </div>
                    <div class="my-2" id="itemsSalesJsGrid"></div>
                </div>

                <div class="row py-2 m-2">
                    <div class="col-6">
                        <h3>Payment History</h3>
                        <table class="table table-bordered m-2" id="listTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobCard->payments as $payment)
                                <tr>
                                    <td>{{ $payment->created_at }}</td>
                                    <td>{{ $payment->amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <form action="{{ route('job_cards.pay') }}" method="POST">
                            <div class="row">
                                <div class="col-6">
                                    <h3>Payment</h3>
                                </div>
                            </div>
                            <div class="row ml-2">
                                <p>Service Cost : {{ number_format($jobCard->totalServicePrice(),2) }}</p> <br>
                            </div>
                            <div class="row ml-2">
                                <p>Sales Total : {{ number_format($jobCard->totalSales(),2) }}</p>
                            </div>
                            <div class="row ml-2">
                                <p>Paid : {{ number_format($jobCard->paidAmount() ,2) }}</p>
                            </div>
                            <div class="row ml-2">
                                <p>Total to pay : {{ number_format(($jobCard->totalSales()+ $jobCard->totalServicePrice() - $jobCard->paidAmount()) ,2) }}</p>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    @csrf
                                    <input type="hidden" name="job_card_id" value="{{$jobCard->id}}">
                                    <input type="number" required class="form-control" name="amount" id="amount" max="{{number_format($jobCard->totalSales()+ $jobCard->totalServicePrice() - $jobCard->paidAmount(),2) }}">
                                </div>
                                <div class="col-4">
                                    <input type="submit" class="btn btn-primary">
                                </div>
                            </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="row py-2">
            <div class="col text-right">

                <a class="btn btn-primary" href="{{ route('job_cards.bill',$jobCard->id) }}?export=pdf">Export to PDF</a>
            </div>
        </div>


    </div>
</div>
</div>


</div>

@push('scripts')

<script src="{{ asset('bower_components/jsgrid/dist/jsgrid.min.js') }}"></script>
<script src="{{ mix('/js/easytimer.min.js') }}"></script>
<script src="{{ mix('/js/job_card_bill.js') }}"></script>
<script src="{{ mix('/js/job_sales.js') }}"></script>


@endpush

@endsection