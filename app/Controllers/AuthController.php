<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\StudentModel;

class AuthController extends BaseController
{
  public function index()
  {
    $session = session();
    if ($session->has('roll_number')) {
      return $this->response->redirect('../Stdnavcontroller/');
    } else if ($session->has('username')) {
      return $this->response->redirect('./NavbarController');
    } else {
      echo view('login');
    }
  }

  public function login()
  {
    $session = session();

    if ($session->has('roll_number')) {
      return $this->response->redirect('../Stdnavcontroller/');
    }

    if (!$session->has('username')) {
      $username = $this->request->getPost('username');
      $password = (string)$this->request->getPost('password');


      $userModel = new UserModel();
      $users = $userModel->where('username', $username)->first();

      $studentModel = new StudentModel();
      $stu_check = $studentModel->checkStudent($username);

      if ($users && $users['password'] === md5($password)) {
        $ses_data = ['username' => $username];
        // $session->destroy();
        // $session=session();
        $session->set($ses_data);
        return $this->response->redirect('../NavbarController/');
      } else if ($stu_check == 1 && $username == $password) {
        $ses_data = ['roll_number' => $username];
        // $session->destroy();
        // $session=session();
        $session->set($ses_data);
        return $this->response->redirect('../Stdnavcontroller/');
      } else {
        $data['error'] = 'Invalid username or password.';
        return view('login', $data);
      }
    } else {
      return $this->response->redirect('./NavbarController/');
    }
  }


  public function logout()
  {
    $session = session();
    $session->destroy();
    return redirect()->route('/');
  }
}
