<?php

namespace App;

use App\StockType;
use App\Category;
use App\Brand;

class Helper
{
  // Get Redirect URL
  public static function getRedirectURL($page, $url)
  {
    return $page == '1' ? $url : $url . '?page=' . $page;
  }

  // Get Stock Types
  public static function getStockTypes()
  {
    return StockType::where('status', 1)->orderBy('created_at', 'desc')->get();
  }

  // Get Brands
  public static function getBrands()
  {
    return Brand::where('status', 1)->orderBy('created_at', 'desc')->get();
  }

  // Get Categories
  public static function getCategories()
  {
    return Category::where('status', 1)->orderBy('created_at', 'desc')->get();
  }

  // Get Locations
  public static function getLocations()
  {
    return Location::where('status', 1)->orderBy('created_at', 'asc')->get();
  }
}