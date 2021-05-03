<?php

namespace App\Controllers;

class Auth extends BaseController
{
  public function index()
  {
    return view('auth/login');
  }

  public function login()
  {
    /**
     * @var \Config\Services::request() $request Incoming request
     */
    $request = $this->request;

    $rules = [
      'username' => [
        'label' => 'Username',
        'rules' => 'required',
      ],
      'password' => [
        'label' => 'Password',
        'rules' => 'required',
      ],
    ];

    $errors = [
      'username' => [
        'required' => 'Username tidak boleh kosong!',
      ],
      'password' => [
        'required' => 'Password tidak boleh kosong!',
      ],
    ];

    if (!$this->validate($rules, $errors)) {
      $this->session->setFlashData('errors', $this->validator->getErrors());
      return redirect()
        ->to('/auth')
        ->withInput();
    }

    $username = $request->getVar('username');
    $password = $request->getVar('password');

    $builder = $this->db->table('user');

    $user = $builder
      ->select('nama, username, password, level')
      ->where('username', $username)
      ->get(1)
      ->getResult();

    if (!$user) {
      $this->session->setFlashData('message', 'User tidak ditemukan!');
      /* prettier-ignore */
      return redirect()->withInput()->to('/auth');
    }

    $isValid = password_verify($password, $user[0]->password);

    if (!$isValid) {
      $this->session->setFlashData(
        'message',
        'Password yang anda masukkan salah!',
      );
      return redirect()
        ->withInput()
        ->to('/auth');
    }

    $this->session->set('current_user', [
      'name' => $user[0]->nama,
      'username' => $user[0]->username,
      'level' => $user[0]->level,
    ]);

    return redirect()->to('/dashboard');
  }

  public function logout()
  {
    $this->session->destroy();
    return redirect()->to('/auth');
  }
}
