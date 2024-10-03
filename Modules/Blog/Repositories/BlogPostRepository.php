<?php

namespace Modules\Blog\Repositories;
use App\Models\UsedMedia;
use App\Models\User;
use App\Notifications\NewAuthorPost;
use Modules\Blog\Entities\BlogPost;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\BlogPostTag;
use Modules\Setup\Entities\Tag;
use Modules\Setup\Repositories\TagRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Traits\ImageStore;

class BlogPostRepository
{
    public function getAll()
    {
        return BlogPost::latest();
    }
    public function getUserPost()
    {
        return BlogPost::where('author_id',auth()->user()->id)->latest();
    }
    public function create(array $data)
    {
        $blog_post = new BlogPost();
        $data['author_id'] = auth()->user()->id;
        if (isModuleActive('FrontendMultiLang')) {
            $data['slug'] = $data['slug'][auth()->user()->lang_code];
        }else{
            $data['slug'] = $data['slug'];
        }
        $data['status'] = isset($data['status'])? true: false;
        $data['is_commentable'] = isset($data['comments']) ? false:true;
        $data['published_at'] = Carbon::now();
        $blog_post->fill($data)->save();
        if (isset($data['blog_image'])) {
            UsedMedia::create([
                'media_id' => $data['blog_image'],
                'usable_id' => $blog_post->id,
                'usable_type' => get_class($blog_post),
                'used_for' => 'blog_post_image'
            ]);
        }
        $tags = explode(',', $data['tag']);
        $sync_array = [];
        foreach ($tags as $tag) {
            if($tag != ''){
                $is_tag = (new TagRepository())->is_tag($tag);
                if ($is_tag) {
                    array_push($sync_array, $is_tag->id);
                } else {
                    $tags = new Tag();
                    $tags->name = trim(strtolower($tag));
                    $tags->save();
                    array_push($sync_array, $tags->id);
                }
            }
        }
        $blog_post->tags()->sync($sync_array);
        $blog_post->categories()->attach($data['categories']);
        $admins=User::whereIn('role_id',[1,2,3])->get();
        $details['body']= auth()->user()->fullname.'Has Created a New Post';
        Notification::send($admins, new NewAuthorPost($details));
        return true;
    }

    public function find($id)
    {
        return BlogPost::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $blog_post = BlogPost::findOrFail($id);
        $data['author_id'] = auth()->user()->id;
        if (isModuleActive('FrontendMultiLang')) {
            $data['slug'] = $data['slug'][auth()->user()->lang_code];
        }else{
            $data['slug'] = $data['slug'];
        }
        $data['status'] = isset($data['status'])? true: false;
        $data['is_commentable'] = isset($data['comments']) ? false:true;
        $data['published_at'] = Carbon::now();
        $blog_post->fill($data)->save();
        $tags = explode(',', $data['tag']);
        $sync_array = [];
        foreach ($tags as $tag) {
            if($tag != ''){
                $is_tag = (new TagRepository())->is_tag($tag);
                if ($is_tag) {
                    array_push($sync_array, $is_tag->id);
                } else {
                    $tags = new Tag();
                    $tags->name = trim($tag);
                    $tags->save();
                    array_push($sync_array, $tags->id);
                }
            }
        }
        $blog_post->tags()->sync($sync_array);
        $blog_post->categories()->sync($data['categories']);
        return true;
    }

    public function delete($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->tags()->detach();
        $post->categories()->detach();
        if (file_exists($post->image_url)) {
            ImageStore::deleteImage($post->image_url);
        }
        UsedMedia::where('usable_id', $post->id)->where('usable_type', get_class($post))->where('used_for', 'blog_post_image')->delete();
        $post->delete();
        return true;
    }

    public function statusUpdate($data)
    {
        $post = BlogPost::findOrFail($data['id']);
        $data['status'] = $post->status == 0 ? 1 : 0;
        $post->fill($data)->save();
        return true;
    }
    public function approvalUpdate($data){
        $post = BlogPost::findOrFail($data['id']);
        $data['is_approved'] = $post->is_approved == 0 ? 1 : 0;
        $data['approved_by'] = auth()->user()->id;
        $post->fill($data)->save();
        $user=User::where('id',$post->user->id)->get();
        if ($data['is_approved'] == 1) {
            $details['body']= 'Your Post Has Been Approved ';
        }else {
            $details['body']= 'Your Post Has Been Disapproved ';
        }
        Notification::send($user, new NewAuthorPost($details));
        return $post;
    }
    public function categoryList(){
        return BlogCategory::all();
    }
    public function tagList(){
        return Tag::limit(10)->get();
    }
    public  function categoryParentList(){
        return BlogCategory::where('parent_id',0)->get();
    }
    public function findWithRelModal($id){
        return BlogPost::where('id',$id)->with(['categories','tags','user'])->first();
    }
    public function isTag($tagSlug){
        return BlogPostTag::with('posts')->where('name', trim($tagSlug))->first();
    }
}
