<?php

namespace Yazdan\Category\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Yazdan\Category\App\Http\Requests\CategoryRequest;
use Yazdan\Category\App\Models\Category;
use Yazdan\Category\Repositories\CategoryRepository;
use Yazdan\Common\Responses\AjaxResponses;

class CategoryController extends Controller
{

    public function index()
    {
        $this->authorize('manage', Category::class);

        $categories = CategoryRepository::getAllPaginate(10);
        return view('Category::index', compact('categories'));
    }


    public function store(CategoryRequest $request)
    {
        $this->authorize('manage', Category::class);

        CategoryRepository::create($request);
        return back();
    }

    public function edit($categoryId)
    {
        $this->authorize('manage', Category::class);

        $category = CategoryRepository::findById($categoryId);
        $parentCategories = CategoryRepository::getAllExceptById($categoryId);
        return view('Category::edit', compact('category', 'parentCategories'));
    }

    public function update($categoryId, CategoryRequest $request)
    {
        $this->authorize('manage', Category::class);

        CategoryRepository::updating($categoryId, $request);
        return redirect(route('admin.categories.index'));
    }

    public function destroy($categoryId)
    {
        $this->authorize('manage', Category::class);

        CategoryRepository::delete($categoryId);
        return AjaxResponses::SuccessResponses();
    }
}
