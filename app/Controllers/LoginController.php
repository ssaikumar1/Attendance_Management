<?php

namespace App\Controllers;

use App\Models\UserModel;
class LoginController extends BaseController
{
  public function index()
  {
    $session=session();
    if(!$session->has('username')){
      echo view('stdlogin');
    }
    else{
      return $this->response->redirect('Stdnavcontroller');
    }
  //   session_start();
  //   global $_SESSION;
  //   if(!isset($_SESSION['username'])){
  //   echo view('stdlogin');
  // }else{
  //   return $this->response->redirect('./Stdnavcontroller');
  // }
  }

  public function login()
  {
    session_start();
    global $_SESSION;

    if(!isset($_SESSION['username'])){
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    
      $userModel = new UserModel();
      $users = $userModel->where('username', $username)->first();

      if ($users && $users['password'] === md5($password)) {
        $_SESSION['username']=$username;
        echo var_dump($_SESSION);
        return $this->response->redirect('Stdnavcontroller');
      } else {
        $data['error'] = 'Invalid username or password.';
        return view('stdlogin', $data);
      }
}else{
  return $this->response->redirect('Stdnavcontroller');
}
  }


  public function logout(){
    session_start();   
    global $_SESSION;
    unset($_SESSION);
    session_destroy();
    return redirect()->route('/');
  }

  
}
