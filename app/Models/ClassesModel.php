<?php



namespace App\Models;



use CodeIgniter\Model;

use Exception;



class ClassesModel extends Model

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

  protected $table = 'students';

  protected $allowedFields = ['roll_number', 'name','branch','sec','sem'];



  protected $primaryKey = ['roll_number'];



  public function get_classes(){

    return $this->db->query("SELECT DISTINCT branch,sec,sem FROM students")->getResultArray();

  }



  public function get_students($branch,$sec,$sem){

    $params = [

        'branch' => $branch,

        'sem' => $sem,

        'sec' => $sec,

    ];

    

    return $this->db->query("SELECT * FROM students WHERE branch=:branch: AND sem=:sem: AND sec=:sec:",$params)->getResultArray();

    

  }



  public function get_absent_students($branch,$sec,$sem){
    date_default_timezone_set("Asia/Kolkata");

    $params = [

        'branch' => $branch,

        'sem' => $sem,

        'sec' => $sec,

        'stat' => 'A',

        'curdate'=> date('Y-m-d')

    ];

    


    return $this->db->query('SELECT Attendance.roll_number FROM Attendance INNER JOIN students ON Attendance.roll_number=students.roll_number WHERE Attendance.date=:curdate: AND Attendance.status=:stat: AND students.branch=:branch: AND students.sem=:sem: AND students.sec=:sec:',$params)->getResultArray();

  }

  public function template($id,$dates){
    $params=['id'=>$id];
    $templateq=$this->db->query('SELECT data FROM template WHERE id=:id:',$params)->getResultArray();
    $data=$templateq[0]['data'];
    if($id==1||$id==2){
      $date=date('d-m-Y',strtotime($dates['date']));
      $data=str_replace('<?date?>',$date,$data);
    return $data;
  }
}


public function getCount($date){
  $params=['dat'=>$date];
  $classq=$this->db->query('SELECT DISTINCT s.branch,s.sec,s.sem FROM Attendance a INNER JOIN students s ON a.roll_number=s.roll_number WHERE a.date=:dat: ORDER BY s.sem ASC',$params)->getResultArray();
  $t_total=0;
  $t_present=0;
  $text='IT ATTENDANCE: '.date('d/m/Y',strtotime($date)).'%0A----------------------------------%0A';
  $html='IT ATTENDANCE: '.date('d/m/Y',strtotime($date)).'<br>----------------------------------<br>';
  if(count($classq)>0){
  foreach($classq as $class){
    $branch=$class['branch'];
    $sec=$class['sec'];
    $sem=$class['sem'];
    $p=['branch'=>$branch,'sec'=>$sec,'sem'=>$sem];
    $total_countq=$this->db->query('SELECT COUNT(roll_number) AS "count" FROM students WHERE branch=:branch: AND sec=:sec: AND sem=:sem:',$p)->getResultArray();
    $total_count=(int)$total_countq[0]['count'];
    $t_total+=$total_count;
    $pa=['branch'=>$branch,'sec'=>$sec,'sem'=>$sem,'dat'=>$date];
    $present_countq=$this->db->query('SELECT COUNT(a.roll_number) AS "count" FROM Attendance a INNER JOIN students s ON a.roll_number=s.roll_number WHERE a.date=:dat: AND a.status="P" AND s.branch=:branch: AND s.sec=:sec: AND s.sem=:sem:',$pa)->getResultArray();
    $present_count=(int)$present_countq[0]['count'];
    $t_present+=$present_count;
    $text.='%20%20%20%20'.$this->year($sem).' '.$branch.' ['.$sec.'] - '.$present_count.'/'.$total_count.'%0A';
    $html.='&nbsp;&nbsp;&nbsp;&nbsp;'.$this->year($sem).' '.$branch.' ['.$sec.'] - '.$present_count.'/'.$total_count.'<br>';
  }
  $text.='----------------------------------%0ATOTAL - '.$t_present.'/'.$t_total;
  $html.='----------------------------------<br>TOTAL - '.$t_present.'/'.$t_total;
}else{
  $text.='No Attendance Found For This Date';
  $html.='No Attendance Found For This Date';
}

return ['text'=>$text,'html'=>$html];

}



  public function reset_Attendance($branch,$sec,$sem){
    date_default_timezone_set("Asia/Kolkata");

    $params = [

        'branch' => $branch,

        'sem' => $sem,

        'sec' => $sec,

        'curdate'=> date('Y-m-d')

    ];



    return $this->db->query('DELETE FROM Attendance WHERE roll_number IN (SELECT roll_number FROM students WHERE branch=:branch: AND sem=:sem: AND sec=:sec:) AND date=:curdate:',$params);



  }



  public function insert_Attendance($students,$branch,$sec,$sem){

    $all_students=$this->get_students($branch,$sec,$sem);

    $all_stds=array();

    foreach($all_students as $std){

      array_push($all_stds,$std['roll_number']);

    }

    $present_students=array_diff($all_stds,$students);

    $msg='';

    if($students!=null){

    if(count($students)>0){

    foreach($students as $student){

        try{
          date_default_timezone_set("Asia/Kolkata");

            $this->db->query('INSERT INTO Attendance (roll_number,date,status) VALUES (:rollno:,:curdate:,"A")',['rollno'=>$student,'curdate'=> date('Y-m-d')]);

            

        }

        catch(Exception $e){

            $msg.=$e->getMessage();

        }

    }

    foreach($present_students as $student){

      try{
        date_default_timezone_set("Asia/Kolkata");

          $this->db->query('INSERT INTO Attendance (roll_number,date,status) VALUES (:rollno:,:curdate:,"P")',['rollno'=>$student,'curdate'=>date('Y-m-d')]);

          

      }

      catch(Exception $e){

          $msg.=$e->getMessage();

      }

  }

}

    }

    if($msg==''){

        return true;

    }

    else{

        return false;

    }

  }



  public function get_sems(){

  return $this->db->query('SELECT DISTINCT sem FROM students')->getResultArray();

  }

  public function get_secs(){

    return $this->db->query('SELECT DISTINCT sec FROM students')->getResultArray();

    }

    public function get_branches(){

      return $this->db->query('SELECT DISTINCT branch FROM students')->getResultArray();

      }



      public function get_absent_stds($branch,$sec,$sem,$date){

        $params = [

            'branch' => $branch,

            'sem' => $sem,

            'sec' => $sec,

            'dat' => $date

        ];

    

        return $this->db->query('SELECT students.roll_number,students.name FROM Attendance INNER JOIN students ON Attendance.roll_number=students.roll_number WHERE Attendance.date=:dat: AND Attendance.status="A" AND students.branch=:branch: AND students.sem=:sem: AND students.sec=:sec:',$params)->getResultArray();

      }





      public function get_present_stds($branch,$sec,$sem,$date){

        $params = [

          'branch' => $branch,

          'sem' => $sem,

          'sec' => $sec,

          'dat' => $date

      ];

  

      return $this->db->query('SELECT students.roll_number,students.name FROM Attendance INNER JOIN students ON Attendance.roll_number=students.roll_number WHERE Attendance.date=:dat: AND Attendance.status="P" AND students.branch=:branch: AND students.sem=:sem: AND students.sec=:sec:',$params)->getResultArray();

      }





      public function get_ranged_data($branch,$sec,$sem,$mode,$start_date,$end_date){

        $params=[

          'branch' => $branch,

          'sem' => $sem,

          'sec' => $sec,

          'st_date' => $start_date,

          'en_date' => $end_date

        ];

        $noofworkingdays=$this->db->query("SELECT COUNT(DISTINCT(a.date)) as 'nowd' FROM Attendance a INNER JOIN students s ON a.roll_number=s.roll_number WHERE a.date>=:st_date: AND a.date<=:en_date: AND s.branch=:branch: AND s.sem=:sem: AND s.sec=:sec:",$params)->getResultArray();

        $nowd=(int)$noofworkingdays[0]['nowd'];

        $students=$this->get_students($branch,$sec,$sem);

        $data=array();

        $data['nowd']=$nowd;

        $data['students']=array();

        if($nowd>0){

        foreach($students as $student){

          $std=array();

          $std['roll_number']=$student['roll_number'];

          $std['name']=$student['name'];

          $pms=[

            'rollno' => $std['roll_number'],

            'st_date' => $start_date,

            'en_date' => $end_date

          ];

          $presentq=$this->db->query("SELECT COUNT(DISTINCT(date)) as 'pds' FROM Attendance WHERE roll_number=:rollno: AND date>=:st_date: AND date<=:en_date: AND status='P'",$pms)->getResultArray();

          $std['pds']=(int)$presentq[0]['pds'];

          $std['ads']=(int)$nowd-$std['pds'];

          $std['percent']=round(($std['pds']/$nowd)*100,2);

          array_push($data['students'],$std);

        }

      }

        return $data;

      }



      

    

  



}

