@extends('adminlte::page')

@section('title', 'Withdraw History')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Withdraw History</li>
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
                $withdrawer_id = $_GET['withdrawer_id'] ?? '';
                $qty_from = $_GET['qty_from'] ?? '';
                $qty_to = $_GET['qty_to'] ?? '';
                $from_date = $_GET['from_date'] ?? '';
                $to_date = $_GET['to_date'] ?? '';
                $withdraw_type = $_GET['withdraw_type'] ?? '';
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
                                    <label>Withdrawer</label>
                                    <select name="withdrawer_id" class="form-control select2">
                                        <option value="">--Select--</option>
                                        @forelse (App\Helper::getWithdrawers() as $withdrawer)
                                        <option {{$withdrawer->id == $withdrawer_id ? "selected" : "" }} value="{{$withdrawer->id}}">{{$withdrawer->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Withdraw Type</label>
                                    <select name="withdraw_type" id="" class="form-control">
                                      <option value="borrow">Borrow</option>
                                      <option value="permanent">Permanent</option>
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
            <div class="text-muted fw-bold">Total Withdraw: {{$count}}</div>
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
                    <th>Withdrawer</th>
                    <th>Qty</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Remark</th>
                    <th>Approve</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($withdraw_histories as $history)
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
                    <td>{{$history->withdrawer_name}}</td>
                    <td>{{$history->qty}}</td>
                    <td>
                        <div>{{date('d-m-Y',strtotime($history->date))}}</div>
                        <small class="badge badge-sm badge-info">{{ date('l', strtotime($history->date))}}</small>
                    </td>
                    <td>
                      @if ($history->withdraw_type == "permanent")
                          <span class="badge badge-success">Permanent</span>
                      @else
                      <span class="badge badge-warning">Borrow</span>
                      @endif
                    </td>
                    <td>{{$history->remark}}</td>
                    <td>{{$history->approve_by}}</td>
                    <td>
                      @if ($history->status)
                      <span class="badge badge-success">Completed</span>
                      @else 
                      <button type="button" data-toggle="modal" data-target="#returnModal{{$history->id}}" class="btn btn-sm btn-primary">Put Back</button>
                      <!-- Return  Modal -->
                      <div class="modal fade" id="returnModal{{$history->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <form action="" method="POST" autocomplete="off">
                              @csrf 
                              @method('POST')
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Stock Return</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                               <div class="row">
                                <div class="form-group col-md-6">
                                  <label>Date</label>
                                  <input type="text" name="date" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                  <label>Qty</label>
                                  <input type="number" name="qty" class="form-control">
                                </div>
                               </div>
                               <div class="row">
                                <div class="form-check col-md-6 ml-2">
                                  <input class="form-check-input" name="is_damaged" id="is_damaged" type="checkbox" value="">
                                  <label class="form-check-label" for="is_damaged">
                                    Is Damaged
                                  </label>
                                </div>
                               </div>

                               <div class="row"></div>

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save Changes</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
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
        {!! $withdraw_histories->appends(request()->input())->links() !!}
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

        $("#is_damaged").on("change",function(){
          if($(this).prop('checked')) {
            $("#damage_form").show();
          }
        });

    </script>
@stop
