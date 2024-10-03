@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/blog/css/category.css'))}}" />
@endsection
@section('mainContent')
@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<section class="admin-visitor-area up_st_admin_visitor mt-20">
    <div class="container-fluid p-0">
       @if(isset($editData))
        <div class="row">
            <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                <a href="{{route('blog.categories.index')}}" class="primary-btn small fix-gr-bg">
                    <span class="ti-plus pr-2"></span>
                    @lang('common.add')
                </a>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-1">
                                @if(isset($editData))
                                    @lang('common.edit')
                                @else
                                    @lang('common.add')
                                @endif
                                @lang('blog.blog_category')
                            </h3>
                        </div>
                        @if(isset($editData))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'url' => route('blog.categories.update',$editData->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @else
                        {{ Form::open(['class' => 'form-horizontal add_form', 'files' => true, 'route' => ['blog.categories.store'],
                        'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        @endif
                        <div class="white-box">
                            <div class="add-visitor">
                                <div class="row">
                                    @if(isModuleActive('FrontendMultiLang'))
                                        <div class="col-lg-12">
                                            <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                                @foreach ($LanguageList as $key => $language)
                                                    <li class="nav-item lang_code" data-id="{{$language->code}}">
                                                        <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#element{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="element{{$language->code}}">
                                                        <div class="col-lg-12">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label" for="">@lang('blog.category') @lang('common.name')<span class="text-danger">*</span></label>
                                                                <input name="name[{{$language->code}}]" class="primary_input_field name" id="name" placeholder="@lang('blog.category') @lang('common.name')" type="text" autocomplete="off" value="{{isset($editData)?$editData->getTranslation('name',$language->code):old('name.'.$language->code)}}">
                                                            </div>
                                                            @if ($errors->has('name.'.auth()->user()->lang_code))
                                                                <span class="text-danger"> {{ $errors->first('name.'.auth()->user()->lang_code) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">@lang('blog.category') @lang('common.name')<span class="text-danger">*</span></label>
                                                <input name="name" class="primary_input_field name" id="name" placeholder="@lang('blog.category') @lang('common.name')" type="text" autocomplete="off" value="{{isset($editData)? $editData->name : '' }}">
                                            </div>
                                            @if ($errors->has('name'))
                                                <span class="alert alert-warning" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">@lang('blog.select_parent_category')</label>
                                            <select class="primary_select mb-25" name="parent_id" id="parent_id" data-live-search="true">
                                                <option value="">{{__('common.select_one')}}</option>
                                                @foreach($itemCategories as $value)
                                                    <option value="{{$value->id}}"
                                                        @if(isset($editData))
                                                        {{($editData->parent_id==$value->id)? 'selected': '' }}
                                                        @endif ><strong>-></strong> {{ $value->name }}
                                                    @foreach ($value->childs as $child_account)
                                                       @include('blog::category.category_select', ['child_account' => $child_account])
                                                    @endforeach
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                         @if ($errors->has('parent_id'))
                                            <span  class="text-danger"> {{ $errors->first('parent_id') }} </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="image">{{__("blog.image")}} <span class="text-danger">*</span></label>
                                            <div class="primary_file_uploader" data-toggle="amazuploader" data-multiple="false" data-type="image" data-name="blog_image">
                                                <input class="primary-input file_amount" type="text" id="image" placeholder="{{__('common.browse_image_file')}}" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg" for="image">{{__("blog.image")}} </label>
                                                    <input type="hidden" class="selected_files" value="{{@$editData->blog_cat_image_media->media_id}}">
                                                </button>
                                            </div>
                                            <div class="product_image_all_div">
                                                @if(@$editData->blog_cat_image_media->media_id)
                                                    <input type="hidden" name="meta_image" class="product_images_hidden" value="{{@$editData->blog_cat_image_media->media_id}}">
                                                @endif
                                            </div>
                                        </div>
                                        @if ($errors->has('blog_image'))
                                            <span class="text-danger"> {{ $errors->first('blog_image') }}</span>
                                        @endif
                                    </div>
                                </div>
                               @php
                                    if(permissionCheck('blog.categories.store')){
                                        $tooltipAdd = "";
                                        $disable = "";
                                    }else{
                                        $tooltipAdd = "You have no permission to add";
                                        $disable = "disabled";
                                    }

                                    if(permissionCheck('blog.categories.edit')){
                                        $tooltipUpdate = "";
                                        $disable = "";
                                    }else{
                                        $tooltipUpdate = "You have no permission to update";
                                        $disable = "disabled";
                                    }
                                @endphp
                                    <div class="row mt-40">
                                        @if(isset($editData))
                                            @if (permissionCheck('blog.categories.edit'))
                                                <div class="col-lg-12 text-center tooltip-wrapper" data-title="{{ $tooltipUpdate}}">
                                                    <button id="edit_btn" class="primary-btn fix-gr-bg tooltip-wrapper {{$disable }}" {{ @$disable }}>
                                                        <span class="ti-check"></span>
                                                            @lang('common.update')
                                                    </button>
                                                </div>
                                            @else
                                                <div class="col-lg-12 text-center">
                                                    <span class="alert alert-warning" role="alert">
                                                        <strong>{{__('hr.You_do_not_have_this_permission')}}</strong>
                                                    </span>
                                                </div>
                                            @endif
                                        @else
                                            @if (permissionCheck('blog.categories.store'))
                                                <div class="col-lg-12 text-center tooltip-wrapper" data-title="{{ $tooltipAdd}}">
                                                    <button id="add_btn" class="primary-btn fix-gr-bg tooltip-wrapper {{$disable }}" {{ @$disable }}>
                                                        <span class="ti-check"></span>
                                                            @lang('common.add')
                                                    </button>
                                                 </div>
                                            @else
                                                <div class="col-lg-12 text-center">
                                                    <span class="alert alert-warning" role="alert">
                                                        <strong>{{__('hr.You_do_not_have_this_permission')}}</strong>
                                                    </span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
          <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="main-title">
                    <h3 class="mb-2"> @lang('blog.blog_category')</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <div class="">
                                <div id="model_list">
                                    <table class="table Crm_table_active3">
                        <thead>
                            <tr>
                                <th>@lang('common.sl')</th>
                                <th>@lang('common.image')</th>
                                <th> @lang('common.category')</th>
                                <th width="10%"> @lang('common.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($itemCategories))
                            @php
                                $key = 1;
                            @endphp
                            @foreach($itemCategories as $value)
                            <tr>
                                <td>{{getNumberTranslate($key) }}</td>
                                <td>
                                    <div class="list_img_div">
                                        <img class="listImg" src="{{showImage($value->image_url??'backend/img/default.png')}}">
                                    </div>
                                </td>
                                <td>
                                <strong>-></strong> {{ $value->name }}</td>
                                </td>
                                <td>
                                    <div class="dropdown CRM_dropdown">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                            @lang('common.select')
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if (permissionCheck('blog.categories.edit'))
                                                <a class="dropdown-item" href="{{ route('blog.categories.edit',$value->id)}}"> @lang('common.edit')</a>
                                            @endif
                                            @if (permissionCheck('blog.categories.destroy'))
                                                <a class="dropdown-item" data-toggle="modal" data-target="#deleteItem_{{@$value->id}}">@lang('common.delete')</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <div class="modal fade admin-query" id="deleteItem_{{@$value->id}}" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('common.delete') @lang('common.category')</h4>
                                                <button type="button" class="close" data-dismiss="modal"><i class="ti-close"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h4>@lang('common.are_you_sure_to_delete_?')</h4>
                                                </div>
                                                <div class="mt-40 d-flex justify-content-between">
                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                                                    <form action="{{ route('blog.categories.destroy',$value->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" class="primary-btn fix-gr-bg" value="{{__('common.delete')}}"/>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            @php
                                $key += 1;
                            @endphp
                             @foreach ($value->childs as $child_account)
                               @include('blog::category.child_category', ['child_account' => $child_account])
                               @php
                                   $key += 1;
                               @endphp
                            @endforeach
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>
@endsection
@push('scripts')
<script>
    (function($){
        "use strict";
        $(document).ready(function(){
            $(document).on('change', '#blog_image', function(event){
                getFileName($('#blog_image').val(),'#image');
                imageChangeWithFile($(this)[0],'#MetaImgDiv');
            });
        });
    })(jQuery);
</script>
@endpush
