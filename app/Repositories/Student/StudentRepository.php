<?php

namespace App\Repositories\Student;

use App\Models\Student;
use App\Repositories\BaseRepository;

class StudentRepository extends BaseRepository
{
    public function __construct(Student $model = null)
    {
        parent::__construct($model);
    }
}
