<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandStoreRequest;
use App\Helper;
use App\Http\Requests\BrandUpdateRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $brands = new Brand();

        if ($request->keyword != '') {
            $brands = $brands->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->status != '') {
            $brands = $brands->where('status', $request->status);
        }

        $count = $brands->count();
        $brands = $brands->orderBy('created_at', 'desc')->paginate(10);
        return view('backend.brand.index', compact('count', 'brands'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandStoreRequest $request)
    {
        //
        Brand::store_data($request);

        return redirect()->route('brand.index')->with('success', 'Created successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $brand = Brand::findorfail($id);
        return view('backend.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandUpdateRequest $request, brand $brand)
    {
        //
        Brand::update_data($brand, $request);

        $url = Helper::getRedirectURL($request->page, 'admin/brand');

        return redirect($url)->with('success', 'Updated successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(brand $brand)
    {
        //
        $brand->delete();
        return redirect()->route('brand.index')->with('success', 'Deleted successful');
    }
}