@extends('layouts.app')
@push('stylesheets')


    <link type="text/css" rel="stylesheet" href="{{ asset('bower_components/jsgrid/dist/jsgrid.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('bower_components/jsgrid/dist/jsgrid-theme.min.css') }}" />

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}

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
                                    <h3 class="card-title">New Job Card</h3>

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
                                <input type="hidden" id="job_card_id">
                            </div>
                        </div>
                        <div class="row py-2">
                            <div class="col text-left">
                                <button type="button" class="btn btn-sm btn-primary mx-3" id="saveRecord">Save</button>
                            </div>
                        </div>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                    role="tab" aria-controls="nav-home" aria-selected="true">Mechanical Repair &
                                    Electrical</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                                    role="tab" aria-controls="nav-profile" aria-selected="false">Service</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                                    role="tab" aria-controls="nav-contact" aria-selected="false">Tinkering & Painting</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                aria-labelledby="nav-home-tab">
                                <div id="jsGrid"></div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                ...</div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                ...</div>
                        </div>

                    </div>
                    <div class="row py-2">
                        <div class="col text-right">
                            <button type="button" class="btn btn-lg btn-primary mx-3" id="saveBill">Save</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>

    @push('scripts')

        <script src="{{ asset('bower_components/jsgrid/dist/jsgrid.min.js') }}"></script>
        {{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
        {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}

        <script>
            $(function() {

                $('#vehicle_id').select2();




                var employees;

                $('#saveRecord').on('click',function(){
                    var jobDate = $('#jobDate').val();
                    var vehicle_id = $('#vehicle_id').val();
                    alert(vehicle_id);
                    $.ajax({
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('input[name=_token]').val()
                        },
                        url: '/job-cards',
                        data: {
                            vehicle_id : vehicle_id,
                            date : jobDate
                        },
                        success: function(response) {
                            $('#job_card_id').val(response.id);
                            console.log(response);
                        },
                        error: function(response) {

                        },
                        dataType: 'json'
                    });
                });

                $.ajax({
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                    },
                    url: '/employees-json',
                    success: function(response) {
                        employees = response.items;
                        console.log(employees);
                        if (employees.length > 0) {
                            loadGrid();
                        }
                    },
                    error: function(response) {

                    },
                    dataType: 'json'
                });

                clients = [];
                var grid = null;

                function loadGrid() {
                    grid = $("#jsGrid").jsGrid({
                        width: "100%",
                        height: "400px",

                        inserting: true,
                        editing: true,
                        sorting: true,
                        paging: true,
                        filtering: true,


                        data: clients,

                        fields: [{
                                name: "Employee",
                                type: "select",
                                items: employees,
                                valueField: "id",
                                textField: "name",
                                displayName: "sas"
                            },
                            {
                                name: "Job Desc",
                                type: "textarea",
                                width: 150,
                                validate: "required"
                            },
                            {
                                name: "Estimation Time",
                                type: "number",
                                sorting: false
                            },
                            {
                                type: "control"
                            }
                        ],
                        controller: {
                            loadData: function(filter) {
                                // return $.ajax({
                                //     type: "GET",
                                //     url: "",
                                //     data: filter
                                // });
                            },
                            insertItem: function(item) {
                                $jobCardId = $('#job_card_id').val();

                                var data = {
                                        employee_id : item.Employee,
                                        job_desc : item["Job Desc"],
                                        estimation_time :  item["Estimation Time"],
                                        job_card_id : $('#job_card_id').val()
                                    };
                                    debugger;
                                    console.log(data);
                                $.ajax({
                                    type: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                                    },
                                    url: "/job-card-details",
                                    data: data
                                });
                            },
                            updateItem: function(item) {
                                // return $.ajax({
                                //     type: "PUT",
                                //     url: "",
                                //     data: item
                                // });
                            },
                            deleteItem: function(item) {
                                // return $.ajax({
                                //     type: "DELETE",
                                //     url: "",
                                //     data: item
                                // });
                            }
                        },
                    });

                }



                $('#saveBill').on('click', function() {
                    var grid = $("#jsGrid").data("JSGrid");
                    console.log(grid);
                });
            });

        </script>
    @endpush

@endsection
