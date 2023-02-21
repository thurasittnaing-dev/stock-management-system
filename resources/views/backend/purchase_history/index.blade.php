@extends('adminlte::page')

@section('title', 'Purchase History')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Purchase History</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    <div class="container-fluid">
        <div class="my-2 d-flex justify-content-end p-0">
            <div class="d-flex">
                <div>
                    {{-- <a href="{{ route('role.create') }}" class="btn btn-outline-primary btn-sm cus-btn">
                        <i class="fas fa fa-plus"></i> {{ __('messages.create_new') }}
                    </a> --}}
                </div>
            </div>
        </div>
        <div class="my-2">
            <div class="text-muted fw-bold">Total Purchases: {{$count}}</div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Supplier</th>
                    <th>Purchase Date</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total Price</th>
                    <th>Currency</th>     
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($purchase_histories as $history)
                   <tr>
                    <td>{{++$i}}</td>
                    <td>
                        <img src="{{asset('uploads/stocks/'.json_decode($history->stock_img)[0])}}" class="img-fluid table-img"
                        data-magnify="gallery"
                        data-caption="{{$history->stock_name}}"
                        data-src="{{asset('uploads/stocks/'.json_decode($history->stock_img)[0])}}">
                    </td>
                    <td>{{$history->stock_name}}</td>
                    <td>Stock</td>
                    <td>{{$history->supplier_name}}</td>
                    <td>{{date('d-m-Y',strtotime($history->purchase_date))}}</td>
                    <td>{{$history->price}}</td>
                    <td>{{$history->qty}}</td>
                    <td>{{$history->qty * $history->price}} {{strtoupper($history->currency)}}</td>
                    <td>
                        @if($history->currency == "mmk") 
                        <span class="badge badge-success">{{strtoupper($history->currency)}}</span>
                        @else 
                        <span class="badge badge-primary">{{strtoupper($history->currency)}}</span>
                        @endif
                    </td>
                   </tr>
                @empty
                    <tr>
                        <td colspan="11" align="center">{{ __('messages.table_no_data') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {!! $purchase_histories->appends(request()->input())->links() !!}
    </div>
@stop

@section('css')
<link rel="stylesheet" href="{{asset('css/jquery.magnify.min.css')}}">
<link rel="stylesheet" href="{{asset('css/bootstrap-editable.css')}}">
<style>
</style>
@stop

@section('js')
    <script src="{{asset('js/jquery.magnify.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-editable.min.js')}}"></script>
    <script>
      
        $(document).ready(function() {

            // Magnify
            $('[data-magnify=gallery]').magnify();
            
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

    </script>
@stop
