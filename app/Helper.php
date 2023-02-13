<?php

namespace App;

use App\StockType;
use App\Category;
use App\Brand;
use Illuminate\Support\Facades\DB;

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

  // Get Role
  public static function getRoles()
  {
    return DB::table('roles')->orderBy('created_at', 'asc')->get();
  }

  // isHasRole
  public static function isHasRole($role_id, $permission)
  {
    $permission = DB::table('permissions')->where('name', $permission)->first();
    $permission_id = $permission->id;

    $check = DB::table('role_has_permissions')->where('role_id', $role_id)->where('permission_id', $permission_id)->count();

    return $check > 0 ? true : false;
  }

  // Get Total Permission Count
  public static function getTotalPermissionCount($role_id)
  {
    return DB::table('role_has_permissions')->where('role_id', $role_id)->count();
  }

  // Get User Count
  public static function getUserCount($role_id)
  {
    return DB::table('model_has_roles')->where('role_id', $role_id)->count();
  }

  // Is User Has Role
  public static function isUserHasRole($user_id, $role_id)
  {
    $count = DB::table('model_has_roles')->where('role_id', $role_id)->where('model_id', $user_id)->count();
    return $count > 0 ? true : false;
  }
}