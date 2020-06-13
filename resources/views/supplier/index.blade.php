@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 offset-md-9">
            <a class="btn btn-block btn-primary btn-lg" href="{{ route('suppliers.create') }}">Add Supplier</a>
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-12">
            <div class="card">
            <form action="{{ route('suppliers.index') }}">
                <div class="card-header">
                    <div class="row">
                      <div class="col-6">
                          <h3 class="card-title">Suppliers</h3>

                      </div>
                      <div class="col-5">
                          <input type="text" class="form-control" name="q" placeholder=" Search by Name & Phone">
                      </div>
                      <div class="col-1">
                        <input type="submit" class="btn btn-primary" value="Search">
                      </div>
                    </div>
                  <div>
                  </div>
                </div>
              </form>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered" id="listTable">
                    <thead>                  
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th style="width: 300px">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($suppliers as $supplier)
                      <tr>
                            <td>{{ $supplier->id }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td class="d-flex">
                                <a class="btn btn-warning btn-sm mx-2" href="{{ route('suppliers.edit',$supplier->id) }}">Edit</a>
                                <form action="{{ route('suppliers.destroy',$supplier->id) }}"
                                    method="POST" class="form form-inline js-confirm">
                                  {{ method_field('delete') }}
                                  @csrf
                                  <button class="btn btn-danger js-tooltip delete-btn" data-toggle="modal" data-target="#modal-warning"><em class="fa fa-times"></em> Delete</button>
                                </form>
                            </td>
                          </tr>
                      @endforeach  
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                        {{ $suppliers->links() }}
                </div>
              </div>
        </div>
    </div>
    <div class="modal fade" id="modal-warning">
        <div class="modal-dialog">
          <div class="modal-content bg-warning">
            <div class="modal-header">
              <h4 class="modal-title">Are you sure you want to delete?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <p>Please Note: This action cannot be reversed.</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
              <button id="delete" type="button" class="btn btn-danger">Delete</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
</div>

@push('scripts')
   <script>
     
      $(function(){

          var form;

          $(document).on('click','.delete-btn',function(event){
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
            form = $(this).closest('form');
          });

          $('#delete').click(function(){
                form.submit();
          });
          
      });
    
   </script>
@endpush

@endsection
