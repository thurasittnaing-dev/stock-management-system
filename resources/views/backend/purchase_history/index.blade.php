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
        <div class="my-2 d-flex justify-content-start p-0">
           <div>
            @php
                $keyword = $_GET['keyword'] ?? '';
                $stock_type_id = $_GET['stock_type_id'] ?? '';
                $brand_id = $_GET['brand'] ?? '';
                $category_id = $_GET['category'] ?? '';
                $supplier_id = $_GET['supplier_id'] ?? '';
                $currency = $_GET['currency'] ?? '';
                $min_price = $_GET['min_price'] ?? '';
                $max_price = $_GET['max_price'] ?? '';
                $min_total_price = $_GET['min_total_price'] ?? '';
                $max_total_price = $_GET['max_total_price'] ?? '';
                $qty_from = $_GET['qty_from'] ?? '';
                $qty_to = $_GET['qty_to'] ?? '';
                $from_date = $_GET['from_date'] ?? '';
                $to_date = $_GET['to_date'] ?? '';
                $search_currency = $_GET['search_currency'] ?? '';
                $search_total_currency = $_GET['search_total_currency'] ?? '';
            @endphp
            <form action="" id="filter-form" autocomplete="off">
                <div class="row">
                    <div class="form-group mr-1">
                        <input type="text" name="keyword" class="form-control" placeholder="Keyword..." value="{{$keyword}}">
                    </div>
                    <div class="form-group">
                        <button type="button" data-toggle="modal" data-target="#filterModal" id="filter-btn" class="btn btn-warning"><i class="fas fa-filter"></i></button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="filterModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">More Filter</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Stock Type</label>
                                    <select name="stock_type_id" class="form-control select2">
                                        <option value="">--Select--</option>
                                        @forelse (App\Helper::getStockTypes() as $stock_type)
                                        <option {{$stock_type->id == $stock_type_id ? "selected" : "" }} value="{{$stock_type->id}}">{{$stock_type->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>


                                <div class="form-group col-md-4">
                                    <label>Brand</label>
                                    <select name="brand" id="" class="form-control select2">
                                        <option value="">--Select--</option>
                                        @forelse(App\Helper::getBrands() as $brand)
                                        <option {{$brand->id == $brand_id ? "selected" : "" }} value="{{$brand->id}}">{{$brand->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Categories</label>
                                    <select name="category" id="" class="form-control select2">
                                        <option value="">--Select--</option>
                                        @forelse(App\Helper::getCategories() as $category)
                                        <option {{$category->id == $category_id ? "selected" : "" }}   value="{{$category->id}}">{{$category->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                               
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Supplier</label>
                                    <select name="supplier_id" class="form-control select2">
                                        <option value="">--Select--</option>
                                        @forelse (App\Helper::getSuppliers() as $supplier)
                                        <option {{$supplier->id == $supplier_id ? "selected" : "" }} value="{{$supplier->id}}">{{$supplier->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Currency</label>
                                    <select name="currency" id="" class="form-control select2">
                                        <option value="">--Select--</option>
                                        <option {{ $currency == "mmk" ? "selected" : "" }} value="mmk">MMK</option>
                                        <option {{ $currency == "usd" ? "selected" : "" }} value="usd">USD</option>
                                    </select>
                                </div>

                            </div>


                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Min Price From</label>
                                    <input type="number" name="min_price" value="{{$min_price}}" class="form-control" placeholder="1"  min="0">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Max Price To</label>
                                    <input type="number" name="max_price" value="{{$max_price}}" class="form-control" placeholder="3" min="0">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Currency</label>
                                    <select name="search_currency" id="" class="form-control select2CF">
                                        <option  {{ $search_currency == "mmk" ? "selected" : "" }} value="mmk">MMK</option>
                                        <option  {{ $search_currency == "usd" ? "selected" : "" }} value="usd">USD</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Min Total Price From</label>
                                    <input type="number" name="min_total_price" id="min_total_price" value="{{$min_total_price}}" class="form-control" placeholder="1"  min="0">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Max Total Price To</label>
                                    <input type="number" name="max_total_price" id="max_total_price" value="{{$max_total_price}}" class="form-control" placeholder="3" min="0">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Currency</label>
                                    <select name="search_total_currency" id="" class="form-control select2CF">
                                        <option  {{ $search_total_currency == "mmk" ? "selected" : "" }} value="mmk">MMK</option>
                                        <option  {{ $search_total_currency == "usd" ? "selected" : "" }} value="usd">USD</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Qty From</label>
                                    <input type="number" name="qty_from" id="qty_from" value="{{$qty_from}}" class="form-control" placeholder="1"  min="0">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Qty To</label>
                                    <input type="number" name="qty_to" id="qty_to" value="{{$qty_to}}" class="form-control" placeholder="3" min="0">
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>From Date</label>
                                    <input type="text" name="from_date" id="from_date" value="{{$from_date}}" class="form-control flatpicker">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>To Date</label>
                                    <input type="text" name="to_date" id="to_date" value="{{$to_date}}" class="form-control flatpicker">
                                </div>
                            </div>

                           
                        </div>
                        <div class="modal-footer">
                        <button type="button" onclick="resetForm()" class="btn btn-warning">Clear All</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-magnifying-glass"></i> Search
                        </button>
                        </div>
                    </div>
                    </div>
                </div>
            </form>
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
                    <th>Stock Type</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Purchase Date</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total Price</th>
                    {{-- <th>Currency</th>      --}}
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
                    <td>{{$history->stock_type_name}}</td>
                    <td>{{$history->brand_name}}</td>
                    <td>{{$history->category_name}}</td>
                    <td>{{$history->supplier_name}}</td>
                    <td>
                        <div>{{date('d-m-Y',strtotime($history->purchase_date))}}</div>
                        <small class="badge badge-sm badge-info">{{ date('l', strtotime($history->purchase_date))}}</small>
                    </td>
                    <td>{{number_format($history->price)}} {{strtoupper($history->currency)}}</td>
                    <td>{{$history->qty}}</td>
                    <td>{{number_format($history->total)}} {{strtoupper($history->currency)}}</td>
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
<link rel="stylesheet" href="{{asset('css/flatpickr.min.css')}}">
<style>
</style>
@stop

@section('js')
    <script src="{{asset('js/jquery.magnify.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-editable.min.js')}}"></script>
    <script src="{{asset('js/flatpickr.min.js')}}"></script>
    <script>
      
        $(document).ready(function() {

            // flatpicker
            $(".flatpicker").flatpickr({
                dateFormat: "d-m-Y",
            });

            // Magnify
            $('[data-magnify=gallery]').magnify();


            // select2
            $('.select2').select2({
                placeholder: '--Select--', // placeholder
                allowClear: true, // clear btn
                width: '100%', // for specific width
            });

            $('.select2CF').select2({
                allowClear: false, // clear btn
                width: '100%', // for specific width
            });
            
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

        let resetForm = () => {
           $("#filter-form")[0].reset();
           $("#max_total_price").val(null);
           $("#min_total_price").val(null);
           $("#qty_to").val(null);
           $("#qty_from").val(null);
           $("#from_date").val(null);
           $("#to_date").val(null);
           $('.select2').val(null).trigger('change');
        }

    </script>
@stop
