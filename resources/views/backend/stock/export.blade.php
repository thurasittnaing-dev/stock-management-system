<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Stock Export</title>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Image</th>
        <th>Name</th>
        <th>Stock Type</th>
        <th>Brand</th>
        <th>Category</th>
        <th>Qty</th>
        <th>Location</th>
        <th>Condition</th>
        <th>Status</th>
        <th>Created at</th>
      </tr>
    </thead>
    <tbody>
      @php
          $i = 0;
      @endphp
      @forelse ($stocks as $stock)
          <tr>
            <td>{{++$i}}</td>
            <td>
                {{-- <img class="img-fluid table-img" src="{{asset('uploads/stocks/'.json_decode($stock->img)[0])}}" alt="" style="width: 50px"> --}}
                <img src="{{public_path('uploads/stocks/'.json_decode($stock->img)[0])}}" alt="" style="width: 25px" height="25px">
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
          </tr>
      @empty
          <tr>
              <td colspan="12" align="center">There is no data</td>
          </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>