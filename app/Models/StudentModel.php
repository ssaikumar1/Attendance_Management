<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';

    public function getStudents()
    {
        return $this->db->query('SELECT * FROM students')->getResult();
    }

    public function checkStudent($roll_number)
    {
        $params = ["rollno" => $roll_number];
        $check = $this->db->query('SELECT * FROM students WHERE roll_number = :rollno:', $params)->getNumRows();
        return $check;
    }

    public function getDetails($roll_number)
    {
        $params = ["rollno" => $roll_number];
        $check = $this->db->query('SELECT * FROM students WHERE roll_number = :rollno:', $params)->getResultArray();
        return $check;
    }

    public function getLastTenDaysAttendance($roll_number)
    {
        $params = ["rollno" => $roll_number];
        $check = $this->db->query('SELECT * FROM Attendance WHERE roll_number = :rollno: ORDER BY date DESC LIMIT 10', $params)->getResultArray();
        $data['count'] = count($check);
        $data['Attendance'] = array();
        if ($data['count'] > 0) {
            foreach ($check as $day) {
                array_push($data['Attendance'], ['date' => $day['date'], "status" => $day['status']]);
            }
        }
        return $data;
    }

    public function getDayAttendance($roll_number, $date)
    {
        $params = ["rollno" => $roll_number, "dat" => $date];
        $check = $this->db->query('SELECT * FROM Attendance WHERE roll_number = :rollno: AND date = :dat:', $params)->getResultArray();
        return $check;
    }

    public function get_ranged_data($roll_number, $start_date, $end_date)
    {
        $params = [
            'rollno' => $roll_number,
            'st_date' => $start_date,
            'en_date' => $end_date
        ];
        $noofworkingdays = $this->db->query("SELECT COUNT(DISTINCT(date)) as 'nowd' FROM Attendance WHERE date>=:st_date: AND date<=:en_date: AND roll_number=:rollno:", $params)->getResultArray();
        $nowd = (int)$noofworkingdays[0]['nowd'];
        $data = array();
        $data['nowd'] = $nowd;
        $data['Attendance'] = array();
        if ($nowd > 0) {
            $attendq=$this->db->query("SELECT * FROM Attendance WHERE date>=:st_date: AND date<=:en_date: AND roll_number=:rollno:", $params)->getResultArray();
            $data['pds']=0;
            $data['ads']=0;
            foreach ($attendq as $student) {
                $std = array();
                $std['date'] = date("F jS, Y", strtotime($student['date']));
                $std['status'] = $student['status'];
                if($std['status']=='P'){
                    $data['pds']++;
                }                
                else{
                    $data['ads']++;
                }
                array_push($data['Attendance'], $std);
            }
            $data['percent']=($data['pds']/$data['nowd'])*100;
        }
        return $data;
    }



    protected $table2 = 'checked_students';
    public function getchecked_students()
    {
        return $this->db->query('SELECT * FROM checked_students')->getResult();
    }

    public function delete_entries()
    {
        $this->db->query("DELETE FROM checked_students WHERE Date=CURDATE()");
        $this->db->query("DELETE FROM unchecked_students WHERE Date=CURDATE()");
        return;
    }
}
