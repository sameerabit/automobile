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
                          <h3 class="card-title">Update Stock</h3>
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
                                <input type="text" value="{{ $supplierBill->reference }}" class="form-control" id="reference" placeholder="Reference">
                                <input type="hidden" value="{{ $supplierBill->id }}" class="form-control" id="supplier_bill_id">
                            
                            </div>
                            <div class="form-group">
                                <label for="bill_image">Bill Image</label>
                                <input type="file" class="form-control-file" id="bill_image">
                                <a target="_blank" href='{{ asset("storage/$supplierBill->image_url") }}' >Download</a>
                            </div>
                    </div>
                    <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="supplier">Supplier</label>
                                <select id="supplier_id" class="form-control">
                                </select>
                                <input type="hidden" value="{{ $supplierBill->supplier_id }}" class="form-control" id="selected_supplier_id">

                            </div>
                            <div class="form-group col-md-6">
                                    <label for="date">Bill Date</label>
                                    <input type="date" value="{{ $supplierBill->billing_date }}" class="form-control" id="billDate" placeholder="Bill Date" value="{{ date('Y-m-d') }}">
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
                                <th>Unit</th>
                                <th>Unit Id</th>
                                <th>Quantity</th>
                                <th>Buying Price</th>
                                <th>Selling Price</th>
                                <th>Id</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Product</th>
                                <th>Product Id</th>
                                <th>Unit</th>
                                <th>Unit Id</th>
                                <th>Quantity</th>
                                <th>Buying Price</th>
                                <th>Selling Price</th>
                                <th>Id</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row py-2">
                    <div class="col text-right">
                            <button type="button" class="btn btn-lg btn-primary mx-3" id="saveBill">Save</button>
                    </div>
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
                <form class="needs-validation" action="#" id="addItemToTableForm">
                <div class="modal-body">
                    <div class="form-group">
                      <label for="product" class="col-form-label">Product</label>
                      <select id="product_id" name="product_id" class="form-control" style="width: 100%"></select>
                      <input id="selected_product_id" type="hidden" class="form-control" style="width: 100%"/>

                      <input type="hidden" id="product_name">
                      <input type="hidden" id="bill_detail_id">
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
                      <label for="quantity"  class="col-form-label">Quantity</label>
                      <input type="number" class="form-control" id="quantity" name="quantity">
                    </div>
                   
                    <div class="form-group">
                            <label for="buying_price" class="col-form-label">Buying Price</label>
                            <input type="number" class="form-control" id="buying_price" name="buying_price">
                    </div>
                    <div class="form-group">
                            <label for="selling_price" class="col-form-label">Selling Price</label>
                            <input type="number" class="form-control" id="selling_price" name="selling_price">
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

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $("#itemModal").on("hidden.bs.modal", function() {
                $('#addItemToTableForm').trigger("reset");
            });


            $('#saveBill').on('click',function(){
                var tableData = datatable.data().toArray();
                var formattedTableData = formatData(tableData);
                reference= $('#reference').val();
                billDate = $('#billDate').val();
                supplierId = $('#selected_supplier_id').val();

                var file = $('#bill_image').prop('files')[0];

                var formData = new FormData();
                formData.append('supplier_id', supplierId);
                formData.append('billing_date', billDate);
                formData.append('reference', reference);
                formData.append('supllierBillDetails', JSON.stringify(formattedTableData));
                if(file != undefined){
                    formData.append('file',file);
                }

                $.ajax({
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                    },
                    url: '/supplier-bill/'+$('#supplier_bill_id').val(),
                    data: formData,
                    contentType: false, //tell jquery to avoid some checks
                    processData: false,
                    success: function(response){
                        toastr.success('Supplier Bill Successfully Updated');

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
                $('#buying_price').val(selectedRowData[5]);
                $('#selling_price').val(selectedRowData[6]);
                $('#selected_product_id').val(selectedRowData[1]);
                $('#quantity').val(selectedRowData[4]);
                $('#unit').val(selectedRowData[3]);

                $('#product_id').val('1'); // Select the option with a value of '1'
                $('#product_id').trigger('change'); // Notify any JS components that the value changed
                $('#bill_detail_id').val(selectedRowData[7]);
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
                    formattedRow['unit_id'] = data[3];
                    formattedRow['quantity'] = data[4];
                    formattedRow['buying_price'] = data[5];
                    formattedRow['selling_price'] = data[6];
                    formattedRow['id'] = data[7];
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
                        },
                        {
                            "targets": [ 3 ],
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "targets": [ 7 ],
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
                    buying_price: "required",
                    selling_price: "required",
                    selling_price: "required",
                },
                submitHandler: function(form) { 
                    return false;  
                }
            });


            $('#addToTable').on('click',function(){

                if(!$('#addItemToTableForm').valid()){
                    return;
                }
                if(selectedRow){
                    selectedRow.remove().draw( false );
                }
                var product_ids=[];
                datatable.data().toArray().forEach(function(row){
                    product_ids.push(row[1]);
                });

                productName = $('#product_name').val();
                buyingPrice = $('#buying_price').val();
                sellingPrice = $('#selling_price').val();
                product_id = $('#selected_product_id').val();
                quantity = $('#quantity').val();
                unit = $('#unit').val();
                unit_name = $("#unit option:selected").text();
                bill_detail_id = $('#bill_detail_id').val();
                
                if(!product_ids.includes(parseInt(product_id))){
                    datatable.row.add([
                        productName,
                        product_id,
                        unit_name,
                        unit,
                        quantity,
                        buyingPrice,
                        sellingPrice,
                        bill_detail_id
                    ]).draw( false );
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: productName+ ' is already exists in the table'
                    })
                }
                $('#itemModal').modal('toggle');

            });

            // $('#supplier_id').val({!! $supplierBill->supplier_id !!}).select2();
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
                data: { id: "{{ $supplierBill->supplier->name }}",title:"{{ $supplierBill->supplier->id }}" }
            });

            $('#supplier_id').on('select2:select', function (e) {
                    var data = e.params.data;
                    $('#selected_supplier_id').val(data.id);

            });

            $("#product_id").select2({
                theme: "classic",
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

                });


                $.ajax({
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('input[name=_token]').val()
                    },
                    url: '/supplier-bill-details/'+ {!! $supplierBill->id !!},
                    success: function(response){
                        fillToItemsTable(response);
                    }
                });


                function fillToItemsTable(data){
                    data.forEach(function(row){
                        datatable.row.add([
                            row.product.name,
                            row.product_id,
                            row.unit.name,
                            row.unit_id,
                            row.quantity,
                            row.buying_price,
                            row.selling_price,
                            row.id,
                        ]).draw( false );
                    });
                }

     });
        
   </script>
@endpush
@endsection
