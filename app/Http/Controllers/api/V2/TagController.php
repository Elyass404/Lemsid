<?php

namespace App\Http\Controllers\api\V2;

use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
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

    public function store(TagRequest  $request): JsonResponse
    {

        return response()->json($this->tagRepository->create($request->validated()), 201);
    }

    public function update(TagRequest $request, $id): JsonResponse
    {
        $tag = $this->tagRepository->update($id, $request->validated());
        return response()->json($tag);
    }

    public function destroy($id): JsonResponse
    {
        $this->tagRepository->delete($id);
        return response()->json(['message' => 'Tag deleted successfully']);
    }
}
