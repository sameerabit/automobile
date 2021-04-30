@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 offset-md-9">
            <a class="btn btn-block btn-primary btn-lg" href="{{ route('register') }}">Register</a>
        </div>
    </div>
    <div class="row py-2">
        <div class="col-md-12">
            <div class="card">
            <form action="{{ route('brands.index') }}">
                <div class="card-header">
                    <div class="row">
                      <div class="col-6">
                          <h3 class="card-title">Users</h3>

                      </div>
                      <div class="col-5">
                          <input type="text" class="form-control" name="q" placeholder=" Search by Name">
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
                        <th>User Name</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $user)
                      <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                          </tr>
                      @endforeach  
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                        {{ $users->links() }}
                </div>
              </div>
        </div>
    </div>
    @include('partials.delete') 
    
</div>
@endsection
