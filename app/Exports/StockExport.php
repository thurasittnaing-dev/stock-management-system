<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Stock;

class StockExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        // prepare
        $keyword = $_POST['keyword'] ?? '';
        $stock_type = $_POST['stock_type'] ?? '';
        $category = $_POST['category'] ?? '';
        $brand = $_POST['brand'] ?? '';
        $location = $_POST['location'] ?? '';
        $condition = $_POST['condition'] ?? '';
        $status = $_POST['status'] ?? '';
        $from_date = $_POST['from_date'] ?? '';
        $to_date = $_POST['to_date'] ?? '';

        // Start Query
        $stocks = new Stock();
        $stocks = $stocks->with('brand', 'stock_type', 'location', 'category')->orderBy('created_at', 'desc');

        if ($keyword != '') {
            $stocks = $stocks->where('name', 'LIKE', '%' . $keyword . '%');
        }

        if ($stock_type != '') {
            $stocks = $stocks->where('stock_type_id', $stock_type);
        }

        if ($category != '') {
            $stocks = $stocks->where('category_id', $category);
        }
        if ($brand != '') {
            $stocks = $stocks->where('brand_id', $brand);
        }

        if ($location != '') {
            $stocks = $stocks->where('location_id', $location);
        }

        if ($status != '') {
            $stocks = $stocks->where('status', $status);
        }

        if ($condition != '') {
            $compression = $condition ? '>' : '=';
            $stocks = $stocks->where('qty', $compression, '0');
        }

        if ($from_date != '' && $to_date != '') {
            $from_date = date('Y-m-d', strtotime($from_date));
            $to_date = date('Y-m-d', strtotime($to_date));
            $stocks = $stocks->whereBetween('created_at', [$from_date, $to_date]);
        }

        $stocks = $stocks->get();

        return view('backend.stock.export', compact('stocks'));
    }
}