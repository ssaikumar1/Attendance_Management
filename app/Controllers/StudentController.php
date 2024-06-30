<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\StudentModel;

class StudentController extends Controller
{

    public function index()
    {
      
        $studentModel = new StudentModel();
        $students = $studentModel->getStudents();

        // Load the student_table view and pass the student data
        return view('student_table', ['students' => $students]);
    }

    public function processStudents()
    {
        $db = \Config\Database::connect();
        $checkedStudents = [];
        $uncheckedStudents = [];

        // Get the selected students from the form submission
        $selectedStudents = $this->request->getPost('students');

        // Get the students from the database
        $studentModel = new StudentModel();
        $students = $studentModel->getStudents();

        // Separate checked and unchecked students based on the selected checkbox values
        foreach ($students as $student) {
            if (in_array($student->roll_number, $selectedStudents)) {
                $checkedStudents[] = $student;
            } else {
                $uncheckedStudents[] = $student;
            }
        }
        // Insert the checked students into the database
        $checkedStudentsData = [];
        foreach ($checkedStudents as $student) {
            $checkedStudentsData[] = [
                'roll_number' => $student->roll_number,
                'name' => $student->name,
            ];
        }

        $db->table('checked_students')->insertBatch($checkedStudentsData);

        // Insert the unchecked students into the database
        $uncheckedStudentsData = [];
        foreach ($uncheckedStudents as $student) {
            $uncheckedStudentsData[] = [
                'roll_number' => $student->roll_number,
                'name' => $student->name,
            ];
        }

        $db->table('unchecked_students')->insertBatch($uncheckedStudentsData);

        // Load the student_result view and pass the checked and unchecked student data
        return view('student_result', ['checkedStudents' => $checkedStudents, 'uncheckedStudents' => $uncheckedStudents]);
    }
    public function edit()
    {
      
        $studentModel = new StudentModel();
        $students = $studentModel->getStudents();
        $checked_students=$studentModel->getchecked_students();
        $checked_students_array=array();
        foreach($checked_students as $cs){
            array_push($checked_students_array,$cs->roll_number);
        }

        // Load the student_edit view and pass the student,checked data
        return view('student_edit', ['students' => $students,'checked_students'=>$checked_students_array]);
    }
    public function processStudents2()
    {
        $db = \Config\Database::connect();
        $checkedStudents = [];
        $uncheckedStudents = [];

        // Get the selected students from the form submission
        $selectedStudents = $this->request->getPost('students');

        // Get the students from the database
        $studentModel = new StudentModel();
        $students = $studentModel->getStudents();

        $studentModel->delete_entries();

        // Separate checked and unchecked students based on the selected checkbox values
        foreach ($students as $student) {
            if (in_array($student->roll_number, $selectedStudents)) {
                $checkedStudents[] = $student;
            } else {
                $uncheckedStudents[] = $student;
            }
        }

        // Insert the checked students into the database
        $checkedStudentsData = [];
        foreach ($checkedStudents as $student) {
            $checkedStudentsData[] = [
                'roll_number' => $student->roll_number,
                'name' => $student->name,
            ];
        }

        $db->table('checked_students')->insertBatch($checkedStudentsData);

        // Insert the unchecked students into the database
        $uncheckedStudentsData = [];
        foreach ($uncheckedStudents as $student) {
            $uncheckedStudentsData[] = [
                'roll_number' => $student->roll_number,
                'name' => $student->name,
            ];
        }

        $db->table('unchecked_students')->insertBatch($uncheckedStudentsData);

        // Load the student_result view and pass the checked and unchecked student data
        return view('student_result', ['checkedStudents' => $checkedStudents, 'uncheckedStudents' => $uncheckedStudents]);
    }
}

