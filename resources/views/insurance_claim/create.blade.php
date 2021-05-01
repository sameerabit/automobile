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

    .total-row button {
        display: none
    }
</style>
@endpush
@section('content')
<div class="container">

    <div class="row py-2">
        <div class="col-md-12">
            <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-title">Insurance Claim</h3>

                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form class="needs-validation" id="insuranceForm" action="#">
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
                                <input type="date" class="form-control" id="date" placeholder="Job Date" value="{{ date('Y-m-d') }}">
                                <input type="hidden" id="insurance_claim_id">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="company">Company</label>
                                <select id="company_id" class="form-control">
                                    @foreach($insurance_companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date">Agent</label>
                                <input type="text" required id="agent_name" name="agent_name" class="form-control">
                                <input type="hidden" id="insurance_claim_id">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="vehicle">Phone 1</label>
                                <input type="number" id="phone_1" name="phone_1" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date">Phone 2</label>
                                <input type="number" id="phone_1" name="phone_1" class="form-control">
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col text-right">
                                <input type="submit" class="btn btn-md btn-primary" value="Save" id="saveRecord">
                            </div>
                        </div>
                    </form>
                    <div id="details">
                        <div class="my-2" id="claimsJsGrid"></div>
                        <div class="row py-2">
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>

    @push('scripts')
    <script src="{{ asset('bower_components/jsgrid/dist/jsgrid.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
    <script src="{{ mix('/js/insurance_claim.js') }}"></script>

    @endpush

    @endsection