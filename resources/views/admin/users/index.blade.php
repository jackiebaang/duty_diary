@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6 col-12">
                    <i class="fas fa-solid fa-users"></i>
                    Users
                </div>
                {{-- <div class="col-md-6 col-12 text-right">
                    
                </div> --}}
            </div>
        </div>
        <div class="card-body p-1">
            <table class="table table-sm table-hover mb-0" id="users-table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Action</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Role</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
    </div>
    @include('admin.users.partials._datatables-scripts')
@endsection
