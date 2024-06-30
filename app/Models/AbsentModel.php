<?php
namespace App\Models;

use CodeIgniter\Model;

class AbsentModel extends Model
{
    protected $table = 'checked_students';
    protected $primaryKey = 'roll_number';
    protected $allowedFields = ['Date', 'roll_number'];
}
