@extends('layouts.app')
@push('stylesheets')


    <link type="text/css" rel="stylesheet" href="{{ asset('bower_components/jsgrid/dist/jsgrid.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('bower_components/jsgrid/dist/jsgrid-theme.min.css') }}" />

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
    <style>
        .hide{
            display:none;
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

        .total-row button {
            display:  none
        }

        tr th:nth-child(5),tr td:nth-child(5){
            display:none;
        }

        tr th:nth-child(6),tr td:nth-child(6){
            display:none;
        }


    </style>
@endpush
@section('content')
    <div class="container">

        <div class="row py-2">
            <div class="col-md-12">
                <div class="card">
                    <form action="{{ route('insurance_claim.index') }}">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="card-title">Insurance Claim</h3>

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
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->reg_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="jobDate" placeholder="Job Date"
                                    value="{{ date('Y-m-d') }}">
                                <input type="hidden" id="insurance_claim_id">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="vehicle">Company</label>
                                <select id="vehicle_id" class="form-control">
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->reg_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="jobDate" placeholder="Job Date"
                                    value="{{ date('Y-m-d') }}">
                                <input type="hidden" id="insurance_claim_id">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="vehicle">Vehicle</label>
                                <select id="vehicle_id" class="form-control">
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->reg_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="jobDate" placeholder="Job Date"
                                    value="{{ date('Y-m-d') }}">
                                <input type="hidden" id="insurance_claim_id">
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col text-right">
                                <button type="button" class="btn btn-md btn-primary" id="saveRecord">Save</button>
                            </div>
                        </div>
                        <div id="timesheet">
                        <div class="my-2" id="mechanicJsGrid"></div>
                        <div class="row py-2">
                    </div>
                    </div>
                    

                </div>
            </div>
        </div>


    </div>

    @push('scripts')
        <script src="{{ asset('bower_components/jsgrid/dist/jsgrid.min.js') }}"></script>
        <script src="{{ mix('/js/insurance_claim.js') }}"></script>
    @endpush

@endsection
