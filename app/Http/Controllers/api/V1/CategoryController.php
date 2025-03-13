<?php

namespace App\Http\Controllers\api\V1;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;

use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected CategoryRepositoryInterface $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json($this->categoryRepository->getAll());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:categories,id', // For subcategories
    ]);

    $category = $this->categoryRepository->create($validatedData);

    return response()->json([
        'message' => 'Category created successfully',
        'category' => $category
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show($id) : JsonResponse
    {
        return response()->json($this->categoryRepository->getById($id));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}