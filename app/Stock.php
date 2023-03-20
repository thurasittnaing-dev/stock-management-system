<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Image;

class Stock extends Model
{
    // fillable
    protected $fillable = [
        'name', 'img', 'category_id', 'stock_type_id', 'brand_id', 'location_id', 'qty', 'status', 'opening'
    ];

    // category orm
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    // brand orm
    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    // location orm
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    // stock type orm
    public function stock_type()
    {
        return $this->belongsTo('App\StockType');
    }

    // list data
    public static function list_data($request)
    {
        $stocks = new Stock();
        $stocks = $stocks->with('brand', 'stock_type', 'location', 'category')->orderBy('created_at', 'desc');

        if ($request->keyword != '') {
            $stocks = $stocks->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->stock_type != '') {
            $stocks = $stocks->where('stock_type_id', $request->stock_type);
        }

        if ($request->category != '') {
            $stocks = $stocks->where('category_id', $request->category);
        }
        if ($request->brand != '') {
            $stocks = $stocks->where('brand_id', $request->brand);
        }

        if ($request->location != '') {
            $stocks = $stocks->where('location_id', $request->location);
        }

        if ($request->status != '') {
            $stocks = $stocks->where('status', $request->status);
        }

        if ($request->condition != '') {
            $compression = $request->condition ? '>' : '=';
            $stocks = $stocks->where('qty', $compression, '0');
        }

        if ($request->from_date != '' && $request->to_date != '') {
            $from_date = date('Y-m-d', strtotime($request->from_date));
            $to_date = date('Y-m-d', strtotime($request->to_date));
            $stocks = $stocks->whereBetween('created_at', [$from_date, $to_date]);
        }

        if ($request->from_qty != '' && $request->to_qty != '') {
            $stocks = $stocks->whereBetween('qty', [$request->from_qty, $request->to_qty]);
        }

        return $stocks;
    }

    // Store Data
    public static function store_data($request)
    {
        $fileNameArray = [];
        if ($request->hasFile('stock_img')) {
            $files = $request->file('stock_img');
            $destionation_path = public_path() . '/uploads/stocks/';

            // image upload
            foreach ($files as $file) {
                $ext =  $file->getClientOriginalExtension();
                $filename = 'img_' . Carbon::now()->timestamp . '.' . $ext;

                // resize
                $image = Image::make($file->path());
                $image->encode('jpg', 75)->save($destionation_path . '/' . $filename);

                array_push($fileNameArray, $filename);
            }
        }

        $jsonFileName = json_encode($fileNameArray);

        // Handle Brand  
        if (!is_numeric($request->brand)) {

            $brand = new Brand();
            $brand = $brand->where('name', $request->brand);

            //  check already exits
            if ($brand->count() > 0) {
                $brandId = $brand->first()->id;
            } else {
                $brand = Brand::create([
                    'name' => $request->brand,
                ]);
                $brandId = $brand->id;
            }
        }

        // Handle Stock Type  
        if (!is_numeric($request->stock_type)) {

            $stock_type = new StockType();
            $stock_type = $stock_type->where('name', $request->stock_type);

            //  check already exits
            if ($stock_type->count() > 0) {
                $stocktypeId = $stock_type->first()->id;
            } else {
                $stock_type = StockType::create([
                    'name' => $request->stock_type,
                ]);
                $stocktypeId = $stock_type->id;
            }
        }

        // Handle category 
        if (!is_numeric($request->category)) {

            $category = new Category();
            $category = $category->where('name', $request->category);

            //  check already exits
            if ($category->count() > 0) {
                $categoryId = $category->first()->id;
            } else {
                $category = Category::create([
                    'name' => $request->category,
                ]);
                $categoryId = $category->id;
            }
        }

        // Handle location 
        if (!is_numeric($request->location)) {

            $location = new Location();
            $location = $location->where('name', $request->location);

            //  check already exits
            if ($location->count() > 0) {
                $locationId = $location->first()->id;
            } else {
                $location = Location::create([
                    'name' => $request->location,
                ]);
                $locationId = $location->id;
            }
        }

        Stock::create([
            'name' => $request->name,
            'img' => $jsonFileName,
            'stock_type_id' => $stocktypeId ?? $request->stock_type,
            'brand_id' => $brandId ?? $request->brand,
            'category_id' => $categoryId ?? $request->category,
            'opening' => $request->opening,
            'qty' => $request->opening,
            'location_id' => $locationId ?? $request->location,
        ]);
    }

    public static function update_data($request, $stock)
    {
        // dd($request->all());
        $fileNameArray = [];
        $fileName = $request->old_filename;

        if ($request->hasFile('stock_img')) {
            $files = $request->file('stock_img');
            $destionation_path = public_path() . '/uploads/stocks/';
            // image upload
            foreach ($files as $file) {
                $ext =  $file->getClientOriginalExtension();
                $filename = 'img_' . Carbon::now()->timestamp . '.' . $ext;

                // resize
                $image = Image::make($file->path());
                $image->encode('jpg', 75)->save($destionation_path . '/' . $filename);
                array_push($fileNameArray, $filename);
            }

            $fileName = json_encode($fileNameArray);

            // delete
            if (file_exists($destionation_path . $request->old_filename)) {
                unlink($destionation_path  .  $request->old_filename);
            }
        } else {
            $fileName = json_encode([$fileName]);
        }


        // Handle Stock Type  
        if (!is_numeric($request->stock_type)) {

            $stock_type = new StockType();
            $stock_type = $stock_type->where('name', $request->stock_type);

            //  check already exits
            if ($stock_type->count() > 0) {
                $stocktypeId = $stock_type->first()->id;
            } else {
                $stock_type = StockType::create([
                    'name' => $request->stock_type,
                ]);
                $stocktypeId = $stock_type->id;
            }
        }

        // Handle category 
        if (!is_numeric($request->category)) {

            $category = new Category();
            $category = $category->where('name', $request->category);

            //  check already exits
            if ($category->count() > 0) {
                $categoryId = $category->first()->id;
            } else {
                $category = Category::create([
                    'name' => $request->category,
                ]);
                $categoryId = $category->id;
            }
        }

        // Handle location 
        if (!is_numeric($request->location)) {

            $location = new Location();
            $location = $location->where('name', $request->location);

            //  check already exits
            if ($location->count() > 0) {
                $locationId = $location->first()->id;
            } else {
                $location = Location::create([
                    'name' => $request->location,
                ]);
                $locationId = $location->id;
            }
        }



        // Update
        $stock->update([
            'name' => $request->name,
            'img' => $fileName,
            'stock_type_id' => $stocktypeId ?? $request->stock_type,
            'brand_id' => $brandId ?? $request->brand,
            'category_id' => $categoryId ?? $request->category,
            'opening' => $request->opening,
            'qty' => $request->qty,
            'status' => $request->status,
            'location_id' => $locationId ?? $request->location,
        ]);
    }
}