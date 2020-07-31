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

        .total-row .jsgrid-cell .btn {
            display: none;
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
                                    <h3 class="card-title">Edit Job Card</h3>

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
                                <input type="date" class="form-control" id="jobDate" placeholder="Job Date"
                                    value="{{ $jobCard->date }}">
                                     <input type="hidden" id="job_card_id" value="{{ $jobCard->id }}">
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col text-left">
                                <button type="button" class="btn btn-sm btn-primary mx-3" id="saveRecord">Save</button>
                            </div>
                        </div>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-mechanic-tab" data-toggle="tab" href="#nav-mechanic"
                                    role="tab" aria-controls="nav-mechanic" aria-selected="true">Mechanical Repair &
                                    Electrical</a>
                                <a class="nav-item nav-link" id="nav-service-tab" data-toggle="tab" href="#nav-service"
                                    role="tab" aria-controls="nav-service" aria-selected="false">Service</a>
                                <a class="nav-item nav-link" id="nav-tinkering-tab" data-toggle="tab" href="#nav-tinkering"
                                    role="tab" aria-controls="nav-tinkering" aria-selected="false">Tinkering & Painting</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-mechanic" role="tabpanel"
                                aria-labelledby="nav-mechanic-tab">
                                <button type="button" class="btn btn-primary mx-2 my-2 float-right" data-toggle="modal" data-target=".bd-example-modal-lg">Sales Items</button>
                                <div class="my-2" id="mechanicJsGrid"></div>
                            </div>
                            <div class="tab-pane fade" id="nav-service" role="tabpanel" aria-labelledby="nav-service-tab">
                                <div class="my-2" id="serviceJsGrid"></div>
                            </div>
                            <div class="tab-pane fade" id="nav-tinkering" role="tabpanel" aria-labelledby="nav-tinkering-tab">
                                <div class="my-2" id="tinkeringJsGrid"></div>
                            </div>
                        </div>

                    </div>
                    <div class="row py-2">
                        <div class="col text-right">
                            <button type="button" class="btn btn-lg btn-primary mx-3" id="saveBill">Save</button>
                        </div>
                    </div>
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Sales</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="my-2" id="itemsSalesJsGrid"></div>
                              </div>

                          </div>
                        </div>
                      </div>

                </div>
            </div>
        </div>


    </div>

    @push('scripts')

        <script src="{{ asset('bower_components/jsgrid/dist/jsgrid.min.js') }}"></script>
        <script src="{{ mix('/js/job_card.js') }}"></script>
        <script src="{{ mix('/js/job_sales.js') }}"></script>


    @endpush

@endsection
