<?php

namespace App\Services;

use App\Repositories\EnrollmentRepository;
use App\Models\Course;
use App\Models\User;

class EnrollmentService
{
    protected $enrollmentRepository;

    public function __construct(EnrollmentRepository $enrollmentRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function enrollStudent(User $user,  $course)
    {
        // in here I verif y the user if he is enrolled before or not, if enrolled there is no need to enroll again
        
        if ($this->enrollmentRepository->isEnrolled($user->id, $course["course_id"])) {
            return ['success' => false, 'message' => 'Student is already enrolled in this course.'];
        }

        // enroll the student
        $enrollment = $this->enrollmentRepository->enroll($user->id, $course["course_id"]);

        return ['success' => true, 'data' => $enrollment, 'message' => 'Enrollment successful!'];
    }
}
