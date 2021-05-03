<?php

namespace App\Controllers;

use App\Models\User as UserModel;

class User extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'User',
      'heading' => 'User',
      'page_name' => 'user',
    ];

    return view('user/index', $data);
  }

  public function get_all()
  {
    /**
     * @var \Config\Services::request() $request Incoming request
     */
    $request = $this->request;

    $limit = (int) $request->getVar('limit');
    $offset = (int) $request->getVar('offset');
    $orderBy = $request->getVar('order');
    $dir = $request->getVar('dir');
    $keyword = $request->getVar('search');
    $keyword = $keyword ? $keyword : '';

    $builder = $this->db->table('user');

    $userData = $builder
      ->orderBy($orderBy ? $orderBy : '', $dir ? $dir : '')
      ->like('nama', $keyword)
      ->orLike('username', $keyword)
      ->get($limit, $offset)
      ->getResult();
    $dataSize = sizeof($userData);
    $allResults = $builder->countAllResults();

    // we need to do this do gridjs knows the actual count after we
    // do something like `search`
    $userTotal =
      $dataSize == 0 ? 0 : ($keyword == null ? $allResults : $dataSize);

    $response = service('response');
    $response->setHeader('Content-Type', 'application/json');
    $response->setBody(
      json_encode([
        'results' => $userData,
        'count' => $userTotal,
      ])
    );
    $response->send();
  }
}
