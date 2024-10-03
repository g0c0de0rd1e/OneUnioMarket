<?php

namespace Modules\Blog\Entities;
use App\Models\UsedMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class BlogCategory extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id'];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['name'];
        }
    }
    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->slug = strtolower(str_replace(' ', '-', $model->name).'-'.$model->id);
            $model->save();
        });
        static::updating(function ($model) {
            $model->slug = strtolower(str_replace(' ', '-', $model->name).'-'.$model->id);
        });
    }
    public function childs(){
    	return $this->hasMany(BlogCategory::class,'parent_id','id')->with('categories');
    }
    public function parent(){
    	return $this->belongsTo(BlogCategory::class,'parent_id');
    }
    public function categories()
    {
    return $this->hasMany(BlogCategory::class, "parent_id", "id");
    }
    public function posts()
    {
        return $this->belongsToMany(BlogPost::class,'blog_category_post','blog_category_id','blog_post_id');
    }
    public function activePost()
    {
        return $this->belongsToMany(BlogPost::class,'blog_category_post','blog_category_id','blog_post_id')->where('is_approved',1);
    }
    public function blog_cat_image_media(){
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'blog_cat_image');
    }
}
