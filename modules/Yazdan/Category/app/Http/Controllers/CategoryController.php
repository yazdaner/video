<?php

namespace Yazdan\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Yazdan\Category\Models\Category;
use Yazdan\Category\Responses\AjaxResponses;
use Yazdan\Category\Http\Requests\CategoryRequest;
use Yazdan\Category\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CategoryRepository::getAllPaginate(10);
        return view('Category::index',compact('categories'));
    }


    public function store(CategoryRequest $request)
    {
        CategoryRepository::create($request);
        return back();
    }

    public function edit($categoryId)
    {
        $category = CategoryRepository::findById($categoryId);
        $parentCategories = CategoryRepository::getAllExceptById($categoryId);
        return view('Category::edit',compact('category','parentCategories'));
    }

    public function update($categoryId,CategoryRequest $request)
    {
        CategoryRepository::updating($categoryId,$request);

        return redirect(route('admin.categories.index'));
    }

    public function destroy($categoryId)
    {
        CategoryRepository::delete($categoryId);

        return AjaxResponses::SuccessResponses();
    }
}
