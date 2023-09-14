<?php

namespace Yazdan\Category\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'title',
        'slug',
        'parent_id'
    ];

    public function getParentAttribute()
    {
        return !($this->parent_id) ? 'ندارد' : $this->parentCategory->title;
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function subCategory()
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function getPathAttribute()
    {
        // todo
        return route('categories.show',$this->id);
    }
}

