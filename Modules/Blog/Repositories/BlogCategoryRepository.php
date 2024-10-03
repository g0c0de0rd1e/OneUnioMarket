<?php

namespace Modules\Blog\Repositories;
use App\Models\UsedMedia;
use Modules\Blog\Entities\BlogCategory;
use App\Traits\ImageStore;

class BlogCategoryRepository
{
    public function getAll()
    {
        return BlogCategory::where('parent_id',0)->with(['parent','childs'])->get();
    }
    
    public function create(array $data)
    {
        $parent_id=0;
        $level=1;
        if(!empty($data['parent_id'])){
            $parent_id=$data['parent_id'];
            $level_check=BlogCategory::where('id',$data['parent_id'])->first();
            $level=$level_check->level+1;
        }
        $data['parent_id'] = $parent_id;
        $data['level'] = $level;
        $blog_category = new BlogCategory();
        $blog_category->fill($data)->save();
        UsedMedia::create([
            'media_id' => $data['blog_image'],
            'usable_id' => $blog_category->id,
            'usable_type' => get_class($blog_category),
            'used_for' => 'blog_cat_image'
        ]);
        return true;
    }

    public function find($id)
    {
        return BlogCategory::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $parent_id=0;
        $level=1;
        if(!empty($data['parent_id'])){
            $parent_id=$data['parent_id'];
            $level_check=BlogCategory::where('id',$data['parent_id'])->first();
            $level=$level_check->level+1;
        }
        $data['parent_id'] = $parent_id;
        $data['level'] = $level;
        $blog_category = BlogCategory::findOrFail($id);
        $blog_category->update($data);
        return true;
    }

    public function delete($id)
    {  
        $file=BlogCategory::findOrFail($id);
        if(file_exists($file->image_url)){
            ImageStore::deleteImage($file->image_url);
         }
         UsedMedia::where('usable_id', $file->id)->where('usable_type', get_class($file))->where('used_for', 'blog_cat_image')->delete();
         $file->delete();
        return true;
    }
}

