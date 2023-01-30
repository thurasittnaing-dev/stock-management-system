@extends('adminlte::page')

@section('title', 'Stocks')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Stocks</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    <div class="container-fluid">
        @php
            $keyword = $_GET['keyword'] ?? '';
            $stock_type_id = $_GET['stock_type'] ?? '';
            $category_id = $_GET['category'] ?? '';
            $brand_id = $_GET['brand'] ?? '';
            $location_id = $_GET['location'] ?? '';
            $condition_id = $_GET['condition'] ?? '';
            $status_id = $_GET['status'] ?? '';
            $from_date = $_GET['from_date'] ?? '';
            $to_date = $_GET['to_date'] ?? '';
            $page = $_GET['page'] ?? 1;
        @endphp
        <div class="my-2 d-flex justify-content-between p-0">

            <div class="col-md-8 p-0">
                <form action="" method="GET">
                    <div class="d-flex">
                        <div class="form-group mr-1 col-md-3 p-0">
                            <input type="text" class="form-control" name="keyword" placeholder="Search..."
                                value="{{ old('keyword', $keyword) }}">
                        </div>
                        <input type="hidden" name="stock_type" value="{{$stock_type_id}}">
                        <input type="hidden" name="category" value="{{$category_id}}">
                        <input type="hidden" name="brand" value="{{$brand_id}}">
                        <input type="hidden" name="location" value="{{$location_id}}">
                        <input type="hidden" name="condition" value="{{$condition_id}}">
                        <input type="hidden" name="status" value="{{$status_id}}">
                        <input type="hidden" name="from_date" value="{{$from_date}}">
                        <input type="hidden" name="to_date" value="{{$to_date}}">

                       <div class="form-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filterModal">
                            <i class="fa-solid fa-filter"></i>
                          </button>
                       </div>
                    </div>
                </form>

                  <!-- Filter Modal -->
                  <div class="modal fade" id="filterModal" role="dialog" aria-labelledby="filterModal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title text-muted">More Filter</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="search-form">
                                <input type="hidden" name="keyword" id="hidden_keyword" value="{{$keyword}}">
                                <div class="row">
                                     {{-- Stock Type --}}
                                    <div class="form-group col-6">
                                        <label class="filter-label">Stock Type</label>
                                        <select name="stock_type" class="form-control select2">
                                            <option value="">--Select--</option>
                                            @forelse (App\Helper::getStockTypes() as $stock_type)
                                            <option {{$stock_type->id == $stock_type_id ? "selected" : "" }} value="{{$stock_type->id}}">{{$stock_type->name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    {{--  Category --}}
                                    <div class="form-group col-6">
                                        <label class="filter-label">Category</label>
                                        <select name="category" class="form-control select2">
                                            <option value="">--Select--</option>
                                            @forelse (App\Helper::getCategories() as $category)
                                            <option {{$category->id == $category_id ? "selected" : "" }} value="{{$category->id}}">{{$category->name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Brand --}}
                                   <div class="form-group col-6">
                                       <label class="filter-label">Brand</label>
                                       <select name="brand" class="form-control select2">
                                           <option value="">--Select--</option>
                                           @forelse (App\Helper::getBrands() as $brand)
                                           <option  {{$brand->id == $brand_id ? "selected" : "" }} value="{{$brand->id}}">{{$brand->name}}</option>
                                           @empty
                                           @endforelse
                                       </select>
                                   </div>
                                   {{--  Location --}}
                                   <div class="form-group col-6">
                                       <label class="filter-label">Location</label>
                                       <select name="location" class="form-control select2">
                                           <option value="">--Select--</option>
                                           @forelse (App\Helper::getLocations() as $location)
                                           <option  {{$location->id == $location_id ? "selected" : "" }} value="{{$location->id}}">{{$location->name}}</option>
                                           @empty
                                           @endforelse
                                       </select>
                                   </div>
                               </div>

                               <div class="row">
                                    {{-- Condition --}}
                                    <div class="form-group col-6">
                                        <label class="filter-label">Condition</label>
                                        <select name="condition" class="form-control select2">
                                                <option value="">--Select--</option>
                                                <option  {{$condition_id == '1' ? "selected" : "" }} value="1">Available</option>
                                                <option  {{$condition_id == '0' ? "selected" : "" }} value="0">Out of stock</option>
                                        </select>
                                    </div>
                                    {{--  Status --}}
                                    <div class="form-group col-6">
                                        <label class="filter-label">Status</label>
                                        <select name="status" class="form-control select2">
                                                <option value="">--Select--</option>
                                                <option  {{$status_id == '1' ? "selected" : "" }} value="1">Active</option>
                                                <option  {{$status_id == '0' ? "selected" : "" }} value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- From Date --}}
                                    <div class="form-group col-6">
                                        <label class="filter-label">From Date</label>
                                        <input type="text" id="from_date" name="from_date" class="form-control" autocomplete="off" placeholder="Select Date" value="{{$from_date}}">
                                    </div>
                                    {{--  To Date --}}
                                    <div class="form-group col-6">
                                        <label class="filter-label">To Date</label>
                                        <input type="text" id="to_date" name="to_date" class="form-control" autocomplete="off" placeholder="Select Date" value="{{$to_date}}">
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="search-btn" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>


            <div class="d-flex">
                <div>
                    <a href="{{ route('stock.create') }}" class="btn btn-primary btn-sm cus-btn">
                        <i class="fas fa fa-plus"></i> {{ __('messages.create_new') }}
                    </a>
                </div>
            </div>


        </div>


        <div class="d-flex my-2">
            {{-- table config --}}
            <div class="d-flex justify-content-start mb-2 mr-2">
                <div class="dropdown">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-eye-slash"></i>
                </button>
                <div class="dropdown-menu" id="tableHeaderMenu">
                    <li class="dropdown-item clickable">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="table_img" value="">
                            <label class="form-check-label">
                                <small>{{ __('messages.table_img') }}</small>
                            </label>
                        </div>
                    </li>
                    <li class="dropdown-item clickable">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="table_name" value="">
                            <label class="form-check-label">
                                <small>{{ __('messages.table_name') }}</small>
                            </label>
                        </div>
                    </li>
                     <li class="dropdown-item clickable">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="table_qty" value="">
                            <label class="form-check-label">
                                <small>{{ __('messages.table_qty') }}</small>
                            </label>
                        </div>
                    </li>
                    <li class="dropdown-item clickable">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="table_location" value="">
                            <label class="form-check-label">
                                <small>{{ __('messages.table_location') }}</small>
                            </label>
                        </div>
                    </li>
                    <li class="dropdown-item clickable">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="table_brand" value="">
                            <label class="form-check-label">
                                <small>{{ __('messages.table_brand') }}</small>
                            </label>
                        </div>
                    </li>
                    <li class="dropdown-item clickable">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="table_category" value="">
                            <label class="form-check-label">
                                <small>{{ __('messages.table_category') }}</small>
                            </label>
                        </div>
                    </li>
                    <li class="dropdown-item clickable">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="table_stock_type" value="">
                            <label class="form-check-label">
                                <small>{{ __('messages.table_stock_type') }}</small>
                            </label>
                        </div>
                    </li>
                    <li class="dropdown-item clickable">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="table_condition" value="">
                            <label class="form-check-label">
                                <small>{{ __('messages.table_condition') }}</small>
                            </label>
                        </div>
                    </li>
                    <li class="dropdown-item clickable">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="table_status" value="">
                            <label class="form-check-label">
                                <small>{{ __('messages.table_status') }}</small>
                            </label>
                        </div>
                    </li>
                    <li class="dropdown-item clickable">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="table_created_at" name="table_created_at" value="">
                            <label class="form-check-label">
                                <small>{{ __('messages.table_created_at') }}</small>
                            </label>
                        </div>
                    </li>
                </div>
                </div>
            </div>


            <div class="mr-1">
                <a href="" id="export-btn" class="btn btn-sm btn-primary"><i class="fas fa-file-excel"></i> Excel Export</a>
            </div>

            <form action="{{route('stock.export')}}" method="POST" id="export-form">
                @csrf
                <input type="hidden" name="keyword" value="{{$keyword}}">
                <input type="hidden" name="stock_type" value="{{$stock_type_id}}">
                <input type="hidden" name="category" value="{{$category_id}}">
                <input type="hidden" name="brand" value="{{$brand_id}}">
                <input type="hidden" name="location" value="{{$location_id}}">
                <input type="hidden" name="condition" value="{{$condition_id}}">
                <input type="hidden" name="status" value="{{$status_id}}">
                <input type="hidden" name="from_date" value="{{$from_date}}">
                <input type="hidden" name="to_date" value="{{$to_date}}">
            </form>
        </div>
        
        <div class="d-flex justify-content-start mb-2">
            <div class="text text-bold">Total : {{$count}}</div>
        </div>
       <div class="table-responsive">
        <table class="table table-bordered table-striped" id="stockTable">
          <thead>
              <tr>
                  <th>#</th>
                  <th class="table_img">{{ __('messages.table_img') }}</th>
                  <th class="table_name">{{ __('messages.table_name') }}</th>
                  <th class="table_stock_type">{{ __('messages.table_stock_type') }}</th>
                  <th class="table_brand">{{ __('messages.table_brand') }}</th>
                  <th class="table_category">{{ __('messages.table_category') }}</th>
                  <th class="table_qty">{{ __('messages.table_qty') }}</th>
                  <th class="table_location">{{ __('messages.table_location') }}</th>
                  <th class="table_condition">{{ __('messages.table_condition') }}</th>
                  <th class="table_status">{{ __('messages.table_status') }}</th>
                  <th class="table_created_at">{{ __('messages.table_created_at') }}</th>
                  <th>Setting</th>
              </tr>
          </thead>
          <tbody>
              @forelse ($stocks as $stock)
                  <tr>
                    <td>{{++$i}}</td>
                    <td>
                        <img src="{{asset('uploads/stocks/'.json_decode($stock->img)[0])}}" class="img-fluid table-img"
                        25
                             data-magnify="gallery"
                        26
                             data-caption="{{$stock->name}}"
                        27
                             data-src="{{asset('uploads/stocks/'.json_decode($stock->img)[0])}}">
                    </td>
                    <td>{{$stock->name}}</td>
                    <td>{{$stock->stock_type->name}}</td>
                    <td>{{$stock->brand->name}}</td>
                    <td>{{$stock->category->name}}</td>
                    <td>{{$stock->qty}}</td>
                    <td>{{$stock->location->name}}</td>
                    <td>
                        @if($stock->qty > 0)
                        <span class="badge badge-success">available</span>
                        @else
                        <span class="badge badge-danger">out of stock</span>
                        @endif
                    </td>
                    <td>
                        @if($stock->status)
                        <span class="badge badge-success">active</span>
                        @else
                        <span class="badge badge-danger">inactive</span>
                        @endif
                    </td>
                    <td>{{date('d-M-Y',strtotime($stock->created_at))}}</td>
                    <td>
                      {{-- hover setting --}}
                      <div class="dropdown">
                        <button class="dropbtn btn btn-primary btn-sm">
                            <i class="fas fa-cog"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href=""><i class="fa-solid fa-cart-shopping" style="color:#1a69ad;"></i>&nbsp;Purchase</a>
                            <a href="" id="delete-btn"><i class="fa-solid fa-box" style="color:#1a69ad;"></i>&nbsp;Withdraw</a>
                            <form action="" method="POST" id="delete-form">
                                @csrf
                                @method('delete')
                              </form>
                        </div>
                    </div>
                    
                    </td>
                  </tr>
              @empty
                  <tr>
                      <td colspan="12" align="center">{{ __('messages.table_no_data') }}</td>
                  </tr>
              @endforelse
          </tbody>
      </table>
       </div>
        {!! $stocks->appends(request()->input())->links() !!}
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('css/jquery.magnify.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/flatpickr.min.css')}}">
    <style>
        .dropbtn {                                                                                                                                                                             border: none;*/
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 150px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
@stop

@section('js')
    <script src="{{asset('js/jquery.magnify.min.js')}}"></script>
    <script src="{{asset('js/flatpickr.min.js')}}"></script>
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


            
            // table header func

            $(function() {
                var chk = $("#tableHeaderMenu input:checkbox");
                var table = $("#stockTable");
                var thead = $("#stockTable th");

                chk.prop('checked', true);

                chk.click(function() {
                    var colToHide = thead.filter("." + $(this).attr("name"));
                    var index = $(colToHide).index();
                    table.find('tr :nth-child(' + (index + 1) + ')').toggle();
                });
            });

            // status change
            $("#status-search").on('change', function() {
                $("#search-form").submit();
            });


            // select2
            $('.select2').select2({
                placeholder: '--Select--', // placeholder
                allowClear: true, // clear btn
                width: '100%', // for specific width
            });


            // datepicker
            $("#from_date").flatpickr({
                dateFormat: "d-m-Y",
            });

             // datepicker
             $("#to_date").flatpickr({
                dateFormat: "d-m-Y",
            });


            // Search Btn
            $("#search-btn").on("click",function(){
                $("#hidden_keyword").val(@json($keyword));
                $("#search-form").submit();
            });


            // excel export btn
            $("#export-btn").on("click",function(e){
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to export excel file?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, export it!'
                    }).then((result) => {
                        console.log(result);
                    if (result.value) {
                        $("#export-form").submit();
                        Swal.fire(
                        'Exported!',
                        'Your file has been exported.',
                        'success'
                        )
                    }
                });
            });


            // Magnify
            $('[data-magnify=gallery]').magnify();

           
        });
    </script>
@stop
