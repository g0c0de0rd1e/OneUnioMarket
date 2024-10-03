@extends('frontend.amazy.layouts.app')
@section('title')
    {{__('common.category') }}
@endsection
@push('styles')
<style>
    .category-card {
        width: 100%;
        border: 1px solid #f1f1f1;
        padding: 9px;
        border-radius: 4px;
        margin-bottom: 20px;
    }


    .parent-category {
        display: flex;
        justify-content: start;
        margin-bottom: 3px;
    }
    .category-image {
        height: 40px;
        width: 40px;
        border: 1px solid #f1f1f1;
        margin-right: 6px;
    }
    .parent-name {
        margin-top: 9px;
        color: #5d5d5d;
        font-weight: 600;
    }

    .child-categories {
        padding: 0px 6px;
    }
    .child-category {
        color: #707070;
        font-size: 14px;
        font-weight: 600;
    }
    .third-level {
        padding: 0px 0px 5px 8px;
        width: 100%;
    }
    .third-level li a{
        color: #383636;
        font-size: 13px;
    }
    .load-more {
        color: #ff2732 !important;
    }

    .load-more i {
        position: absolute;
        margin-top: 7px;
        margin-left: 7px;
    }
</style>
@endpush
@section('content')
<!-- brand_banner::start  -->
<div class="brand_banner d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="branding_text">{{ __('common.category') }}</h3>
            </div>
        </div>
    </div>
</div>
<!-- brand_banner::end  -->
<!-- prodcuts_area ::start  -->
<div class="prodcuts_area ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @foreach($categories as $category)
                    <div class="category-card">
                        @if(count($category->subCategories) > 0)
                            <div class="parent-category">
                                <a href="javascript:void(0)">
                                    <div class="parent-category">

                                        <div class="parent-img">
                                            <img src="{{ showImage($category->categoryImage->image) }}" class="category-image">
                                        </div>
                                        <div class="parent-name">
                                            {{ $category->name }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @else
                            <div class="parent-category">
                                <a href="{{route('frontend.category-product',['slug' => $category->slug, 'item' =>'category'])}}">
                                    <div class="parent-category">

                                        <div class="parent-img">
                                            <img src="{{ showImage($category->categoryImage->image) }}" class="category-image">
                                        </div>
                                        <div class="parent-name">
                                            {{ $category->name }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif


                        @if(!empty($category->subCategories))
                           @foreach($category->subCategories as $subCategory)
                                <div class="child-categories">
                                    @if(!empty($subCategory->subCategories) && count($subCategory->subCategories) > 0)
                                        <a class="child-category" href="javascript:void(0)">
                                            {{ $subCategory->name }}
                                        </a>
                                        <ul class="third-level">
                                            @foreach($subCategory->subCategories as $key => $thirdCategory)
                                                <li class="{{ $key > 4 ? 'd-none '.Str::slug($subCategory->name):'' }}">
                                                    <a  href="{{route('frontend.category-product',['slug' => $thirdCategory->slug, 'item' =>'category'])}}">{{ $thirdCategory->name }}</a>
                                                </li>
                                            @endforeach
                                            @if(count($subCategory->subCategories) > 5)
                                                <li>
                                                    <a class="load-more" data-class=".{{ Str::slug($subCategory->name) }}" href="javascript:void(0)">more <i class='fas fa-angle-down'></i></a>
                                                </li>
                                            @endif
                                        </ul>
                                    @else
                                    <a class="child-category" href="{{route('frontend.category-product',['slug' => $subCategory->slug, 'item' =>'category'])}}">
                                        {{ $subCategory->name }}
                                    </a>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-center">
                @if ($categories->lastPage() > 1)
                    <x-pagination-component :items="$categories" type="" />
                @endif
            </div>
        </div>
    </div>
    <div class="add-product-to-cart-using-modal">
    </div>

</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $(document).on('click','.load-more',function(){
            let class_name = $(this).attr('data-class');
            $(class_name).toggleClass('d-none');
            if($(this).html() == 'more <i class="fas fa-angle-down"></i>'){
                $(this).html('less <i class="fas fa-angle-up"></i>');
            }else{
                $(this).html('more <i class="fas fa-angle-down"></i>');
            }

        });

    });
</script>
@endpush
@include(theme('partials.add_to_cart_script'))
@include(theme('partials.add_to_compare_script'))
