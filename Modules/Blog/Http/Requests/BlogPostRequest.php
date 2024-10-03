<?php

namespace Modules\Blog\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class BlogPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (isModuleActive('FrontendMultiLang')) {
            $code = auth()->user()->lang_code;
            return [
                'title.'. $code => 'required',
                'slug.'. $code => 'required|unique_translation:blog_posts,slug,'.$this->post,
                'content.'. $code => 'required',
                'blog_image' => 'nullable',
                'categories' => 'required',
                'tag' => 'required'  
            ];
        }else{
            return [
                'title' => 'required',
                'slug' => 'required|unique:blog_posts,slug,'.$this->post,
                'content' => 'required',
                'blog_image' => 'nullable',
                'categories' => 'required',
                'tag' => 'required'  
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'title.*.required' => 'The post title field is required',
                'slug.*.unique_translation' => 'The post slug has already been taken',
                'content.*.required' => 'The post content field is required',
            ];
        }else{
            return [
                'title.required' => 'The post title field is required',
                'slug.unique' => 'The post slug has already been taken',
                'content.required' => 'The post content field is required',
            ];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
