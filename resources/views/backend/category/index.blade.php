@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    <div class="container-fluid">
        @php
            $keyword = $_GET['keyword'] ?? '';
            $status = $_GET['status'] ?? '';
            $page = $_GET['page'] ?? 1;
        @endphp
        <div class="my-2 d-flex justify-content-between p-0">

            <div class="col-md-8 p-0">
                <form action="" id="search-form">
                    <div class="d-flex">
                        <div class="form-group mr-1 col-md-3 p-0">
                            <input type="text" class="form-control" name="keyword" placeholder="Search..."
                                value="{{ old('keyword', $keyword) }}">
                        </div>

                        <div class="form-group col-md-2">
                            <select name="status" id="status-search" class="form-control">
                                <option value="">--All--</option>
                                <option {{ $status == '1' ? 'selected' : '' }} value="1">Active</option>
                                <option {{ $status == '0' ? 'selected' : '' }} value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>


            <div class="d-flex">
                <div>
                    <a href="{{ route('category.create') }}" class="btn btn-outline-primary btn-sm cus-btn">
                        <i class="fas fa fa-plus"></i> {{ __('messages.create_new') }}
                    </a>
                </div>
            </div>


        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('messages.table_name') }}</th>
                    <th>{{ __('messages.table_status') }}</th>
                    <th>{{ __('messages.table_created_at') }}</th>
                    <th>{{ __('messages.table_action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if ($category->status)
                                <span class="badge badge-success">active</span>
                            @else
                                <span class="badge badge-danger">inactive</span>
                            @endif
                        </td>
                        <td>
                            <span class="mr-1"> {{ date('d-m-Y', strtotime($category->created_at)) }}</span>
                            <small class="text-info">{{ $category->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="d-flex">
                                <div class="mr-1">
                                    <a href="{{ url('admin/category/' . $category->id . '/edit?page=' . $page) }}"
                                        class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                </div>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                    id="delete-form-{{ $category->id }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" data-id="{{ $category->id }}"
                                        id="delete-btn-{{ $category->id }}" class="btn btn-sm btn-outline-danger"><i
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
        {!! $categories->appends(request()->input())->links() !!}
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


            // delete btn
            let categories = @json($categories).data;

            categories.forEach(category => {
                $(`#delete-btn-${category.id}`).on('click', function(e) {
                    let id = $(`#delete-btn-${category.id}`).attr('data-id');
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
            $("#status-search").on('change', function() {
                $("#search-form").submit();
            });
        });
    </script>
@stop
