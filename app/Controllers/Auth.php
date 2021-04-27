<?php

namespace App\Controllers;

class Auth extends BaseController
{
  public function login()
  {
    $data = [
      "title" => "Supplier | Inventaris",
      "heading" => "Supplier",
      "page_name" => "supplier",
    ];

    return view("auth/login", $data);
  }
}
