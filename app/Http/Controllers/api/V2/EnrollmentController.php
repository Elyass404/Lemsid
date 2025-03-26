<?php

namespace App\Http\Controllers\api\V2;


use App\Models\Enrollment;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use App\Http\Requests\EnrollmentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\Course;

class EnrollmentController extends Controller
{

    protected $enrollmentService;
    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }
    /**
     * Display a listing of the resource.
     */

     public function store(EnrollmentRequest $request): JsonResponse
    {

        $user=Auth::user();
        // $course = Course::findOrFail($request->course_id);

       $message= $this->enrollmentService->enrollStudent($user,$request->validated());
       if(!$message["success"]){
        return response()->json($message["message"],400);
       }else{
        return response()->json($message["message"],201);
       }

        
    }

    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }
}
