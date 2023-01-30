@extends('adminlte::page')

@section('title', 'Locations Create')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('location.index') }}">Location</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    <div class="container-fluid">
        <div class="card p-5">
            <div class="d-flex">
                <form method="POST" action="{{ route('location.store') }}" class="col-md-6" autocomplete="off">
                    @csrf
                    <h4 class="text-muted font-weight-bold mb-5">Location Create</h4>
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('messages.location_name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder="Please enter..." value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>{{ __('messages.lat') }}</label>
                        <input type="text" name="lat" class="form-control" placeholder="Optional">
                    </div>
                    <div class="form-group col-md-6">
                        <label>{{ __('messages.lng') }}</label>
                        <input type="text" name="lng" class="form-control" placeholder="Optional">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status">{{ __('messages.status') }}</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6 d-flex">
                        <button type="submit" class="btn btn-block btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ __('messages.save') }}</button>
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
        $(document).ready(function() {});
    </script>
@stop
