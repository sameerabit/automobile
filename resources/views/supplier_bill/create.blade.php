@extends('layouts.app')
@push('stylesheets')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

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
                          <h3 class="card-title">Supplier Bill</h3>

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
                                <label for="reference">Reference</label>
                                <input type="text" class="form-control" id="reference" placeholder="Reference">
                            </div>
                    </div>
                    <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="supplier">Supplier</label>
                                <select id="supplier_id" class="form-control">
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                    <label for="date">Bill Date</label>
                                    <input type="date" class="form-control" id="billDate" placeholder="Bill Date" value="{{ date('Y-m-d') }}">
                            </div>
                    </div>
                    <div class="row py-2">
                        <div class="col">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemModal" data-whatever="@mdo">Add Row</button>
                        </div>
                    </div>
                    <table id="item" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Buying Price</th>
                                <th>Selling Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>Litre</td>
                                <td>120</td>
                                <td>100</td>
                                <td>200</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Product</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Buying Price</th>
                                <th>Selling Price</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
               
              </div>
        </div>
    </div>
    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="itemModalLabel">Add Item to Bill</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label for="product" class="col-form-label">Product</label>
                      <select id="product_id" class="form-control" style="width: 100%"></select>
                      <input type="hidden" id="product">
                    </div>
                    <div class="form-group">
                      <label for="quantity" class="col-form-label">Quantity</label>
                      <input type="number" class="form-control" id="quantity">
                    </div>
                    <div class="form-group">
                            <label for="unit" class="col-form-label">Unit</label>
                            <select class="form-control" name="unit" id="unit">
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                            <label for="buying_price" class="col-form-label">Buying Price</label>
                            <input type="number" class="form-control" id="buying_price">
                    </div>
                    <div class="form-group">
                            <label for="selling_price" class="col-form-label">Selling Price</label>
                            <input type="number" class="form-control" id="selling_price">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" id="addToTable" class="btn btn-primary">ADD</button>
                </div>
              </div>
            </div>
          </div>
</div>
@push('scripts')
    
   <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
  
   <script>
     $(document).ready(function() {

            $('#item').DataTable();


            $('#addToTable').on('click',function(){
                buyingPrice = $('#buying_price').val();
                sellingPrice = $('#selling_price').val();
                product = $('#product').val();
                quantity = $('#quantity').val();
                unit = $('#unit').val();

            });

            $('#supplier_id').select2({
                placeholder: 'Select an option'
            });

            $("#product_id").select2({
                theme: "classic",
                onSelect: function(e){
                    alert(e);
                },
                ajax: {
                    url: "/products-search",
                    dataType: 'json',
                    delay: 10,
                    data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                    },
                    processResults: function (data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                        more: (params.page * 30) < data.total_count
                        }
                    };
                    },
                    cache: false
                },
                placeholder: 'Search for products',
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
                });

                
                function formatRepo (repo) {
                if (repo.loading) {
                    return repo.name;
                }

                var $container = $(
                    "<p>"+repo.name+"</p>"
                );

                return $container;
                }

                function formatRepoSelection (repo) {
                return repo.name || repo.id;
                }

                $('#product_id').on('select2:select', function (e) {
                    var data = e.params.data;
                    $('#product').val(data.id);
                });

     });
        
   </script>
@endpush
@endsection
