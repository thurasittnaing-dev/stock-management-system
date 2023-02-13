@extends('adminlte::page')

@section('title', 'Prtmiddion Create')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permission</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    <div class="container-fluid">
        <div class="card p-5">
            <div class="d-flex">
                <form method="POST" action="{{ route('permission.store') }}" class="col-md-6" autocomplete="off">
                    @csrf
                    <h4 class="text-muted font-weight-bold mb-5">Permission Create</h4>

                    <div class="form-group col-md-6">
                      <label>{{ __('messages.permission_module') }}</label>
                      <input type="text" name="module" id="module" placeholder="Module name" class="form-control @error('module') is-invalid @enderror" value="{{ old('name') }}">
                      @error('module')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">{{ __('messages.permission_name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder="Please enter..." value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                      <input type="checkbox" class="from-check-input" name="crud_mode" id="crud-mode">
                      <label for="crud-mode" class="form-check-label" style="user-select: none;">CRUD</label>
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
        $(document).ready(function() {
            $("#status").select2();

            $("#name").on("input", function() {
                if($(this).val().includes(',')) {
                    $("#module").val('');
                    $("#module").attr('disabled',true);
                    $("#crud-mode").attr('checked',true);
                }else {
                  $("#module").attr('disabled',false);
                  $("#crud-mode").attr('checked',false);
                }
            });
        });
    </script>
@stop
