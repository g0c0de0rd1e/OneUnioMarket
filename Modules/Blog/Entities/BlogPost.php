<?php

namespace Modules\Blog\Entities;

use App\Models\UsedMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Modules\Setup\Entities\Tag;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id'];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['title','content'];
        }
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class,'blog_category_post','blog_post_id','blog_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', 1);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public function getExcerptAttribute()
    {
        $content=strip_tags($this->content);
        return Str::of($content)->limit(100);
    }
    //comments

    public function comments(){
        return $this->hasMany(BlogComment::class,'blog_post_id');
    }

    public function replay(){
        return $this->hasMany(BlogCommentReplay::class,'blog_post_id');
    }

    public function like(){
        return $this->hasMany(BlogPostLike::class,'post_id');
    }

     public function likePost(){
        return $this->hasMany(BlogPostLike::class,'post_id')->where('like',1);
    }
    public function blog_post_image_media(){
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'blog_post_image');
    }
}
