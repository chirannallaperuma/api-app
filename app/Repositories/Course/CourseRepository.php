<?php

namespace App\Repositories\Course;

use App\Models\Course;
use App\Repositories\BaseRepository;

class CourseRepository extends BaseRepository
{
    /**
     * @param Course|null $model
     */
    public function __construct(Course $model = null)
    {
        parent::__construct($model);
    }

    /**
     * check course already enrolled
     *
     * @param $courseId
     * @return mixed
     */
    public function checkStudentCourse($courseId)
    {
        $student = auth()->user();

        $course = $student->courses->where('id', $courseId)->first();

        return $course;
    }
}
