<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->has('roll_number')) {
            return $this->response->redirect('./Stdnavcontroller/');
          } else if ($session->has('username')) {
            return $this->response->redirect('./NavbarController');
          } else {
            echo view('login');
          }
    }
}