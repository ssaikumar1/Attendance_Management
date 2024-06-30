<?php



namespace App\Controllers;



use CodeIgniter\Controller;

use App\Models\ClassesModel;



class NavbarController extends Controller

{

    private function year($sem)

    {

        if ($sem == '1' || $sem == '2') {

            return "I";
        } else if ($sem == '3' || $sem == '4') {

            return "II";
        } else if ($sem == '5' || $sem == '6') {

            return "III";
        } else {

            return "IV";
        }
    }



    public function index()

    {

        $session = session();

        if (!$session->has('username')) {

            return redirect()->to('/');
        }

        global $_GET;

        $ClassesModel = new ClassesModel();



        $result = $ClassesModel->get_classes();

        $data['classes'] = array();

        foreach ($result as $r) {

            array_push($data['classes'], [$this->year($r['sem']), $r['branch'], $r['sec'], $r['sem']]);
        }

        if (isset($_GET['branch']) && isset($_GET['sec']) && isset($_GET['sem'])) {

            if (isset($_GET['alert'])) {

                $data['alert'] = $_GET['alert'];
            }

            $data['branch'] = $_GET['branch'];

            $data['sem'] = $_GET['sem'];

            $data['sec'] = $_GET['sec'];

            $data['students'] = $ClassesModel->get_students($_GET['branch'], $_GET['sec'], $_GET['sem']);

            $result = $ClassesModel->get_absent_students($_GET['branch'], $_GET['sec'], $_GET['sem']);

            $data['absent_students'] = array();

            foreach ($result as $r) {

                array_push($data['absent_students'], $r['roll_number']);
            }
        }



        return view('navbar', $data);
    }



    public function processStudents()

    {

        $session = session();



        if (!$session->has('username')) {

            // redirect('/', 'refresh');

            // echo "";



            return redirect()->to('/');
        }

        $selectedStudents = $this->request->getPost('students');

        $branch = $this->request->getPost('branch');

        $sem = $this->request->getPost('sem');

        $sec = $this->request->getPost('sec');

        $ClassesModel = new ClassesModel();

        $result = $ClassesModel->reset_Attendance($branch, $sec, $sem);

        $alert = 'fail';

        if ($result) {

            $result = $ClassesModel->insert_Attendance($selectedStudents, $branch, $sec, $sem);

            if ($result) {

                $alert = 'success';
            }
        }

        $this->response->redirect('../NavbarController?branch=' . $branch . '&sec=' . $sec . '&sem=' . $sem . '&alert=' . $alert);
    }



    public function get_day_summary()

    {

        $session = session();



        if (!$session->has('username')) {

            // redirect('/', 'refresh');

            // echo "";



            return redirect()->to('/');
        }

        $mode = $this->request->getPost('mode');

        $class = $this->request->getPost('class');

        $cls = explode('-', $class);
        $branch = $cls[0];
        $sec = $cls[1];
        $sem = $cls[2];

        $date = $this->request->getPost('date');

        $ClassesModel = new ClassesModel();

        if ($mode == 'absent_students') {
            $data = array();
            $data['attendance'] = $ClassesModel->get_absent_stds($branch, $sec, $sem, $date);
            $data['template'] = $ClassesModel->template(1, ['date' => $date]);
            echo json_encode($data);
        } else {
            $data = array();
            $data['attendance'] = $ClassesModel->get_present_stds($branch, $sec, $sem, $date);
            $data['template'] = $ClassesModel->template(2, ['date' => $date]);
            echo json_encode($data);
        }
    }



    public function summary()

    {

        $session = session();



        if (!$session->has('username')) {

            // redirect('/', 'refresh');

            // echo "";



            return redirect()->to('/');
        }

        $class = $this->request->getPost('class');

        $cls = explode('-', $class);
        $branch = $cls[0];
        $sec = $cls[1];
        $sem = $cls[2];
        $date = $this->request->getPost('date');

        $todate = $this->request->getPost('todate');

        $mode = '';

        if ($date < $todate) {

            $start_date = $date;

            $end_date = $todate;

            $mode = 'multiple';
        } else if ($date > $todate) {

            $start_date = $todate;

            $end_date = $date;

            $mode = 'multiple';
        } else {

            $start_date = $date;

            $end_date = $date;

            $mode = 'single';
        }

        $ClassesModel = new ClassesModel();

        $result = $ClassesModel->get_ranged_data($branch, $sec, $sem, $mode, $start_date, $end_date);

        echo json_encode($result);
    }

    public function count(){
        $session = session();
        if (!$session->has('username')) {
            return redirect()->to('/');
        }
        $ClassesModel = new ClassesModel();



        $result = $ClassesModel->get_classes();

        $data['classes'] = array();

        foreach ($result as $r) {

            array_push($data['classes'], [$this->year($r['sem']), $r['branch'], $r['sec'], $r['sem']]);
        }
        return view('count',$data);
    }


    public function processCount(){
        $session = session();
        if (!$session->has('username')) {
            return redirect()->to('/');
        }

        $date = $this->request->getPost('date');
        $ClassModel=new ClassesModel();
        $arr=$ClassModel->getCount($date);
        echo json_encode(array("text"=>$arr['text'],"html"=>$arr['html']));
    }






    public function index2()

    {


        $session = session();



        if (!$session->has('username')) {

            // redirect('/', 'refresh');

            // echo "";



            return redirect()->to('/');
        }



        $ClassesModel = new ClassesModel();



        $result = $ClassesModel->get_classes();

        $data['classes'] = array();

        foreach ($result as $r) {

            array_push($data['classes'], [$this->year($r['sem']), $r['branch'], $r['sec'], $r['sem']]);
        }



        $data['mode'] = 'absent_students';



        return view('day_summary', $data);
    }





    public function index22()

    {



        $session = session();



        if (!$session->has('username')) {

            // redirect('/', 'refresh');

            // echo "";



            return redirect()->to('/');
        }



        $ClassesModel = new ClassesModel();



        $result = $ClassesModel->get_classes();

        $data['classes'] = array();

        foreach ($result as $r) {

            array_push($data['classes'], [$this->year($r['sem']), $r['branch'], $r['sec'], $r['sem']]);
        }

        $data['mode'] = 'present_students';



        return view('day_summary', $data);
    }





    public function index3()

    {



        $session = session();



        if (!$session->has('username')) {

            // redirect('/', 'refresh');

            // echo "";



            return redirect()->to('/');
        }



        $ClassesModel = new ClassesModel();



        $result = $ClassesModel->get_classes();

        $data['classes'] = array();

        foreach ($result as $r) {

            array_push($data['classes'], [$this->year($r['sem']), $r['branch'], $r['sec'], $r['sem']]);
        }


        return view('summary', $data);
    }


    public function jvds(){
        $session = session();

        if (!$session->has('username')) {

            return redirect()->to('/');
        }

        $ClassesModel = new ClassesModel();

    }







    public function index4()

    {

        $session = session();



        if (!$session->has('username')) {

            // redirect('/', 'refresh');

            // echo "";



            return redirect()->to('/');
        }

        return view('logout');
    }
}
