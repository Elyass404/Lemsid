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
    public function store(StoreCategoryRequest $request): JsonResponse
{

    $category = $this->categoryRepository->create($request->validated());

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
    public function update(Request $request, $id) : JsonResponse
{
    // Validate the incoming request data
    $validated = $request->validate([
        'name' => 'required|string|max:255', // You can add more validation as needed
        'parent_id' => 'nullable|exists:categories,id', // Make sure the parent_id exists in the categories table, if provided
    ]);

    // Find the category by ID
    $category = $this->categoryRepository->getById($id);

    // Update the category
    $category->update($validated);

    // Return the updated category as a JSON response
    return response()->json($category);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}