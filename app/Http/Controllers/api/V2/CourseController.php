<?php
namespace App\Http\Controllers\api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Repositories\Eloquent\CourseRepository;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    protected CourseRepositoryInterface $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->courseRepository->getAll());
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->courseRepository->getById($id));
    }

    public function store(CourseRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $tags = $validatedData["tags"] ?? [];

        $course=$this->courseRepository->create($validatedData);

        $course->tags()->sync($tags);

        return response()->json($course, 201);
    }

    public function update(CourseRequest $request, $id): JsonResponse
    {
        return response()->json($this->courseRepository->update($id, $request->validated()));
    }

    public function destroy($id): JsonResponse
    {
        $this->courseRepository->delete($id);
        return response()->json(['message' => 'Course deleted successfully'], 200);
    }
}
