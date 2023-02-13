@extends('adminlte::page')

@section('title', 'Role')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Role</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    <div class="container-fluid">
        <div class="my-2 d-flex justify-content-end p-0">
            <div class="d-flex">
                <div>
                    <a href="{{ route('role.create') }}" class="btn btn-outline-primary btn-sm cus-btn">
                        <i class="fas fa fa-plus"></i> {{ __('messages.create_new') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="my-2">
            <div class="text-muted fw-bold">Role List</div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Total Users</th>
                    <th>Total Permissions</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $key => $role)
                    <tr>
                      <td>{{++$i}}</td>
                      <td>{{$role->name}}</td>
                      <td><a href="{{url('admin/user?role_id='.$role->id)}}" class="btn btn-link">{{App\Helper::getUserCount($role->id)}}</a></td>
                      <td><span class="text text-primary">{{App\Helper::getTotalPermissionCount($role->id)}}</span></td>
                      <td>{{date('d-m-Y',strtotime($role->created_at))}}</td>
                      <td>
                        <div class="d-flex">
                          <a href="{{route('role.edit',$role->id)}}" class="btn btn-sm btn-primary mr-1"><i class="fas fa-edit"></i></a>
                          <form action="{{route('role.destroy',$role->id)}}" method="POST" id="delete-form-{{$role->id}}">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-sm btn-danger" data-id="{{ $role->id }}"
                              id="delete-btn-{{ $role->id }}"><i class="fas fa-trash"></i></button>
                          </form>
                        </div>
                      </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" align="center">{{ __('messages.table_no_data') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {!! $roles->appends(request()->input())->links() !!}
    </div>
@stop

@section('css')
<link rel="stylesheet" href="{{asset('css/bootstrap-editable.css')}}">
<style>
    .td {
        cursor: pointer;
        transition: all 0.35s ease-in-out;
    }
    .td:hover {
        background-color: rgba(0,0,0,0.25);
    }
</style>
@stop

@section('js')
    <script src="{{asset('js/bootstrap-editable.min.js')}}"></script>
    <script>
      
        $(document).ready(function() {
            
            @if (Session::has('success'))
                Swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: '{{ Session::get('success') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    position: 'top-end',
                    type: 'error',
                    title: '{{ Session::get('error') }}',
                    showConfirmButton: false,
                    timer: 1500
                })
            @endif      
        });

       
        // delete btn
        let roles = @json($roles).data;

        roles.forEach(role => {
            $(`#delete-btn-${role.id}`).on('click', function(e) {
                let id = $(`#delete-btn-${role.id}`).attr('data-id');
                // sweet alert
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $(`#delete-form-${id}`).submit();
                    }
                })
            });
        });
    </script>
@stop
