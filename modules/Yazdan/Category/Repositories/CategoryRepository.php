<?php

namespace Yazdan\Category\Repositories;

use Yazdan\Category\App\Models\Category;

class CategoryRepository
{
    public static function getAll()
    {
        return Category::all();
    }

    public static function getAllPaginate($value)
    {
        return Category::latest()->paginate($value);
    }

    public static function create($value)
    {
        return Category::create([
            'title' => $value->title,
            'slug' => $value->slug,
            'parent_id' => $value->parent_id,
        ]);
    }

    public static function findById($id)
    {
        return Category::find($id);
    }


    public static function getAllExceptById($id)
    {
        return self::getAll()->filter(function($item) use ($id){
            return $item->id != $id;
        });
    }

    public static function updating($categoryId,$value)
    {
        return Category::whereId($categoryId)->update([
            'title' => $value->title,
            'slug' => $value->slug,
            'parent_id' => $value->parent_id,
        ]);
    }

    public static function delete($categoryId)
    {
        return Category::whereId($categoryId)->delete();
    }

    public static function tree()
    {
        return Category::where('parent_id',null)->with('subCategory')->get();
    }
}
