<?php

namespace App;

class Helper
{
  public static function getRedirectURL($page, $url)
  {
    return $page == '1' ? $url : $url . '?page=' . $page;
  }
}