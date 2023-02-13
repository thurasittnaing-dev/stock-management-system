@extends('adminlte::page')

@section('title', 'User Edit')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    <div class="container-fluid">
        <div class="card p-5">
            <div class="d-flex">
                <form method="POST" action="{{ route('user.update',$user->id) }}" class="col-md-6" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <h4 class="text-muted font-weight-bold mb-5">User Edit</h4>
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('messages.user_name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder="Please enter..." value="{{ old('name',$user->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label>{{ __('messages.email') }}</label>
                        <input type="email" name="email" class="form-control" placeholder="Mail Address" value="{{$user->email}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>{{ __('messages.password') }}</label>
                        <input type="password" name="password" class="form-control" placeholder="For Password Reset">
                    </div>

                    <div class="form-group col-md-6">
                      <label>{{ __('messages.table_role') }}</label>
                      <select name="roles[]" id="roles" class="form-control">
                        <option value="">--Select--</option>
                        @forelse(App\Helper::getRoles() as $role)
                          <option value="{{$role->id}}" {{ App\Helper::isUserHasRole($user->id,$role->id) ? "selected" : "" }} >{{$role->name}}</option>
                        @empty
                        @endforelse
                      </select>
                  </div>

                    <div class="form-group col-md-6 d-flex">
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
            $("#roles").select2();
        });
    </script>
@stop
