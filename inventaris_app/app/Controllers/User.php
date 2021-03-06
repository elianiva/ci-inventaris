<?php

namespace App\Controllers;

use App\Models\User as UserModel;

class User extends BaseController
{
  public function index()
  {
    $data = [
      'title'     => 'User',
      'heading'   => 'User',
      'page_name' => 'user',
    ];

    return view('user/index', $data);
  }

  public function form(string $id = null)
  {
    $userModel = new UserModel();
    $prev = $id ? $userModel->find($id) : null;

    $data = [
      'title'      => 'User',
      'heading'    => 'User',
      'page_name'  => 'user',
      'title'      => $id ? 'Edit' : 'Tambah',
      'validation' => $this->validator,
      'prev'       => $prev
    ];

    return view('user/form', $data);
  }

  public function save(string $id = null)
  {
    /**
     * @var \Config\Services::request() $request Incoming request
     */
    $request = $this->request;

    $rules = [
      'name' => [
        'label' => 'Nama',
        'rules' => 'trim|required|is_unique[user.nama,id_user,{id_user}]',
      ],
      'username' => [
        'label' => 'Username',
        'rules' => 'trim|required|is_unique[user.username,id_user,{id_user}]',
      ],
      'password' => [
        'label' => 'Password',
        'rules' => $id ? 'trim' : 'trim|required|min_length[8]',
      ],
      'password-rep' => [
        'label' => 'Ulangi Password',
        'rules' => $id
          ? 'trim|matches[password]'
          : 'trim|required|matches[password]',
      ],
    ];

    $errors = [
      'name' => [
        'required' => 'Nama tidak boleh kosong!',
        'is_unique' => 'Nama sudah terdaftar!',
      ],
      'username' => [
        'required' => 'Username tidak boleh kosong!',
        'is_unique' => 'Username sudah terdaftar!',
      ],
      'password' => [
        'required' => 'Password tidak boleh kosong!',
        'min_length' => 'Panjang minimal password adalah 8 karakter!',
      ],
      'password-rep' => [
        'required' => 'Password tidak boleh kosong!',
        'matches' => 'Password tidak sama!',
      ],
    ];

    if (!$this->validate($rules, $errors)) {
      $this->session->setFlashData('errors', $this->validator->getErrors());
      return redirect()
        ->to('/user' . $id ? '/edit/' . $id : '/tambah')
        ->withInput();
    }

    $userModel = new UserModel();
    $name = $request->getVar('name');
    $username = $request->getVar('username');
    $password = $request->getVar('password');
    $level = $request->getVar('level');
    $old = $userModel->find($id);

    $userModel->save([
      'id_user'  => $id,
      'nama'     => $name,
      'username' => $username,
      'password' => $id ? $old['password'] : password_hash($password, PASSWORD_BCRYPT),
      'level'    => $level,
    ]);

    $this->session->setFlashData(
      'message',
      sprintf(
        "User bernama '$name' telah berhasil %s!",
        $id ? 'diperbarui' : 'ditambahkan'
      )
    );

    return redirect()->to('/user');
  }

  public function hapus(string $id)
  {
    $userModel = new UserModel();
    $nama = $userModel->find($id)['nama'];
    $userModel->delete($id);

    $this->session->setFlashData(
      'message',
      "User bernama '$nama' telah berhasil dihapus!"
    );

    return redirect()->to('/user');
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

    // we need to do this to let gridjs knows the actual count after we
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
