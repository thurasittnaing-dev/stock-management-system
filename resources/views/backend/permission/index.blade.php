@extends('adminlte::page')

@section('title', 'Permission')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Permissions</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    <div class="container-fluid">
        <div class="my-2 d-flex justify-content-end p-0">
            <div class="d-flex">
                <div>
                    <a href="{{ route('permission.create') }}" class="btn btn-outline-primary btn-sm cus-btn">
                        <i class="fas fa fa-plus"></i> {{ __('messages.create_new') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="my-2">
            <div class="text-muted fw-bold">Permission List</div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Module</th>
                    <th>List</th>
                    <th>Create</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Export</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permissions as $key => $permission)
                    <tr>
                        <td><span class="badge badge-success">{{ strtoupper($key)}}</span></td>

                        {{-- list --}}
                        @if (!empty($permission['list']))
                        <td class="td" data-toggle="modal" data-target="#{{$permission['list']}}">{{$permission['list']}}</td>        
                        @endif

                         {{-- create --}}
                        @if (!empty($permission['create']))
                        <td class="td" data-toggle="modal" data-target="#{{$permission['create']}}" >{{$permission['create']}}</td>
                        @endif

                        {{-- edit --}}
                        @if (!empty($permission['edit']))
                        <td class="td" data-toggle="modal" data-target="#{{$permission['edit']}}">{{$permission['edit']}}</td>
                        @endif

                        {{-- delete --}}
                        @if (!empty($permission['delete']))
                        <td class="td" data-toggle="modal" data-target="#{{$permission['delete']}}">{{$permission['delete']}}</td>
                        @endif

                        {{-- export --}}
                        @if (!empty($permission['export']))
                        <td class="td" data-toggle="modal" data-target="#{{$permission['export']}}">{{$permission['export']}}</td>
                        @endif
                    </tr>
                    
                    @forelse(['list','create','edit','delete','export'] as $option)
                    {{-- modal --}}
                    <div class="modal fade" id="{{$permission[$option]}}" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <form action="{{route('permission_update')}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                <h5 class="modal-title text-muted">Permission Setting</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    
                                <input type="hidden" name="old_name" value="{{$permission[$option]}}">
                                <div class="row">
                                    <div class="form-group col-md-10">
                                        <label>Permission Name</label>
                                        <input type="text" name="name" class="form-control" value="{{$permission[$option]}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Delete</label>
                                        <a class="btn btn-danger" data-name="{{$permission[$option]}}" onclick="handleDelete('{{$permission[$option]}}')"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                                    
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Update Setting</button>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    @empty
                    @endforelse
                @empty
                    <tr>
                        <td colspan="6" align="center">{{ __('messages.table_no_data') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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

            $('#username').editable({
                type: 'text',
                pk: 1,
                name: 'temp',
                title: '',
            });


            // status change
            $("#status-search").on('change', function() {
                $("#search-form").submit();
            });
            
        });

        // handle delete
        let handleDelete = (name) => {

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
                    //confirm delete
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });

                    $.ajax({
                        type: "DELETE",
                        url: "{{route('permission_delete')}}",
                        data: {
                        name:name
                        },
                        success: function(response) {
                            if(response.status) {
                                let timerInterval
                                Swal.fire({
                                title: 'Deleted Success',
                                html: 'I will close in <b></b> milliseconds.',
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector('b')
                                    timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                    }, 100)
                                },
                                willClose: () => {
                                    clearInterval(timerInterval)
                                }
                                }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.reload();
                                }
                                })
                            }
                        }
                    });
                }
            });
        }
    </script>
@stop
