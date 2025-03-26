<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
class EnrollmentRepository{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //nothing to be constructed
    }

    // public function enrollStudent(int $courseId){
    //     $user = Auth::user();

    //     // in here I verif y the user if he is enrolled before or not, if enrolled there is no need to enroll again
    //     if (Enrollment::where('user_id', $user->id)->where('course_id', $courseId)->exists()) {
    //         return response()->json(['message' => 'You are already enrolled in this course'], 400);
    //     }

    //     //If he is not enrolled, now lets enroll the student
    //     return Enrollment::create([
    //         'user_id' => $user->id,
    //         'course_id' => $courseId,
    //     ]);
    // }

    public function isEnrolled($userId,$courseId){
        return Enrollment::where('user_id', $userId)
                     ->where('course_id', $courseId)
                     ->exists();
    }

    public function enroll($userId, $courseId){
    return Enrollment::create([
        'user_id' => $userId,
        'course_id' => $courseId,
    ]);
}
}
