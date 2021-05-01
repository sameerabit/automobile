@extends('layouts.app')
@push('stylesheets')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
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
                          <h3 class="card-title">Update Stock Return</h3>
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
                                @csrf
                                <input type="text" value="{{ $supplierReturn->reference }}" class="form-control" id="reference" placeholder="Reference">
                                <input type="hidden" value="{{ $supplierReturn->id }}" class="form-control" id="supplier_return_id">
                            
                            </div>
                            <div class="form-group col-md-6">
                                <label for="reference">Bill ID</label>
                                <input type="text" disabled class="form-control" value="{{ $bill_id }}" id="bill_id">
                            </div>
                    </div>
                    <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="supplier">Supplier</label>
                                <select id="supplier_id" class="form-control" disabled>
                                </select>
                                <input type="hidden" value="{{ $supplierReturn->supplier_id }}" class="form-control" id="selected_supplier_id">

                            </div>
                            <div class="form-group col-md-6">
                                    <label for="date">Return Date</label>
                                    <input type="date" value="{{ $supplierReturn->return_date }}" class="form-control" id="returnDate" placeholder="Return Date" value="{{ date('Y-m-d') }}">
                            </div>
                    </div>
                    <div class="row py-2">
                            <div class="col">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#itemModal" data-whatever="@mdo">
                                            <i class="fas fa-plus-circle"></i>
                                    </button>
                                    <button type="button" class="btn btn-info" id="deleteRow">
                                            <i class="fas fa-minus-circle"></i>
                                    </button>
                                    <button type="button" class="btn btn-info" id="editRow">
                                            <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                    </div>
                    <table id="itemsTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Product Id</th>
                                <th>Quantity</th>
                                <th> Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Product</th>
                                <th>Product Id</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row py-2">
                    <div class="col text-right">
                            <button type="button" class="btn btn-lg btn-primary mx-3" id="saveReturn">Save</button>
                    </div>
                </div>
               
              </div>
        </div>
    </div>
    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="itemModalLabel">Add Item to Return</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form class="needs-validation" action="#" id="addItemToTableForm">
                <div class="modal-body">
                    <div class="form-group">
                      <label for="product" class="col-form-label">Product</label>
                      <select id="product_id" name="product_id" class="form-control" style="width: 100%"></select>
                      <input id="selected_product_id" type="hidden" class="form-control" style="width: 100%"/>

                      <input type="hidden" id="product_name">
                    </div>
                    <div class="form-group">
                      <label for="quantity"  class="col-form-label">Quantity</label>
                      <input type="hidden" class="form-control" id="stock_qty" name="stock_qty">
                      <input type="number" class="form-control" id="quantity" name="quantity">
                    </div>
                    <div class="form-group">
                            <label for="price" class="col-form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" id="addToTable" class="btn btn-primary">ADD</button>
                </div>
            </form>

              </div>
            </div>
          </div>
</div>
@push('scripts')
    
   <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script>
  
   <script>

     $(document).ready(function() {

            var selectedRow;
            var editMode = false;

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $("#itemModal").on("hidden.bs.modal", function() {
                $('#addItemToTableForm').trigger("reset");
            });

            $('#saveReturn').on('click',function(){
                var tableData = datatable.data().toArray();
                var formattedTableData = formatData(tableData);
                reference= $('#reference').val();
                returnDate = $('#returnDate').val();
                supplierId = $('#selected_supplier_id').val();

                var supplierReturn = {
                    'supplier_id': supplierId,
                    'return_date': returnDate,
                    'reference' : reference,
                    'supllierReturnDetails': formattedTableData
                }
                $.ajax({
                    type: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                    },
                    url: '/supplier-returns/'+$('#supplier_return_id').val(),
                    data: supplierReturn,
                    success: function(response){
                        Toast.fire({
                        icon: 'success',
                        title: 'Return Updated to System Successfully.'
                    });
                    },
                    dataType: 'json'
                });
            });

            $('#itemsTable tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    datatable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );
        
            $('#deleteRow').click( function () {
                datatable.row('.selected').remove().draw( false );
            } );

            $('#editRow').click( function () {
                editMode = true;
                selectedRow = datatable.row('.selected');
                selectedRowData = selectedRow.data();
                if(!selectedRowData){
                    Toast.fire({
                        icon: 'error',
                        title: 'Please select a row to proceed'
                    });
                    return;
                }
                $('#product_name').val(selectedRowData[0]);
                $('#price').val(selectedRowData[3]);
                $('#selected_product_id').val(selectedRowData[1]);
                $('#quantity').val(selectedRowData[2]);

                var productSelect = $('#product_id');
                var option = new Option(selectedRowData[1],selectedRowData[0], true, true);
                productSelect.append(option).trigger('change');

                $('#itemModal').modal('toggle');

            } );

            function formatData(saleTableData) {
                var formattedData = [];
                saleTableData.forEach(function (data) {
                    var formattedRow = {};
                    formattedRow['product_id'] = data[1];
                    formattedRow['quantity'] = data[2];
                    formattedRow['price'] = data[3];
                    formattedData.push(formattedRow);
                });
                return formattedData;
            }

            var datatable = $('#itemsTable').DataTable(
                {
                    "columnDefs": [
                        {
                            "targets": [ 1 ],
                            "visible": false,
                            "searchable": false
                        }
                    ]
                }
            );

            $("#addItemToTableForm").validate({
                rules: {
                    quantity: "required",
                    product_id: "required",
                    price: "required",
                },
                submitHandler: function(form) { 
                    return false;  
                }
            });


            $('#addToTable').on('click',function(){

                if(!$('#addItemToTableForm').valid()){
                    return;
                }
                if(selectedRow && editMode){
                    selectedRow.remove().draw( false );
                }
                var product_ids=[];
                datatable.data().toArray().forEach(function(row){
                    product_ids.push(parseInt(row[1]));
                });

                productName = $('#product_name').val();
                price = $('#price').val();
                product_id = $('#selected_product_id').val();
                quantity = $('#quantity').val();

                
                if(!product_ids.includes(parseInt(product_id))){
                    datatable.row.add([
                        productName,
                        product_id,
                        quantity,
                        price,
                    ]).draw( false );
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: productName+ ' is already exists in the table'
                    })
                }
                $('#itemModal').modal('toggle');

            });

            // $('#supplier_id').val({!! $supplierReturn->supplier_id !!}).select2();
            $('#supplier_id').select2({
                placeholder: 'Select an option',
                theme: "classic",
                ajax: {
                    url: "/suppliers-search",
                    dataType: 'json',
                    delay: 10,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data, params) {
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
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            $("#supplier_id").select2("trigger", "select", {
                data: { id: "{{ $supplierReturn->supplierBill->supplier->name }}",title:"{{ $supplierReturn->supplierBill->supplier->id }}" }
            });

            $('#supplier_id').on('select2:select', function (e) {
                    var data = e.params.data;
                    $('#selected_supplier_id').val(data.id);

            });

            $("#addItemToTableForm").validate({
                rules: {
                    quantity: "required",
                    product_id: "required",
                    price: "required",
                },
                submitHandler: function(form) {
                    return false;
                }
            });

            $("#product_id").select2({
                theme: "classic",
                ajax: {
                    url: "/products-search-by-bill-id/"+$('#bill_id').val(),
                    dataType: 'json',
                    delay: 10,
                    data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                    },
                    processResults: function (data, params) {
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
                    $('#product_name').val(data.name);
                    $('#selected_product_id').val(data.id);
                    $('#price').val(data.buying_price);
                    $('#stock_qty').val(data.quantity);
                    $('#quantity').attr('max',data.quantity);

                });


                $.ajax({
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                    },
                    url: '/supplier-return-details/'+ {!! $supplierReturn->id !!},
                    success: function(response){
                        fillToItemsTable(response);
                    }
                });


                function fillToItemsTable(data){
                    data.forEach(function(row){
                        datatable.row.add([
                            row.product.name,
                            row.product_id,
                            row.quantity,
                            row.price,
                        ]).draw( false );
                    });
                }

     });
        
   </script>
@endpush
@endsection
