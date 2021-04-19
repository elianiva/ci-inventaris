<?php

namespace App\Libraries;

class Modal
{
  public static function getModal(array $params)
  {
    $data = [
      "item_name" => $params['item_name'],
    ];

    return view("partials/modal", $data);
  }
}

