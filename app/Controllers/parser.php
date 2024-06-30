<?php
namespace App\Controllers;
use CodeIgniter\Controller;
class Parser extends Controller{
public function index(){
    $parser=\config\Services::parser();
    $data=[
        'title'=>'view parser',
        'heading'=>'coideig view parser',
    ];
    $parser->setdata($data);
    return $parser->render("view parser");
}
}