@extends('layouts.app')
@push('stylesheets')


<link type="text/css" rel="stylesheet" href="{{ asset('bower_components/jsgrid/dist/jsgrid.min.css') }}" />
<link type="text/css" rel="stylesheet" href="{{ asset('bower_components/jsgrid/dist/jsgrid-theme.min.css') }}" />


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
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" id="billDate" placeholder="Bill Date" value="{{ date('Y-m-d') }}">
                                </div>
                        </div>
                        <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Mechanical</a>
                                  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Service</a>
                                  <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Repair</a>
                                </div>
                              </nav>
                              <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div id="jsGrid"></div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
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
  
   <script>
   
        $(function(){
           
            clients = [];
            var grid = null;

            var countries = [
                { Name: "", Id: 0 },
                { Name: "United States", Id: 1 },
                { Name: "Canada", Id: 2 },
                { Name: "United Kingdom", Id: 3 }
            ];
 
            grid = $("#jsGrid").jsGrid({
                width: "100%",
                height: "400px",
        
                inserting: true,
                editing: true,
                sorting: true,
                paging: true,
                filtering: true,

        
                data: clients,
        
                fields: [
                    { name: "Job", type: "textarea", width: 150, validate: "required" },
                    { name: "Employee", type: "select", items: countries, valueField: "Id", textField: "Name" },
                    { name: "Estimation Time", type: "number", sorting: false },
                    { type: "control" }
                ]
            });

            $('#saveBill').on('click',function(){
                var items = $("#jsGrid").jsGrid("option", "data");
                console.log(items);
            });
        });
   
   </script>
@endpush

@endsection


