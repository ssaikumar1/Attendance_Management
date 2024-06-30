<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\StudentModel;

class Stdnavcontroller extends Controller
{
    private function year($sem){
        if($sem=='1' || $sem=='2'){
            return "I";
        }else if($sem=='3' || $sem=='4'){
            return "II";
        }else if($sem=='5' || $sem=='6'){
            return "III";
        }else{
            return "IV";
        }
    }

    public function index()
    {
        $session = session();
        if (!$session->has('roll_number')) {
            return redirect()->to('/');
        }
        $StudentModel = new StudentModel();
        $details=$StudentModel->getDetails($session->get('roll_number'))[0];
        $data=array("roll_number"=>$session->get('roll_number'),"name"=>$details['name']);
        $data['lastTen']=$StudentModel->getLastTenDaysAttendance($session->get('roll_number'));
        return view('stdnav',$data);
    }

    public function certainDate(){
        $session = session();
        if (!$session->has('roll_number')) {
            return redirect()->to('/');
        }
        $StudentModel = new StudentModel();
        $date=$this->request->getPost('date');
        $arr=$StudentModel->getDayAttendance($session->get('roll_number'),$date);
        if(count($arr)>0){
            $str="<b class='text-".(($arr[0]['status']=='P')?"success":"danger")."'>".date("F jS, Y", strtotime($date))." - ".(($arr[0]['status']=='P')?"Present":"Absent")."</b>";
            echo json_encode(array("data"=>$str));
        }else{
            echo json_encode(array("data"=>"<b class='text-secondary'>".date("F jS, Y", strtotime($date))." - No Attendance Available"));
        }
    }

    public function overall_summary(){
        $session = session();
        if (!$session->has('roll_number')) {
            return redirect()->to('/');
        }
        $StudentModel = new StudentModel();
        $details=$StudentModel->getDetails($session->get('roll_number'))[0];
        $data=array("roll_number"=>$session->get('roll_number'),"name"=>$details['name']);
        return view('std_summary',$data);
    }

    public function summary()
    {
        $session = session();
        
        if (!$session->has('roll_number')) {
            return redirect()->to('/');
        }
        $date = $this->request->getPost('date');
        $todate = $this->request->getPost('todate');
        if ($date < $todate) {
            $start_date = $date;
            $end_date = $todate;
        } else if ($date > $todate) {
            $start_date = $todate;
            $end_date = $date;
        } else {
            $start_date = $date;
            $end_date = $date;
        }
        $StudentModel = new StudentModel();
        $result = $StudentModel->get_ranged_data($session->get('roll_number'), $start_date, $end_date);
        echo json_encode($result);
    }

    public function processStudents(){
        $this->auth();
        $selectedStudents = $this->request->getPost('students');
        $branch = $this->request->getPost('branch');
        $sem = $this->request->getPost('sem');
        $sec = $this->request->getPost('sec');
        $ClassesModel = new ClassesModel();
        $result=$ClassesModel->reset_Attendance($branch,$sec,$sem);
        $alert='fail';
        if($result){
            $result=$ClassesModel->insert_Attendance($selectedStudents);
            if($result){
                $alert='success';
            }
        }
        $this->response->redirect('../NavbarController?branch='.$branch.'&sec='.$sec.'&sem='.$sem.'&alert='.$alert);
    }

    public function get_day_summary(){
        $mode=$this->request->getPost('mode');
        $branch=$this->request->getPost('branch');
        $sec=$this->request->getPost('sec');
        $sem=$this->request->getPost('sem');
        $date=$this->request->getPost('date');
        $ClassesModel = new ClassesModel();
        if($mode=='absent_students'){
            $result = $ClassesModel->get_absent_stds($branch,$sec,$sem,$date);
            echo json_encode($result);
        }
        else{
            $result = $ClassesModel->get_present_stds($branch,$sec,$sem,$date);
            echo json_encode($result);
        }
    }

    public function index2()
    {
        
        $this->auth();

        $ClassesModel = new ClassesModel();

        $result=$ClassesModel->get_classes();
        $data['classes']=array();
        foreach($result as $r){
            array_push($data['classes'],[$this->year($r['sem']),$r['branch'],$r['sec'],$r['sem']]);
        }

        $data['branches']=array();
        $branch=$ClassesModel->get_branches();
        foreach($branch as $b){
            array_push($data['branches'],$b['branch']);
        }
        $data['sems']=array();
        $branch=$ClassesModel->get_sems();
        foreach($branch as $b){
            array_push($data['sems'],$b['sem']);
        }
        $data['secs']=array();
        $branch=$ClassesModel->get_secs();
        foreach($branch as $b){
            array_push($data['secs'],$b['sec']);
        }
        $data['mode']='absent_students';

        return view('day_summary',$data);
    }

    public function index22()
    {
        
        $this->auth();

        $ClassesModel = new ClassesModel();

        $result=$ClassesModel->get_classes();
        $data['classes']=array();
        foreach($result as $r){
            array_push($data['classes'],[$this->year($r['sem']),$r['branch'],$r['sec'],$r['sem']]);
        }

        $data['branches']=array();
        $branch=$ClassesModel->get_branches();
        foreach($branch as $b){
            array_push($data['branches'],$b['branch']);
        }
        $data['sems']=array();
        $branch=$ClassesModel->get_sems();
        foreach($branch as $b){
            array_push($data['sems'],$b['sem']);
        }
        $data['secs']=array();
        $branch=$ClassesModel->get_secs();
        foreach($branch as $b){
            array_push($data['secs'],$b['sec']);
        }
        $data['mode']='present_students';

        return view('day_summary',$data);
    }


    public function index3()
    {
         
        $this->auth();

        $ClassesModel = new ClassesModel();

        $result=$ClassesModel->get_classes();
        $data['classes']=array();
        foreach($result as $r){
            array_push($data['classes'],[$this->year($r['sem']),$r['branch'],$r['sec'],$r['sem']]);
        }

        $data['branches']=array();
        $branch=$ClassesModel->get_branches();
        foreach($branch as $b){
            array_push($data['branches'],$b['branch']);
        }
        $data['sems']=array();
        $branch=$ClassesModel->get_sems();
        foreach($branch as $b){
            array_push($data['sems'],$b['sem']);
        }
        $data['secs']=array();
        $branch=$ClassesModel->get_secs();
        foreach($branch as $b){
            array_push($data['secs'],$b['sec']);
        }
        $data['mode']='present_students';

        return view('summary',$data);
    }
    

    
    public function index4()
    {
        $this->auth();
        return view('logout');
    }
}
