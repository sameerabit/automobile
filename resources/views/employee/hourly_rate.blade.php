@extends('layouts.app')

@push('stylesheets')

    <link type="text/css" rel="stylesheet" href="{{ asset('bower_components/jsgrid/dist/jsgrid.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('bower_components/jsgrid/dist/jsgrid-theme.min.css') }}" />

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                                    <h3 class="card-title">Employee Hourly Rate</h3>

                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </form>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="details">
                        <div class="my-2" id="hourlyRateJsGrid"></div>
                        <div class="row py-2">
                    </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
    </div>

    @push('scripts')
        <script src="{{ asset('bower_components/jsgrid/dist/jsgrid.min.js') }}"></script>
        <script src="{{ mix('/js/employee_hourly_rate.js') }}"></script>
    @endpush

@endsection
