@extends('adminlte::page')

@section('title', 'Brands Edit')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Brand</a></li>
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
                <form method="POST" action="{{ route('brand.update', $brand->id) }}" class="col-md-6" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <h4 class="text-muted font-weight-bold">Brand Edit</h4>

                    <input type="hidden" name="page" value="{{ $page }}">

                    <div class="form-group col-md-6">
                        <label for="name">Brand Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder="Please enter..." value="{{ old('name', $brand->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option {{ $brand->status == '1' ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $brand->status == '0' ? 'selected' : '' }} value="0">Inactive</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-block btn-success">Update</button>
                    </div>
                </form>


                {{-- image --}}
                <div class="col-md-6">
                    <img src="{{ asset('./images/data_processing.png') }}" class="img-fluid" alt="data_processing">
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
        $(document).ready(function() {});
    </script>
@stop
