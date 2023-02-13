@extends('adminlte::page')

@section('title', 'Category Edit')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Category</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    @php
        $page = $_GET['page'] ?? 1;
    @endphp
    <div class="container-fluid">
        <div class="card p-3">
            <div class="d-flex">
                <form method="POST" action="{{ route('category.update', $category->id) }}" class="col-md-6" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <h4 class="text-muted font-weight-bold mb-5">Category Edit</h4>

                    <input type="hidden" name="page" value="{{ $page }}">

                    <div class="form-group col-md-6">
                        <label for="name">{{ __('messages.category_name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder="Please enter..." value="{{ old('name', $category->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status">{{ __('messages.status') }}</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option {{ $category->status == '1' ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $category->status == '0' ? 'selected' : '' }} value="0">Inactive</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-block btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ __('messages.update') }}</button>
                    </div>
                </form>


                {{-- image --}}
                <div class="col-md-6">
                    <img src="{{ asset('./images/data_processing2.png') }}" class="img-fluid info-img" alt="data_processing">
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style></style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $("#status").select2();
        });
    </script>
@stop
