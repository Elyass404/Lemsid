<?php
namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
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

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'mentor' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'thumbnail' => 'nullable|string'
        ]);

        return response()->json($this->courseRepository->create($data), 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'mentor' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'thumbnail' => 'nullable|string'
        ]);

        return response()->json($this->courseRepository->update($id, $data));
    }

    public function destroy($id): JsonResponse
    {
        $this->courseRepository->delete($id);
        return response()->json(['message' => 'Course deleted successfully'], 200);
    }
}
