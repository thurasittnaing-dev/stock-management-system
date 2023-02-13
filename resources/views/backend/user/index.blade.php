@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    <div class="container-fluid">
        @php
            $keyword = $_GET['keyword'] ?? '';
            $role_id = $_GET['role_id'] ?? '';
            $page = $_GET['page'] ?? '';
        @endphp
        <div class="my-2 d-flex justify-content-between p-0">

            <div class="col-md-8 p-0">
                <form action="" id="search-form">
                    <div class="d-flex">
                        <div class="form-group mr-1 col-md-3 p-0">
                            <input type="text" class="form-control" name="keyword" placeholder="Search..."
                                value="{{ old('keyword', $keyword) }}">
                        </div>

                        <div class="form-group mr-1 col-md-2 p-0">
                          <select name="role_id" id="roles" class="form-control">
                            <option value="">--Select--</option>
                            @forelse(App\Helper::getRoles() as $role)
                            <option {{$role_id == $role->id ? "selected" : "" }} value="{{$role->id}}">{{$role->name}}</option>
                            @empty
                            @endforelse
                          </select>
                        </div>
                    </div>
                </form>
            </div>


            <div class="d-flex">
                <div>
                    <a href="{{ route('user.create') }}" class="btn btn-outline-primary btn-sm cus-btn">
                        <i class="fas fa fa-plus"></i> {{ __('messages.create_new') }}
                    </a>
                </div>
            </div>


        </div>
        <div class="my-2">Total: {{$total}}</div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('messages.table_name') }}</th>
                    <th>{{ __('messages.table_email') }}</th>
                    <th>{{__('messages.table_role')}}</th>
                    <th>{{ __('messages.table_created_at') }}</th>
                    <th>{{ __('messages.table_action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{$user->email}}</td>
                        <td>
                          @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                              <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                          @endif
                        </td>
                        <td>
                            <span class="mr-1"> {{ date('d-m-Y', strtotime($user->created_at)) }}</span>
                            <small class="text-info">{{ $user->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="d-flex">
                                <div class="mr-1">
                                    <a href="{{ url('admin/user/' . $user->id . '/edit?page=' . $page) }}"
                                        class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                </div>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                    id="delete-form-{{ $user->id }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" data-id="{{ $user->id }}"
                                        id="delete-btn-{{ $user->id }}" class="btn btn-sm btn-outline-danger"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" align="center">{{ __('messages.table_no_data') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {!! $users->appends(request()->input())->links() !!}
    </div>
@stop

@section('css')
    <style></style>
@stop

@section('js')
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


            $("#roles").select2();

            // delete btn
            let users = @json($users).data;

            users.forEach(user => {
                $(`#delete-btn-${user.id}`).on('click', function(e) {
                    let id = $(`#delete-btn-${user.id}`).attr('data-id');
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


            // status change
            $("#roles").on('change', function() {
                $("#search-form").submit();
            });
        });
    </script>
@stop
