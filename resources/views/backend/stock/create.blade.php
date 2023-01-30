@extends('adminlte::page')

@section('title', 'Stock Create')

@section('content_header')
    {{-- Breadcrum Start --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('stock.index') }}">Stocks</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
    {{-- Breadcrum End --}}
@stop

@section('content')
    <div class="container-fluid">
      <div class="card p-4">
        <h4 class="text-muted font-weight-bold mb-3">Insert New Stock</h4>
        <form action="{{route('stock.store')}}" method="POST" autocomplete="off" enctype="multipart/form-data">
          @csrf
          <div class="form-row mt-3">
            <div class="col-md-6">
              <div class="form-group col-md-8">
                <label for="name">Stock Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter a name..." value="{{old('name')}}">
                @error('name')
                <div class="text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
           
            <div class="col-md-6">
              <div class="form-group col-md-8">
                <label for="stock_type">Stock Type</label>
                <select name="stock_type" id="stock_type" class="form-control  @error('stock_type')is-invalid @enderror">
                  <option value="">--Select--</option>
                  @forelse( App\Helper::getStockTypes() as $stock_type)
                  <option value="{{$stock_type->id}}">{{$stock_type->name}}</option>
                  @empty
                  @endforelse
                </select>
                @error('stock_type')
                <div class="text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="form-row mt-3">
            <div class="col-md-6">
              <div class="form-group col-md-8">
                <label for="brand">Brand</label>
                <select name="brand" id="brand" class="form-control  @error('brand') is-invalid @enderror">
                  <option value="">--Select--</option>
                  @forelse( App\Helper::getBrands() as $brand)
                  <option value="{{$brand->id}}">{{$brand->name}}</option>
                  @empty
                  @endforelse
                </select>
                @error('brand')
                <div class="text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group col-md-8">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control  @error('category') is-invalid @enderror">
                  <option value="">--Select--</option>
                  @forelse( App\Helper::getCategories() as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                  @empty
                  @endforelse
                </select>
                @error('category')
                <div class="text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
          </div>
          
          <div class="form-row mt-3">
            <div class="col-md-6">
              <div class="form-group col-md-8">
                <label for="opening">Opening</label>
                <input type="number" name="opening" id="opening" value="0" class="form-control">
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group col-md-8">
                <label for="location">Location</label>
                <select name="location" id="location" class="form-control  @error('location') is-invalid @enderror">
                  <option value="">--Select--</option>
                  @forelse( App\Helper::getLocations() as $location)
                  <option value="{{$location->id}}">{{$location->name}}</option>
                  @empty
                  @endforelse
                </select>
                @error('location')
                <div class="text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-row mt-3">
            <div class="col-md-6">
              <div class="form-group col-md-8" id="image-container">
                <label for="image">Stock Image</label>
                <div class="my-3 d-flex">
                  <input type="file" name="stock_img[]" id="image" class="form-control-file  @error('stock_img') is-invalid @enderror">
                  <button type="button" class="btn btn-sm btn-success" id="add-image-form"><i class="fas fa fa-plus"></i></button>
                </div>
                @error('stock_img')
                <div class="text-danger">{{$message}}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mt-2  col-md-8 d-flex justify-content-end">
                <a href="{{route('stock.index')}}" class="btn btn-sm btn-primary mr-2">Go Back</a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa-solid fa-floppy-disk"></i> {{ __('messages.save') }} </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
@stop

@section('css')
    <style></style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>  
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


            // stock type
            $('#stock_type').select2({
                placeholder: '--Select--', // placeholder
                allowClear: true, // clear btn
                tags:true, //allow custom value
                width: '100%', // for specific width
            });
            $("#stock_type").val('{{old('stock_type')}}').trigger('change');
        
             // brand
             $('#brand').select2({
                placeholder: '--Select--', // placeholder
                allowClear: true, // clear btn
                tags:true, //allow custom value
                width: '100%', // for specific width
            });
            $("#brand").val('{{old('brand')}}').trigger('change');

             // category
             $('#category').select2({
                placeholder: '--Select--', // placeholder
                allowClear: true, // clear btn
                tags:true, //allow custom value
                width: '100%', // for specific width
            });
            $("#category").val('{{old('category')}}').trigger('change');

             // location
             $('#location').select2({
                placeholder: '--Select--', // placeholder
                allowClear: true, // clear btn
                tags:true, //allow custom value
                width: '100%', // for specific width
            });
            $("#location").val('{{old('location')}}').trigger('change');


            // add new btn function
            let i = 1;
            $("#add-image-form").on('click',function(){
             
              if(i >= 5) {
                return false;
              }else {
                i++;
              }

              // element
              let btnElement = `
                  <div class="my-3 d-flex" id="file-btn-${i}">
                    <input type="file" name="stock_img[]" id="image${i}" class="form-control-file">
                    <button type="button" data-id="${i}" class="btn btn-sm btn-danger rmbtn"><i class="fas fa fa-minus"></i></button>
                  </div>
                  `;
                  $("#image-container").append(btnElement);
            });

            $("#image-container").on("click", '.rmbtn', function(){
                i -= 1;
                let id = $(this).data('id');
                $(`#file-btn-${id}`).remove();
            });

        });
    </script>
@stop
