@extends('adminlte::page')

@section('title', 'Role')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
<form action="{{route('role.store')}}" method="POST">
  @csrf
    <div class="container-fluid">
        <div class="my-2">
            {{-- <div class="text-muted fw-bold">Role Create</div> --}}
          
             <div class="row">
              <div class="form-group col-md-3">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror " placeholder="Role Name...">
                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group col-md-2">
                <button type="submit" class="btn btn-success"><i class="fas fa fa-plus"></i> {{ __('messages.create_new') }}</button>
              </div>
             </div>
            <div class="form-check my-4">
              <input class="form-check-input" type="checkbox" value="" id="select-all">
              <label class="form-check-label" for="select-all" style="user-select: none;">
                Select All
              </label>
            </div>
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
                        <td class="td">
                          <div class="form-check">
                            <input class="form-check-input" name="permission[]" type="checkbox" value="{{$permission['list']}}" id="{{$permission['list']}}">
                            <label class="form-check-label" for="{{$permission['list']}}" style="user-select: none;">
                              {{$permission['list']}}
                            </label>
                          </div>
                        </td>        
                        @endif

                         {{-- create --}}
                        @if (!empty($permission['create']))
                        <td class="td">
                          <div class="form-check">
                            <input class="form-check-input" name="permission[]" type="checkbox" value="{{$permission['create']}}" id="{{$permission['create']}}">
                            <label class="form-check-label" for="{{$permission['create']}}" style="user-select: none;">
                              {{$permission['create']}}
                            </label>
                          </div>
                        </td>
                        @endif

                        {{-- edit --}}
                        @if (!empty($permission['edit']))
                        <td class="td">
                          <div class="form-check">
                            <input class="form-check-input" name="permission[]" type="checkbox" value="{{$permission['edit']}}" id="{{$permission['edit']}}">
                            <label class="form-check-label" for="{{$permission['edit']}}" style="user-select: none;">
                              {{$permission['edit']}}
                            </label>
                          </div>
                        </td>
                        @endif

                        {{-- delete --}}
                        @if (!empty($permission['delete']))
                        <td class="td">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permission[]" value="{{$permission['delete']}}" id="{{$permission['delete']}}">
                            <label class="form-check-label" for="{{$permission['delete']}}" style="user-select: none;">
                              {{$permission['delete']}}
                            </label>
                          </div>
                        </td>
                        @endif

                        {{-- export --}}
                        @if (!empty($permission['export']))
                        <td class="td">
                          <div class="form-check">
                            <input class="form-check-input" name="permission[]" type="checkbox" value="{{$permission['export']}}" id="{{$permission['export']}}">
                            <label class="form-check-label" for="{{$permission['export']}}" style="user-select: none;">
                              {{$permission['export']}}
                            </label>
                          </div>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" align="center">{{ __('messages.table_no_data') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
  </form>
@stop

@section('css')
<link rel="stylesheet" href="{{asset('css/bootstrap-editable.css')}}">
<style>
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

        // select all
        $("#select-all").on("change",function(){
            if($(this).prop("checked")) {
               $("input:checkbox").prop("checked", true);
            }else {
              $("input:checkbox").prop("checked", false);
            }
           
        })

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
