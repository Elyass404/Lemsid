<?php

namespace App\Http\Controllers\api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\TagRepository;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagController extends Controller
{

    protected TagRepository $tagRepository;
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json($this->tagRepository->getAll());
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->tagRepository->getById($id));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        return response()->json($this->tagRepository->create($data), 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
        ]);

        return response()->json($this->tagRepository->update($id, $data));
    }

    public function destroy($id): JsonResponse
    {
        $this->tagRepository->delete($id);
        return response()->json(['message' => 'Tag deleted successfully']);
    }
}
