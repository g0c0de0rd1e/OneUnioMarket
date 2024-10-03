<?php

namespace Modules\PageBuilder\Http\Requests;

use App\Traits\ValidationMessage;
use Illuminate\Foundation\Http\FormRequest;

class CustomPageRequest extends FormRequest
{
    use ValidationMessage;

    public function rules()
    {
        if (isModuleActive('FrontendMultiLang')) {
            $code = auth()->user()->lang_code;
            return [
                'title.'. $code=>"required|unique_translation:dynamic_pages,title,{$this->id}",
                'slug'=>'required|unique:dynamic_pages,slug,'.$this->id,
            ];
        }else{
            return [
                'title'=>'required|unique:dynamic_pages,title,'.$this->id,
                'slug'=>'required|unique:dynamic_pages,slug,'.$this->id,
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'title.*.required' => 'The Title field is required',
                'title.*.unique_translation' => 'The Title is already be taken',
                'slug.required' => 'The Slug field is required',
                'slug.unique' => 'The Slug is already be taken',
            ];
        }else{
            return [
                'title.required' => 'The Title field is required',
                'title.unique' => 'The Title is already be taken',
                'slug.required' => 'The Slug field is required',
                'slug.unique' => 'The Slug is already be taken',
            ];
        }
    }

    public function authorize()
    {
        return true;
    }
}
