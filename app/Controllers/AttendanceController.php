<?php
namespace App\Controllers;

use App\Models\PresentModel;
use App\Models\AbsentModel;

class AttendanceController extends BaseController
{
    public function index($Date)
    {
        // Convert the date to the appropriate format to match your database field
        $formattedDate = Date('Y-m-d', strtotime($Date));

        // Get the number of students present on the specified date
        $presentModel = new PresentModel();
        $numPresent = $presentModel->where('Date', $formattedDate)->countAllResults();

        // Get the number of students absent on the specified date
        $absentModel = new AbsentModel();
        $numAbsent = $absentModel->where('Date', $formattedDate)->countAllResults();

        // Return the results
        return json_encode([
            'Date' => $formattedDate,
            'present' => $numPresent,
            'absent' => $numAbsent
        ]);
    }
}
