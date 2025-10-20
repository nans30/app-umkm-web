<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\DataTables\CategoryDataTable;
use App\Repositories\CategoryRepository;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->authorizeResource(Category::class, 'category');
        $this->repository = $repository;
    }

    public function index(CategoryDataTable $dataTable)
    {
        return $this->repository->index($dataTable);
    }

    public function create()
    {
        return $this->repository->create();
    }

    public function store(CreateCategoryRequest $request)
    {
        return $this->repository->store($request);
    }

    public function show(Category $category)
    {
        return $this->repository->show($category);
    }

    public function edit(Category $category)
    {
        return $this->repository->edit($category->id);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        return $this->repository->update($request, $category->id);
    }

    public function destroy(Category $category)
    {
        return $this->repository->destroy($category->id);
    }

    public function status(Request $request, $id)
    {
        return $this->repository->status($id, $request->status);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || !is_array($ids)) {
            return redirect()->back()->with('error', 'No IDs selected');
        }

        return $this->repository->bulkDelete($ids);
    }

    public function copy($id)
    {
        return $this->repository->edit($id, true);
    }
}
