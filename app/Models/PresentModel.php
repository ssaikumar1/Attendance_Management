<?php 
namespace App\Models;

use CodeIgniter\Model;

class PresentModel extends Model
{
    protected $table = 'unchecked_students';
    protected $primaryKey = 'roll_number';
    protected $allowedFields = ['Date', 'roll_number'];
}
