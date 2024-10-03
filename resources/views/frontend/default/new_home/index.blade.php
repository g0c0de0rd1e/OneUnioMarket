@extends('frontend.default.layouts.app')

@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/new-home/new-home-style.css'))}}" />
@endsection

@section('share_meta')
  @php
      $tags = str_replace(',', ' ',app('general_setting')->meta_tags);
  @endphp
  <meta name="keywords" content="{{$tags}}">
  <meta name="description" content="{{app('general_setting')->meta_description}}">
  <link rel="canonical" href="{{url()->current()}}"/>
@endsection

@section('content')

 <!-- banner paer here -->
 {{-- @include('frontend.default.partials._mega_menu') --}}
  <!-- banner paer end -->

   {{-- Top Banner:Start --}}
   <div class="container banner-section-container mt-4">
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-12">
            <div class="top-categories-list">
                <div class="categories-list-title">All Categories</div>

                <ul class="category-list">
                    <li><a href="#"><i class="ti-ruler-pencil"></i> Architecture</a></li>
                    <li><a href="#"><i class="ti-paint-bucket"></i> Art & Illustration</a></li>
                    <li><a href="#"><i class="ti-briefcase"></i> Business & Corporate</a></li>
                    <li><a href="#"><i class="ti-crown"></i> Culture & Education</a></li>
                    <li><a href="#"><i class="ti-package"></i> Design and Agencis</a></li>
                    <li><a href="#"><i class="ti-bag"></i> Ecommerce</a></li>
                    <li><a href="#"><i class="ti-cup"></i> Event</a></li>
                    <li><a href="#"><i class="ti-gift"></i> Experimental</a></li>
                    <li><a href="#"><i class="ti-user"></i> Fashion</a></li>
                    <li><a href="#"><i class="ti-game"></i> Games & Entertainment</a></li>
                </ul>
            </div>
        </div>
        <div class="col-xl-6 col-lg-5 col-md-8">
        <div class="banner-section">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="single-banner-item">
                        <img src="{{asset('public/frontend/default/img/banner/banner1.png')}}" class="w-100" alt="banner image">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-6">
                    <div class="single-banner-item">
                        <img src="{{asset('public/frontend/default/img/banner/banner2.png')}}" class="w-100" alt="banner image">
                    </div>
                </div>
                <div class="col-md-6 col-6">
                    <div class="single-banner-item">
                        <img src="{{asset('public/frontend/default/img/banner/banner3.png')}}" class="w-100" alt="banner image">
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-4">
            <div class="single-banner-item">
                <img src="{{asset('public/frontend/default/img/banner/banner4.png')}}" class="w-100" alt="banner image">
            </div>
        </div>
    </div>
  </div>
  {{-- Top Banner:End --}}

  {{-- Flash Section:Start --}}
<div class="container">
<div class="flash-sale-contaienr">
<div class="flash-timer-and-button d-flex flex-wrap justify-content-between align-items-center">
    <div class="flash-timer-container">
        <div class="flash-timer">
            <div class="d-flex">
                <div class="flash-timer-left d-flex align-items-center">
                    <div class="flash-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="21" viewBox="0 0 10 21" fill="none">
                            <path d="M3 21V12H0V0H10L6 9H10L3 21Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="flash-title d-none d-sm-block">Flash Sale</div>
                </div>

                <div class="flash-timer-right d-flex">
                    <div class="clock-item day">
                        <p class="mb-0">28</p>
                        <p class="mb-0">Day</p>
                    </div>
                    <div class="clock-item hour">
                        <p class="mb-0">28</p>
                        <p class="mb-0">HR</p>
                    </div>
                    <div class="clock-item minutes">
                        <p class="mb-0">28</p>
                        <p class="mb-0">Min</p>
                    </div>
                    <div class="clock-item secondes">
                        <p class="mb-0">28</p>
                        <p class="mb-0">Sec</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="view-all-products mr-100 mt-4 mt-md-0">
        <button>
            View All
        </button>
    </div>
</div>

    <div class="flash-sale-products-slider">
        <div class="flash-sale-products-slider-item owl-carousel">
            {{-- single flash sale product:Start --}}
            <div class="single-flash-sale-item">
                <img src="https://placehold.co/400" class="flash-sale-item-image" alt="product">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <div class="flash-sale-item-name">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, odio!</div>
                        <div class="flash-sale-item-price"><span>$</span><span class="price">99.99</span></div>
                    </div>
                    <div class="flash-sale-item-offer">12% Off</div>
                </div>
            </div>
            {{-- single flash sale product:End --}}

                        {{-- single flash sale product:Start --}}
                        <div class="single-flash-sale-item">
                            <img src="https://placehold.co/400" class="flash-sale-item-image" alt="product">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <div class="flash-sale-item-name">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, odio!</div>
                                    <div class="flash-sale-item-price"><span>$</span><span class="price">99.99</span></div>
                                </div>
                                <div class="flash-sale-item-offer">12% Off</div>
                            </div>
                        </div>
                        {{-- single flash sale product:End --}}

                                    {{-- single flash sale product:Start --}}
            <div class="single-flash-sale-item">
                <img src="https://placehold.co/400" class="flash-sale-item-image" alt="product">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <div class="flash-sale-item-name">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, odio!</div>
                        <div class="flash-sale-item-price"><span>$</span><span class="price">99.99</span></div>
                    </div>
                    <div class="flash-sale-item-offer">12% Off</div>
                </div>
            </div>
            {{-- single flash sale product:End --}}

                        {{-- single flash sale product:Start --}}
                        <div class="single-flash-sale-item">
                            <img src="https://placehold.co/400" class="flash-sale-item-image" alt="product">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <div class="flash-sale-item-name">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, odio!</div>
                                    <div class="flash-sale-item-price"><span>$</span><span class="price">99.99</span></div>
                                </div>
                                <div class="flash-sale-item-offer">12% Off</div>
                            </div>
                        </div>
                        {{-- single flash sale product:End --}}

                                    {{-- single flash sale product:Start --}}
            <div class="single-flash-sale-item">
                <img src="https://placehold.co/400" class="flash-sale-item-image" alt="product">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <div class="flash-sale-item-name">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, odio!</div>
                        <div class="flash-sale-item-price"><span>$</span><span class="price">99.99</span></div>
                    </div>
                    <div class="flash-sale-item-offer">12% Off</div>
                </div>
            </div>
            {{-- single flash sale product:End --}}

                        {{-- single flash sale product:Start --}}
                        <div class="single-flash-sale-item">
                            <img src="https://placehold.co/400" class="flash-sale-item-image" alt="product">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <div class="flash-sale-item-name">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, odio!</div>
                                    <div class="flash-sale-item-price"><span>$</span><span class="price">99.99</span></div>
                                </div>
                                <div class="flash-sale-item-offer">12% Off</div>
                            </div>
                        </div>
                        {{-- single flash sale product:End --}}

                                    {{-- single flash sale product:Start --}}
            <div class="single-flash-sale-item">
                <img src="https://placehold.co/400" class="flash-sale-item-image" alt="product">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <div class="flash-sale-item-name">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, odio!</div>
                        <div class="flash-sale-item-price"><span>$</span><span class="price">99.99</span></div>
                    </div>
                    <div class="flash-sale-item-offer">12% Off</div>
                </div>
            </div>
            {{-- single flash sale product:End --}}


                        {{-- single flash sale product:Start --}}
                        <div class="single-flash-sale-item">
                            <img src="https://placehold.co/400" class="flash-sale-item-image" alt="product">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <div class="flash-sale-item-name">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa, odio!</div>
                                    <div class="flash-sale-item-price"><span>$</span><span class="price">99.99</span></div>
                                </div>
                                <div class="flash-sale-item-offer">12% Off</div>
                            </div>
                        </div>
                        {{-- single flash sale product:End --}}
        </div>
    </div>
</div>
</div>
  {{-- Flash Section:End --}}

  {{-- Category list:Start --}}
    <div class="container">
        <div class="category-list-container">
            <div class="row m-0">
            {{-- single category item:Start --}}
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 category-item">
                <div class="category-image">
                    <img src="https://placehold.co/400" alt="category image">
                </div>
                <div class="category-name">Sports and Outdoor</div>
            </div>
            {{-- Single category item:End --}}

            {{-- single category item:Start --}}
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 category-item">
                    <div class="category-image">
                        <img src="https://placehold.co/400" alt="category image">
                    </div>
                    <div class="category-name">Women Clothing & Fashion</div>
                </div>
                {{-- single category item:End --}}

                {{-- single category item:Start --}}
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 category-item">
                    <div class="category-image">
                        <img src="https://placehold.co/400" alt="category image">
                    </div>
                    <div class="category-name">Computer & Accessories</div>
                </div>
                {{-- single category item:End --}}

                {{-- single category item:Start --}}
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 category-item">
                    <div class="category-image">
                        <img src="https://placehold.co/400" alt="category image">
                    </div>
                    <div class="category-name">Beauty, Health & Hair</div>
                </div>
                {{-- single category item:End --}}

                {{-- single category item:Start --}}
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 category-item">
                    <div class="category-image">
                        <img src="https://placehold.co/400" alt="category image">
                    </div>
                    <div class="category-name">Kids & toy</div>
                </div>
                {{-- single category item:End --}}

                {{-- single category item:Start --}}
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 category-item">
                    <div class="category-image">
                        <img src="https://placehold.co/400" alt="category image">
                    </div>
                    <div class="category-name">Home Improvement & Tools</div>
                </div>
                {{-- single category item:End --}}
            </div>
        </div>
    </div>
  {{-- Category list:End --}}


  {{-- Product grid with side ad:Start --}}
  <div class="container">
    <div class="product-grid-with-sideAd">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-12 mb-5 mb-lg-0 sideAd">
                <img src="{{asset('public/frontend/default/img/banner/banner5.png')}}" alt="iamge">
            </div>
            <div class="col-xl-9 col-lg-8 col-md-12">
                <div class="row">
                    {{-- Single Product:Start --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="single-grid-product">
                        <div class="product-image-container">
                            <img src="https://placehold.co/400" alt="product image">
                            <div class="product-image-overlay">
                                <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                                <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                                <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                            </div>
                        </div>
                        <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                        <div class="d-flex justify-content-between mt-3">
                            <div class="product-price"><span>$</span><span>50.99</span></div>
                            <div class="product-rating-star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    </div>
                    {{-- Single Product:End --}}

                    {{-- Single Product:Start --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="single-grid-product">
                        <div class="label new">New</div>
                        <div class="product-image-container">
                            <img src="https://placehold.co/400" alt="product image">
                            <div class="product-image-overlay">
                                <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                                <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                                <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                            </div>
                        </div>
                        <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                        <div class="d-flex justify-content-between mt-3">
                            <div class="product-price"><span>$</span><span>50.99</span></div>
                            <div class="product-rating-star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    </div>
                    {{-- Single Product:End --}}

                    {{-- Single Product:Start --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="single-grid-product">
                        <div class="label offer">20%</div>
                        <div class="product-image-container">
                            <img src="https://placehold.co/400" alt="product image">
                            <div class="product-image-overlay">
                                <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                                <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                                <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                            </div>
                        </div>
                        <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                        <div class="d-flex justify-content-between mt-3">
                            <div class="product-price"><span>$</span><span>50.99</span></div>
                            <div class="product-rating-star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    </div>
                    {{-- Single Product:End --}}

                     {{-- Single Product:Start --}}
                     <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="single-grid-product">
                            <div class="product-image-container">
                                <img src="https://placehold.co/400" alt="product image">
                                <div class="product-image-overlay">
                                    <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                                    <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                                    <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                                </div>
                            </div>
                            <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                            <div class="d-flex justify-content-between mt-3">
                                <div class="product-price"><span>$</span><span>50.99</span></div>
                                <div class="product-rating-star">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        </div>
                        {{-- Single Product:End --}}

                        {{-- Single Product:Start --}}
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="single-grid-product">
                            <div class="label new">New</div>
                            <div class="product-image-container">
                                <img src="https://placehold.co/400" alt="product image">
                                <div class="product-image-overlay">
                                    <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                                    <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                                    <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                                </div>
                            </div>
                            <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                            <div class="d-flex justify-content-between mt-3">
                                <div class="product-price"><span>$</span><span>50.99</span></div>
                                <div class="product-rating-star">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        </div>
                        {{-- Single Product:End --}}

                        {{-- Single Product:Start --}}
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="single-grid-product">
                            <div class="label offer">20%</div>
                            <div class="product-image-container">
                                <img src="https://placehold.co/400" alt="product image">
                                <div class="product-image-overlay">
                                    <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                                    <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                                    <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                                </div>
                            </div>
                            <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                            <div class="d-flex justify-content-between mt-3">
                                <div class="product-price"><span>$</span><span>50.99</span></div>
                                <div class="product-rating-star">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        </div>
                        {{-- Single Product:End --}}

                         {{-- Single Product:Start --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="single-grid-product">
                            <div class="product-image-container">
                                <img src="https://placehold.co/400" alt="product image">
                                <div class="product-image-overlay">
                                    <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                                    <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                                    <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                                </div>
                            </div>
                            <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                            <div class="d-flex justify-content-between mt-3">
                                <div class="product-price"><span>$</span><span>50.99</span></div>
                                <div class="product-rating-star">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        </div>
                        {{-- Single Product:End --}}

                        {{-- Single Product:Start --}}
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="single-grid-product">
                            <div class="label new">New</div>
                            <div class="product-image-container">
                                <img src="https://placehold.co/400" alt="product image">
                                <div class="product-image-overlay">
                                    <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                                    <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                                    <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                                </div>
                            </div>
                            <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                            <div class="d-flex justify-content-between mt-3">
                                <div class="product-price"><span>$</span><span>50.99</span></div>
                                <div class="product-rating-star">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        </div>
                        {{-- Single Product:End --}}
                </div>
            </div>
        </div>
    </div>
  </div>
  {{-- Product grid with side ad:End --}}

  {{-- Ad Section:Start --}}

  <div class="container my-5">
    <div class="row">
        <div class="col-12">
            <img src="{{asset('public/frontend/default/img/ad.png')}}" class="w-100" alt="">
        </div>
    </div>
  </div>

  {{-- Ad Section:End --}}

{{-- Popular Product list:Start --}}
<div class="container">
    <div class="popular-product-list-section">
       <div class="row">
          {{-- Single type product list:Start --}}
          <div class="col-xl-4 col-lg-6 col-sm-12 mb-4 mb-xl-0">
            <div class="single-list-item">
            <div class="popular-section-title">Tranding Product</div>
            <div class="list-container">
            {{-- Single list item:Start --}}
            <div class="d-flex single-list-product">
                <div class="list-product-image">
                    <img src="https://placehold.co/100" alt="">
                </div>
                <div class="list-product-details">
                    <div class="product-list-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="price">
                        <span class="previous"><span>$</span><span>50.99</span></span>
                        <span class="current"><span>$</span><span>40.99</span></span>
                    </div>
                    <div class="list-product-title">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                    </div>
                </div>
            </div>
            {{-- Single list item:End --}}
            {{-- Single list item:Start --}}
            <div class="d-flex single-list-product">
                <div class="list-product-image">
                    <img src="https://placehold.co/100" alt="">
                </div>
                <div class="list-product-details">
                    <div class="product-list-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="price">
                        <span class="previous"><span>$</span><span>50.99</span></span>
                        <span class="current"><span>$</span><span>40.99</span></span>
                    </div>
                    <div class="list-product-title">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                    </div>
                </div>
            </div>
            {{-- Single list item:End --}}
            {{-- Single list item:Start --}}
            <div class="d-flex single-list-product">
                <div class="list-product-image">
                    <img src="https://placehold.co/100" alt="">
                </div>
                <div class="list-product-details">
                    <div class="product-list-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="price">
                        <span class="previous"><span>$</span><span>50.99</span></span>
                        <span class="current"><span>$</span><span>40.99</span></span>
                    </div>
                    <div class="list-product-title">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                    </div>
                </div>
            </div>
            {{-- Single list item:End --}}
            {{-- Single list item:Start --}}
            <div class="d-flex single-list-product">
                <div class="list-product-image">
                    <img src="https://placehold.co/100" alt="">
                </div>
                <div class="list-product-details">
                    <div class="product-list-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="price">
                        <span class="previous"><span>$</span><span>50.99</span></span>
                        <span class="current"><span>$</span><span>40.99</span></span>
                    </div>
                    <div class="list-product-title">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                    </div>
                </div>
            </div>
            {{-- Single list item:End --}}
            {{-- Single list item:Start --}}
            <div class="d-flex single-list-product">
                <div class="list-product-image">
                    <img src="https://placehold.co/100" alt="">
                </div>
                <div class="list-product-details">
                    <div class="product-list-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="price">
                        <span class="previous"><span>$</span><span>50.99</span></span>
                        <span class="current"><span>$</span><span>40.99</span></span>
                    </div>
                    <div class="list-product-title">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                    </div>
                </div>
            </div>
            {{-- Single list item:End --}}
            </div>
        </div>
          </div>
          {{-- Single type product list:End --}}
          {{-- Single type product list:Start --}}
          <div class="col-xl-4 col-lg-6 col-sm-12 mb-4 mb-xl-0">
            <div class="single-list-item">
                <div class="popular-section-title">Best Selling</div>
                <div class="list-container">
                   {{-- Single list item:Start --}}
                   <div class="d-flex single-list-product">
                      <div class="list-product-image">
                         <img src="https://placehold.co/100" alt="">
                      </div>
                      <div class="list-product-details">
                         <div class="product-list-rating-star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                         </div>
                         <div class="price">
                            <span class="previous"><span>$</span><span>50.99</span></span>
                            <span class="current"><span>$</span><span>40.99</span></span>
                         </div>
                         <div class="list-product-title">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                         </div>
                      </div>
                   </div>
                   {{-- Single list item:End --}}
                   {{-- Single list item:Start --}}
                   <div class="d-flex single-list-product">
                      <div class="list-product-image">
                         <img src="https://placehold.co/100" alt="">
                      </div>
                      <div class="list-product-details">
                         <div class="product-list-rating-star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                         </div>
                         <div class="price">
                            <span class="previous"><span>$</span><span>50.99</span></span>
                            <span class="current"><span>$</span><span>40.99</span></span>
                         </div>
                         <div class="list-product-title">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                         </div>
                      </div>
                   </div>
                   {{-- Single list item:End --}}
                   {{-- Single list item:Start --}}
                   <div class="d-flex single-list-product">
                      <div class="list-product-image">
                         <img src="https://placehold.co/100" alt="">
                      </div>
                      <div class="list-product-details">
                         <div class="product-list-rating-star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                         </div>
                         <div class="price">
                            <span class="previous"><span>$</span><span>50.99</span></span>
                            <span class="current"><span>$</span><span>40.99</span></span>
                         </div>
                         <div class="list-product-title">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                         </div>
                      </div>
                   </div>
                   {{-- Single list item:End --}}
                   {{-- Single list item:Start --}}
                   <div class="d-flex single-list-product">
                      <div class="list-product-image">
                         <img src="https://placehold.co/100" alt="">
                      </div>
                      <div class="list-product-details">
                         <div class="product-list-rating-star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                         </div>
                         <div class="price">
                            <span class="previous"><span>$</span><span>50.99</span></span>
                            <span class="current"><span>$</span><span>40.99</span></span>
                         </div>
                         <div class="list-product-title">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                         </div>
                      </div>
                   </div>
                   {{-- Single list item:End --}}
                   {{-- Single list item:Start --}}
                   <div class="d-flex single-list-product">
                      <div class="list-product-image">
                         <img src="https://placehold.co/100" alt="">
                      </div>
                      <div class="list-product-details">
                         <div class="product-list-rating-star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                         </div>
                         <div class="price">
                            <span class="previous"><span>$</span><span>50.99</span></span>
                            <span class="current"><span>$</span><span>40.99</span></span>
                         </div>
                         <div class="list-product-title">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                         </div>
                      </div>
                   </div>
                   {{-- Single list item:End --}}
                </div>
            </div>
          </div>
          {{-- Single type product list:End --}}
          {{-- Single type product list:Start --}}
          <div class="col-xl-4 col-lg-6 col-sm-12 mb-4 mb-xl-0">
            <div class="single-list-item">
                <div class="popular-section-title">Ecxlusive Product</div>
                <div class="list-container">
                   {{-- Single list item:Start --}}
                   <div class="d-flex single-list-product">
                      <div class="list-product-image">
                         <img src="https://placehold.co/100" alt="">
                      </div>
                      <div class="list-product-details">
                         <div class="product-list-rating-star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                         </div>
                         <div class="price">
                            <span class="previous"><span>$</span><span>50.99</span></span>
                            <span class="current"><span>$</span><span>40.99</span></span>
                         </div>
                         <div class="list-product-title">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                         </div>
                      </div>
                   </div>
                   {{-- Single list item:End --}}
                   {{-- Single list item:Start --}}
                   <div class="d-flex single-list-product">
                      <div class="list-product-image">
                         <img src="https://placehold.co/100" alt="">
                      </div>
                      <div class="list-product-details">
                         <div class="product-list-rating-star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                         </div>
                         <div class="price">
                            <span class="previous"><span>$</span><span>50.99</span></span>
                            <span class="current"><span>$</span><span>40.99</span></span>
                         </div>
                         <div class="list-product-title">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                         </div>
                      </div>
                   </div>
                   {{-- Single list item:End --}}
                   {{-- Single list item:Start --}}
                   <div class="d-flex single-list-product">
                      <div class="list-product-image">
                         <img src="https://placehold.co/100" alt="">
                      </div>
                      <div class="list-product-details">
                         <div class="product-list-rating-star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                         </div>
                         <div class="price">
                            <span class="previous"><span>$</span><span>50.99</span></span>
                            <span class="current"><span>$</span><span>40.99</span></span>
                         </div>
                         <div class="list-product-title">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                         </div>
                      </div>
                   </div>
                   {{-- Single list item:End --}}
                   {{-- Single list item:Start --}}
                   <div class="d-flex single-list-product">
                      <div class="list-product-image">
                         <img src="https://placehold.co/100" alt="">
                      </div>
                      <div class="list-product-details">
                         <div class="product-list-rating-star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                         </div>
                         <div class="price">
                            <span class="previous"><span>$</span><span>50.99</span></span>
                            <span class="current"><span>$</span><span>40.99</span></span>
                         </div>
                         <div class="list-product-title">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                         </div>
                      </div>
                   </div>
                   {{-- Single list item:End --}}
                   {{-- Single list item:Start --}}
                   <div class="d-flex single-list-product">
                      <div class="list-product-image">
                         <img src="https://placehold.co/100" alt="">
                      </div>
                      <div class="list-product-details">
                         <div class="product-list-rating-star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                         </div>
                         <div class="price">
                            <span class="previous"><span>$</span><span>50.99</span></span>
                            <span class="current"><span>$</span><span>40.99</span></span>
                         </div>
                         <div class="list-product-title">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Totam, perferendis.
                         </div>
                      </div>
                   </div>
                   {{-- Single list item:End --}}
                </div>
            </div>
          </div>
          {{-- Single type product list:End --}}
       </div>
    </div>
 </div>
 {{-- Popular Product list:End --}}


 {{-- product grid:Start --}}
    <div class="container">
<div class="product-grid">
    <div class="row">

        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}


        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}


        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}


        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}


        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}


        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}


        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}


        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}



        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}


        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}


        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}

        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}


        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}


        {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}

            {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}

            {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}

            {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}

            {{-- Single Product:Start --}}
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="single-grid-product">
                <div class="label new">New</div>
                <div class="product-image-container">
                    <img src="https://placehold.co/400" alt="product image">
                    <div class="product-image-overlay">
                        <div class="wishlist-btn"><a href="#"><i class="ti-heart"></i></a></div>
                        <div class="view-details-btn"><a href="#"><i class="ti-fullscreen"></i></a></div>
                        <div class="add-to-cart-btn"><a href="#"><i class="ti-bag"></i></a></div>
                    </div>
                </div>
                <div class="product-name"><a href="#" class="product-details-link">Lorem ipsum dolor sit Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.</a></div>
                <div class="d-flex justify-content-between mt-3">
                    <div class="product-price"><span>$</span><span>50.99</span></div>
                    <div class="product-rating-star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            </div>
            {{-- Single Product:End --}}
</div>

<div class="d-flex justify-content-center">
    <button class="loadmore-btn"><i class="ti-reload"></i> Load More</button>
</div>
</div>
    </div>
 {{-- Product grid:End --}}


    {{-- Footer Section:Start --}}
    <div class="footer-container">
        <div class="container">
        <div class="footer-highlight-section">
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-4 mb-xl-0">
                    <div class="d-flex highlight-item">
                        <div class="highlight-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <path d="M32.8998 2.34375C32.0463 2.34375 31.2462 2.57414 30.5561 2.97437V1.17188C30.5561 0.524687 30.0314 0 29.3842 0H10.6342C9.98695 0 9.46227 0.524687 9.46227 1.17188V2.98867C8.76672 2.57953 7.95742 2.34375 7.09375 2.34375C4.50906 2.34375 2.40625 4.44656 2.40625 7.03125C2.40625 9.00273 2.99047 10.9077 4.0957 12.5402C5.97727 15.3193 8.2975 16.0405 10.2174 16.8084C11.3245 19.5653 13.5631 21.7502 16.3557 22.7846L15.4916 28.2812H15.3217C13.3832 28.2812 11.8061 29.8584 11.8061 31.7969V37.6562H10.6342C9.98703 37.6562 9.46234 38.1809 9.46234 38.8281C9.46234 39.4753 9.98703 40 10.6342 40H29.3842C30.0314 40 30.5561 39.4753 30.5561 38.8281C30.5561 38.1809 30.0314 37.6562 29.3842 37.6562H28.2123V31.7969C28.2123 29.8584 26.6352 28.2812 24.6967 28.2812H24.5269L23.6628 22.7847C26.4595 21.7487 28.7006 19.5591 29.806 16.7966C31.6197 16.0711 33.9971 15.3478 35.898 12.5402C37.0032 10.9077 37.5874 9.00266 37.5874 7.03125C37.5873 4.44656 35.4845 2.34375 32.8998 2.34375ZM9.45359 13.9787C6.59625 12.8357 4.75 10.1087 4.75 7.03125C4.75 5.73891 5.80141 4.6875 7.09375 4.6875C8.38609 4.6875 9.4375 5.73891 9.4375 7.03125C9.4375 7.11367 9.44617 7.19398 9.46234 7.27156V12.8906C9.46234 13.2673 9.48258 13.6392 9.52133 14.0058L9.45359 13.9787ZM25.8686 37.6562H14.1498V35.3125H25.8686V37.6562ZM24.6967 30.625C25.3429 30.625 25.8686 31.1507 25.8686 31.7969V32.9688H14.1498V31.7969C14.1498 31.1507 14.6755 30.625 15.3217 30.625C15.9575 30.625 23.2057 30.625 24.6967 30.625ZM17.8641 28.2812L18.6395 23.3487C19.088 23.4071 19.5451 23.4375 20.0092 23.4375C20.4734 23.4375 20.9305 23.407 21.3789 23.3487L22.1544 28.2812H17.8641ZM28.2123 12.8906C28.2123 17.4138 24.5324 21.0938 20.0092 21.0938C15.486 21.0938 11.8061 17.4138 11.8061 12.8906V7.03125H28.2123V12.8906ZM28.2123 4.6875H11.8061V2.34375H28.2123V4.6875ZM30.5399 13.9787L30.4983 13.9953C30.5363 13.6322 30.556 13.2637 30.556 12.8906V7.03125C30.5561 5.73891 31.6075 4.6875 32.8998 4.6875C34.1922 4.6875 35.2436 5.73891 35.2436 7.03125C35.2436 10.1087 33.3973 12.8358 30.5399 13.9787Z" fill="white"/>
                            </svg>
                        </div>
                        <div class="highlight-section-information">
                            <div class="info-title">High Quality</div>
                            <div class="info-details">Crafted from top materials</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-4 mb-xl-0">
                    <div class="d-flex highlight-item">
                        <div class="highlight-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <g clip-path="url(#clip0_830_4331)">
                                  <path d="M37.8573 14.1742C37.3295 12.5398 37.5545 10.0864 36.1827 8.19214C34.8 6.28292 32.3952 5.74026 31.0373 4.74714C29.6938 3.76448 28.4438 1.62612 26.1837 0.88862C23.9873 0.171901 21.7414 1.14448 20 1.14448C18.2588 1.14448 16.013 0.171667 13.8163 0.888542C11.5566 1.62589 10.3056 3.76471 8.96289 4.7469C7.60648 5.73885 5.19992 6.283 3.8175 8.1919C2.4468 10.0846 2.66953 12.5436 2.14266 14.1741C1.64125 15.7259 0 17.5883 0 20.0002C0 22.4135 1.63938 24.2688 2.14266 25.8262C2.67047 27.4606 2.44547 29.9139 3.81734 31.8082C5.19992 33.7175 7.60461 34.2601 8.96266 35.2533C10.306 36.2358 11.5562 38.3743 13.8163 39.1117C16.0112 39.828 18.2606 38.8559 20 38.8559C21.737 38.8559 23.9916 39.827 26.1837 39.1118C28.4434 38.3745 29.6937 36.2361 31.0371 35.2535C32.3935 34.2615 34.8001 33.7174 36.1825 31.8085C37.5533 29.9157 37.3304 27.4569 37.8573 25.8263C38.3587 24.2744 40 22.412 40 20.0002C40 17.587 38.361 15.7323 37.8573 14.1742ZM34.8838 24.8653C34.2686 26.7696 34.4298 28.9008 33.6516 29.9753C32.863 31.0642 30.7913 31.5615 29.1926 32.7309C27.6114 33.8872 26.5032 35.7203 25.2143 36.1408C23.9949 36.5388 22.0077 35.7307 20.0001 35.7307C17.9777 35.7307 16.011 36.5405 14.7858 36.1408C13.497 35.7203 12.3904 33.8885 10.8075 32.7308C9.21828 31.5685 7.13469 31.061 6.34836 29.9752C5.57273 28.9042 5.72781 26.7583 5.11633 24.8654C4.51695 23.0108 3.125 21.4049 3.125 20.0002C3.125 18.594 4.5157 16.9937 5.11617 15.135C5.73141 13.2308 5.57023 11.0995 6.34836 10.025C7.13648 8.9369 9.20984 8.43792 10.8075 7.26948C12.3937 6.1094 13.4949 4.28073 14.7856 3.85956C16.004 3.46206 17.9977 4.26964 19.9999 4.26964C22.0259 4.26964 23.9877 3.45932 25.2142 3.85956C26.5028 4.28003 27.6104 6.11253 29.1926 7.26956C30.7816 8.43182 32.8653 8.9394 33.6516 10.0251C34.4274 11.0963 34.2715 13.24 34.8837 15.1349V15.1349C35.483 16.9896 36.875 18.5954 36.875 20.0002C36.875 21.4064 35.4843 23.0067 34.8838 24.8653ZM27.1987 14.9849C27.8089 15.5952 27.8089 16.5845 27.1987 17.1946L19.3779 25.0154C18.7677 25.6257 17.7783 25.6256 17.1681 25.0154L12.8014 20.6487C12.1912 20.0385 12.1911 19.0492 12.8013 18.439C13.4116 17.8289 14.401 17.8288 15.011 18.439L18.273 21.7009L24.9888 14.985C25.5991 14.3748 26.5884 14.3748 27.1987 14.9849Z" fill="white"/>
                                </g>
                                <defs>
                                  <clipPath id="clip0_830_4331">
                                    <rect width="40" height="40" fill="white"/>
                                  </clipPath>
                                </defs>
                              </svg>
                        </div>
                        <div class="highlight-section-information">
                            <div class="info-title">Warrany Protection</div>
                            <div class="info-details">Over 2 years</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-4 mb-xl-0">
                    <div class="d-flex highlight-item">
                        <div class="highlight-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <g clip-path="url(#clip0_830_4341)">
                                  <path d="M36.8986 20.7346V2.5198C36.8986 1.86997 36.3718 1.34314 35.722 1.34314H4.19674C3.54691 1.34314 3.02008 1.86997 3.02008 2.5198V22.1867C2.45246 22.2694 1.89755 22.4898 1.40664 22.8542C-0.140899 23.9516 -0.506918 26.4073 0.789368 27.9218L6.08928 34.347C9.36996 38.1866 12.855 38.657 18.0359 38.657C22.4819 38.657 24.4696 38.6766 28.3443 37.7937L32.1173 36.8913C32.7291 37.7456 33.7003 38.299 34.7922 38.299H36.6508C38.4975 38.299 40 36.7163 40 34.7708V24.2523C40.0001 22.3947 38.63 20.8688 36.8986 20.7346ZM31.6098 23.1551L30.042 22.3588C27.4642 21.0577 24.4839 21.0095 21.8655 22.2269C21.1511 22.5079 19.5929 23.4506 18.7847 23.4191H13.3445C11.54 23.4191 10.0718 24.8872 10.0718 26.6918V27.5499C10.0617 27.5392 10.0511 27.5291 10.0411 27.5182L6.15619 23.3013C5.9211 23.0462 5.65697 22.8326 5.37348 22.6613V10.9874H15.0027V15.3007C15.0027 15.9505 15.5295 16.4773 16.1794 16.4773H23.6042C24.254 16.4773 24.7808 15.9505 24.7808 15.3007V10.9874H34.5454V20.7346C33.1706 20.8408 32.0242 21.8243 31.6098 23.1551ZM17.356 10.9874H22.4274V14.124H17.356V10.9874ZM34.5453 8.63404H24.7808V3.69646H34.5454V8.63404H34.5453ZM22.4275 3.69646V8.63412H17.356V3.69646H22.4275ZM15.0026 3.69646V8.63412H5.3734V3.69646H15.0026ZM27.7982 35.5046C24.2188 36.3244 22.0631 36.2912 18.0781 36.2912C13.2146 36.2912 10.8646 36.2126 7.90479 32.8494L2.60488 26.4243C1.683 25.2238 3.35276 23.8067 4.4254 24.8957L8.31034 29.1127C9.3371 30.1961 10.6291 30.7923 12.2216 30.8274H22.9926C23.6425 30.8274 24.1693 30.3006 24.1693 29.6507C24.1693 29.0009 23.6425 28.4741 22.9926 28.4741H12.425V26.6916C12.425 26.1847 12.8374 25.7722 13.3444 25.7722H18.7847C20.0103 25.86 21.7793 24.8366 22.8575 24.3607C24.8186 23.4489 27.0508 23.485 28.9789 24.4581L31.4432 25.7098V34.6326L27.7982 35.5046ZM37.6467 34.7707C37.6467 35.4186 37.2 35.9456 36.6509 35.9456H34.7922C34.2431 35.9456 33.7965 35.4186 33.7965 34.7707V24.2523C33.7965 23.6044 34.2432 23.0773 34.7922 23.0773H36.6509C37.2 23.0773 37.6467 23.6044 37.6467 24.2523V34.7707Z" fill="white"/>
                                </g>
                                <defs>
                                  <clipPath id="clip0_830_4341">
                                    <rect width="40" height="40" fill="white"/>
                                  </clipPath>
                                </defs>
                              </svg>
                        </div>
                        <div class="highlight-section-information">
                            <div class="info-title">Free Shipping</div>
                            <div class="info-details">Order over 150 $</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-4 mb-xl-0">
                    <div class="d-flex highlight-item">
                        <div class="highlight-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                <path d="M36.4611 15.9752C36.1982 7.12165 28.9148 0 19.9986 0C11.0825 0 3.79909 7.12165 3.53611 15.9752L2.35156 17.1598V25.1932L3.52803 26.3696V31.8431C3.52803 35.0435 6.13164 37.6471 9.33196 37.6471H10.7892C11.2749 39.0164 12.5825 40 14.1163 40H16.4692C18.004 40 19.3123 39.015 19.7972 37.6442C19.8644 37.6454 19.9318 37.6471 19.9986 37.6471C25.68 37.6471 30.4338 33.5987 31.5268 28.2353H34.6036L37.6457 25.1932V17.1598L36.4611 15.9752ZM19.9986 2.35294C26.9814 2.35294 32.7956 7.44933 33.9191 14.1176H31.5268C30.4338 8.7542 25.68 4.70588 19.9986 4.70588C14.3172 4.70588 9.56349 8.7542 8.47047 14.1176H6.07815C7.20168 7.44933 13.0158 2.35294 19.9986 2.35294ZM29.1126 14.1176C25.3095 14.1063 22.6233 14.3379 20.4085 11.1004L19.3331 9.52839L18.4088 11.1938C17.0622 13.6204 15.2486 14.1176 12.9398 14.1176H10.8847C11.9321 10.0629 15.6211 7.05882 19.9986 7.05882C24.3761 7.05882 28.0651 10.0629 29.1126 14.1176ZM8.23392 25.8824H6.36827L4.7045 24.2186V18.1344L6.36827 16.4706H8.23392V25.8824ZM5.88097 31.8431V28.2353H8.46819C8.91109 30.4294 9.97078 32.4435 11.5407 34.0611C11.2116 34.4127 10.9534 34.8311 10.7892 35.2941H9.33196C7.42905 35.2941 5.88097 33.746 5.88097 31.8431ZM16.4692 37.6471H14.1163C13.4675 37.6471 12.9398 37.1194 12.9398 36.4706C12.9398 35.8219 13.4675 35.2941 14.1163 35.2941H16.4692C17.1179 35.2941 17.6457 35.8219 17.6457 36.4706C17.6457 37.1194 17.1179 37.6471 16.4692 37.6471ZM29.4104 25.8824C29.4104 31.072 25.1883 35.2941 19.9986 35.2941C19.9312 35.2941 19.8632 35.2928 19.7952 35.2912C19.3088 33.9234 18.0018 32.9412 16.4692 32.9412C14.0535 32.9465 14.092 32.9291 13.7909 32.9568C11.7484 31.1665 10.5869 28.6166 10.5869 25.8824V16.4706H12.9398C15.0219 16.4706 17.5576 16.1273 19.5204 13.7384C22.1102 16.4524 25.2751 16.4706 28.1161 16.4706H29.4104V25.8824ZM35.2927 24.2186L33.629 25.8824H31.7633V16.4706H33.629L35.2927 18.1344V24.2186Z" fill="white"/>
                            </svg>
                        </div>
                        <div class="highlight-section-information">
                            <div class="info-title">24 / 7 Support</div>
                            <div class="info-details">Dedicated support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 mb-4 mb-xl-0">
        <div class="main_logo">
            <a class="footer-logo" href="http://localhost:8888/365-amazcart-ecommerce">
                <svg width="266" height="67" viewBox="0 0 266 67" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_833_4251)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M93.4868 59.872V58.9393H87.2144V48.2932H86.1094V59.872H93.4868ZM96.103 59.872V51.5417H95.128V59.872H96.103ZM96.1518 49.7245V48.2932H95.0793V49.7245H96.1518ZM100.897 59.872H101.985L105.252 51.5417H104.195L101.465 58.682L98.7355 51.5417H97.6792L100.897 59.872ZM107.299 55.1279C107.341 54.7424 107.434 54.364 107.575 54.0022C107.709 53.6624 107.899 53.3471 108.138 53.0695C108.371 52.7996 108.659 52.5806 108.983 52.4262C109.34 52.2593 109.732 52.1767 110.127 52.185C110.524 52.1772 110.918 52.2569 111.28 52.4182C111.603 52.5636 111.889 52.7778 112.119 53.0453C112.347 53.3205 112.518 53.6374 112.623 53.9781C112.738 54.3506 112.795 54.7384 112.792 55.1279H107.299ZM113.832 55.932C113.845 54.431 113.52 53.2866 112.857 52.4986C112.524 52.1066 112.105 51.796 111.632 51.591C111.158 51.3859 110.643 51.292 110.127 51.3166C109.565 51.3072 109.009 51.4255 108.502 51.6623C108.033 51.8869 107.62 52.2108 107.293 52.6111C106.953 53.0297 106.694 53.5067 106.529 54.0183C106.347 54.5739 106.255 55.1549 106.259 55.739C106.256 56.3175 106.332 56.8937 106.487 57.4517C106.625 57.9537 106.863 58.4237 107.185 58.8347C107.508 59.2319 107.919 59.5486 108.388 59.7594C108.936 59.9965 109.529 60.1117 110.127 60.0971C110.601 60.106 111.074 60.0354 111.524 59.8881C111.906 59.7604 112.259 59.5611 112.564 59.3011C112.857 59.0492 113.104 58.7502 113.295 58.4166C113.496 58.0691 113.654 57.6993 113.767 57.315H112.678C112.557 57.88 112.234 58.3827 111.768 58.7302C111.291 59.0698 110.714 59.2449 110.127 59.2287C109.7 59.2371 109.277 59.1462 108.892 58.9634C108.547 58.7969 108.244 58.555 108.008 58.2558C107.765 57.9439 107.586 57.5891 107.478 57.2105C107.358 56.7948 107.298 56.3644 107.299 55.932H113.832ZM125.167 59.7836C125.641 59.5803 126.063 59.2755 126.402 58.891C126.755 58.4864 127.022 58.0162 127.189 57.508C127.381 56.9268 127.474 56.3182 127.465 55.7069C127.469 55.1252 127.39 54.546 127.231 53.9861C127.087 53.4786 126.841 53.0053 126.506 52.5951C126.175 52.1988 125.759 51.8803 125.288 51.6623C124.746 51.4341 124.163 51.3166 123.573 51.3166C122.984 51.3166 122.401 51.4341 121.859 51.6623C121.387 51.8813 120.97 52.2029 120.64 52.6031C120.307 53.0152 120.059 53.4877 119.909 53.9942C119.743 54.55 119.661 55.1272 119.665 55.7069C119.653 56.3578 119.757 57.0058 119.974 57.6206C120.156 58.1282 120.442 58.5934 120.813 58.9875C121.158 59.348 121.58 59.6282 122.048 59.8077C122.532 59.9922 123.046 60.0902 123.565 60.0971C124.116 60.1039 124.661 59.9971 125.167 59.7836ZM126.263 57.0095C126.162 57.4109 125.992 57.7919 125.759 58.1352C125.532 58.4663 125.229 58.7392 124.875 58.9312C124.471 59.1391 124.02 59.2415 123.565 59.2287C123.139 59.2372 122.717 59.1492 122.33 58.9714C121.979 58.8038 121.672 58.5557 121.437 58.2477C121.187 57.9121 121.002 57.533 120.894 57.1301C120.764 56.6668 120.7 56.1877 120.705 55.7069C120.705 55.265 120.759 54.8248 120.868 54.3962C120.967 53.9945 121.138 53.6135 121.372 53.2705C121.6 52.9424 121.904 52.6724 122.259 52.4825C122.662 52.2748 123.111 52.1723 123.565 52.185C124.02 52.171 124.471 52.2647 124.881 52.4584C125.231 52.6337 125.532 52.8903 125.759 53.2062C125.997 53.5439 126.168 53.9231 126.263 54.3238C126.375 54.7763 126.43 55.2409 126.425 55.7069C126.428 56.1462 126.373 56.5839 126.263 57.0095ZM130.211 55.3852C130.211 55.0958 130.224 54.8278 130.244 54.5811C130.27 54.3174 130.33 54.058 130.423 53.8092C130.502 53.5916 130.611 53.3859 130.748 53.1981C130.892 53.0025 131.065 52.8291 131.261 52.6835C131.466 52.5308 131.693 52.4089 131.934 52.3217C132.2 52.228 132.48 52.1817 132.763 52.185C133.543 52.185 134.101 52.3726 134.436 52.7478C134.808 53.2304 134.987 53.8314 134.94 54.4364V59.872H135.915V54.4203C135.915 54.0899 135.897 53.7597 135.86 53.4313C135.815 53.0981 135.689 52.7807 135.493 52.5066C135.222 52.0931 134.831 51.7707 134.371 51.5819C133.911 51.4018 133.42 51.3117 132.925 51.3166C132.398 51.3014 131.877 51.4353 131.424 51.7025C130.978 51.982 130.571 52.3171 130.211 52.6996V51.5417H129.236V59.872H130.211V55.3852ZM147.706 59.7836C148.179 59.5803 148.601 59.2755 148.941 58.891C149.294 58.4864 149.561 58.0162 149.727 57.508C149.919 56.9268 150.013 56.3182 150.004 55.7069C150.008 55.1252 149.929 54.546 149.77 53.9861C149.626 53.4786 149.379 53.0053 149.045 52.5951C148.713 52.1988 148.297 51.8803 147.826 51.6623C147.284 51.4341 146.701 51.3166 146.112 51.3166C145.523 51.3166 144.94 51.4341 144.398 51.6623C143.925 51.8813 143.508 52.2029 143.179 52.6031C142.846 53.0152 142.597 53.4877 142.448 53.9942C142.281 54.55 142.199 55.1272 142.204 55.7069C142.191 56.3578 142.296 57.0058 142.513 57.6206C142.695 58.1282 142.98 58.5934 143.351 58.9875C143.696 59.348 144.118 59.6282 144.586 59.8077C145.071 59.9922 145.585 60.0902 146.104 60.0971C146.654 60.1039 147.2 59.9971 147.706 59.7836ZM148.801 57.0095C148.701 57.4109 148.53 57.7919 148.297 58.1352C148.071 58.4663 147.768 58.7392 147.413 58.9312C147.01 59.1391 146.559 59.2415 146.104 59.2287C145.678 59.2372 145.255 59.1492 144.869 58.9714C144.517 58.8038 144.211 58.5557 143.975 58.2477C143.725 57.9121 143.541 57.533 143.432 57.1301C143.302 56.6668 143.239 56.1877 143.244 55.7069C143.243 55.265 143.298 54.8248 143.406 54.3962C143.506 53.9945 143.676 53.6135 143.91 53.2705C144.139 52.9424 144.443 52.6724 144.797 52.4825C145.2 52.2748 145.65 52.1723 146.104 52.185C146.558 52.171 147.01 52.2647 147.42 52.4584C147.769 52.6337 148.07 52.8903 148.297 53.2062C148.535 53.5439 148.706 53.9231 148.801 54.3238C148.913 54.7763 148.968 55.2409 148.964 55.7069C148.966 56.1462 148.912 56.5839 148.801 57.0095ZM152.75 55.3852C152.75 55.0958 152.763 54.8278 152.782 54.5811C152.809 54.3174 152.869 54.058 152.961 53.8092C153.04 53.5916 153.15 53.3859 153.286 53.1981C153.431 53.0025 153.604 52.8291 153.8 52.6835C154.005 52.5308 154.231 52.4089 154.472 52.3217C154.738 52.228 155.019 52.1817 155.301 52.185C156.081 52.185 156.639 52.3726 156.975 52.7478C157.347 53.2304 157.526 53.8314 157.479 54.4364V59.872H158.454V54.4203C158.454 54.0899 158.435 53.7597 158.398 53.4313C158.354 53.0981 158.228 52.7807 158.031 52.5066C157.761 52.0931 157.37 51.7707 156.91 51.5819C156.45 51.4018 155.959 51.3117 155.464 51.3166C154.936 51.3014 154.415 51.4353 153.962 51.7025C153.517 51.982 153.109 52.3171 152.75 52.6996V51.5417H151.775V59.872H152.75V55.3852ZM161.915 59.872V48.2932H160.94V59.872H161.915ZM165.214 59.872V51.5417H164.239V59.872H165.214ZM165.262 49.7245V48.2932H164.19V49.7245H165.262ZM168.659 55.3852C168.659 55.0958 168.672 54.8278 168.691 54.5811C168.717 54.3174 168.777 54.058 168.87 53.8092C168.949 53.5916 169.058 53.3859 169.195 53.1981C169.339 53.0025 169.512 52.8291 169.708 52.6835C169.913 52.5308 170.14 52.4089 170.381 52.3217C170.647 52.228 170.927 52.1817 171.21 52.185C171.99 52.185 172.548 52.3726 172.883 52.7478C173.255 53.2304 173.435 53.8314 173.387 54.4364V59.872H174.362V54.4203C174.362 54.0899 174.344 53.7597 174.307 53.4313C174.262 53.0981 174.136 52.7807 173.94 52.5066C173.669 52.0931 173.278 51.7707 172.818 51.5819C172.358 51.4018 171.867 51.3117 171.372 51.3166C170.845 51.3014 170.324 51.4353 169.871 51.7025C169.425 51.982 169.018 52.3171 168.659 52.6996V51.5417H167.684V59.872H168.659V55.3852ZM177.303 55.1279C177.346 54.7424 177.439 54.364 177.58 54.0022C177.713 53.6624 177.903 53.3471 178.142 53.0695C178.376 52.7996 178.663 52.5806 178.987 52.4262C179.344 52.2593 179.736 52.1767 180.131 52.185C180.528 52.1772 180.922 52.2569 181.285 52.4182C181.607 52.5636 181.894 52.7778 182.123 53.0453C182.351 53.3205 182.523 53.6374 182.627 53.9781C182.742 54.3506 182.799 54.7384 182.796 55.1279H177.303ZM183.836 55.932C183.849 54.431 183.524 53.2866 182.861 52.4986C182.529 52.1066 182.109 51.796 181.636 51.591C181.162 51.3859 180.647 51.292 180.131 51.3166C179.57 51.3072 179.014 51.4255 178.506 51.6623C178.037 51.8869 177.625 52.2108 177.297 52.6111C176.957 53.0297 176.698 53.5067 176.533 54.0183C176.351 54.5739 176.26 55.1549 176.263 55.739C176.26 56.3175 176.337 56.8937 176.491 57.4517C176.63 57.9537 176.867 58.4237 177.19 58.8347C177.512 59.2319 177.924 59.5486 178.392 59.7594C178.94 59.9965 179.533 60.1117 180.131 60.0971C180.605 60.106 181.078 60.0354 181.528 59.8881C181.91 59.7604 182.263 59.5611 182.568 59.3011C182.861 59.0492 183.108 58.7502 183.3 58.4166C183.5 58.0691 183.658 57.6993 183.771 57.315H182.682C182.561 57.88 182.238 58.3827 181.772 58.7302C181.295 59.0698 180.718 59.2449 180.131 59.2287C179.704 59.2371 179.281 59.1462 178.896 58.9634C178.551 58.7969 178.249 58.555 178.012 58.2558C177.77 57.9439 177.59 57.5891 177.482 57.2105C177.362 56.7948 177.302 56.3644 177.303 55.932H183.836ZM189.8 57.2668C189.819 57.6489 189.907 58.0246 190.06 58.3764C190.209 58.7149 190.424 59.0209 190.693 59.277C190.977 59.5418 191.312 59.747 191.678 59.88C192.102 60.0315 192.55 60.1051 193.001 60.0971C193.464 60.1011 193.925 60.0498 194.376 59.9444C194.76 59.8563 195.125 59.7011 195.455 59.486C195.751 59.2915 195.996 59.0296 196.17 58.7222C196.348 58.3998 196.438 58.0364 196.43 57.6688C196.457 57.2168 196.316 56.7706 196.033 56.4144C195.756 56.1062 195.415 55.8619 195.032 55.6988C194.615 55.5162 194.179 55.3787 193.732 55.2887C193.267 55.1922 192.835 55.0826 192.432 54.9591C192.074 54.8567 191.736 54.6934 191.434 54.4766C191.302 54.3764 191.196 54.2456 191.126 54.0956C191.057 53.9456 191.025 53.7811 191.035 53.6162C191.028 53.4177 191.069 53.2205 191.154 53.0404C191.239 52.8603 191.365 52.7023 191.522 52.579C191.933 52.2904 192.433 52.1513 192.936 52.185C193.476 52.1646 194.011 52.3016 194.473 52.579C194.69 52.737 194.869 52.941 194.997 53.176C195.124 53.4111 195.198 53.6714 195.211 53.9379H196.202C196.085 52.9944 195.742 52.3217 195.172 51.9196C194.514 51.4925 193.738 51.2815 192.952 51.3166C192.166 51.2665 191.389 51.504 190.768 51.984C190.518 52.1938 190.318 52.4567 190.184 52.7532C190.05 53.0496 189.986 53.3721 189.995 53.6967C189.965 54.1544 190.108 54.6068 190.394 54.9671C190.667 55.2729 191.009 55.51 191.392 55.6586C191.811 55.8241 192.247 55.9454 192.692 56.0205C193.13 56.0943 193.564 56.1909 193.992 56.3099C194.352 56.4028 194.691 56.5609 194.993 56.7763C195.128 56.885 195.235 57.0243 195.304 57.1825C195.373 57.3407 195.402 57.513 195.389 57.6849C195.391 57.8851 195.346 58.083 195.259 58.2638C195.169 58.4519 195.039 58.619 194.879 58.7543C194.69 58.9103 194.471 59.0278 194.236 59.1001C193.936 59.1917 193.623 59.2351 193.31 59.2287C192.711 59.2668 192.115 59.1116 191.613 58.7865C191.162 58.3953 190.87 57.8552 190.791 57.2668H189.8ZM199.322 59.872V55.3852C199.322 55.0958 199.335 54.8278 199.354 54.5811C199.381 54.3174 199.441 54.058 199.533 53.8092C199.612 53.5916 199.722 53.3859 199.858 53.1981C200.003 53.0025 200.176 52.8291 200.372 52.6835C200.577 52.5308 200.803 52.4089 201.044 52.3217C201.31 52.228 201.591 52.1817 201.873 52.185C202.653 52.185 203.211 52.3726 203.547 52.7478C203.919 53.2304 204.098 53.8314 204.051 54.4364V59.872H205.026V54.4203C205.026 54.0899 205.007 53.7597 204.97 53.4313C204.926 53.0981 204.8 52.7807 204.603 52.5066C204.333 52.0931 203.942 51.7707 203.482 51.5819C203.022 51.4018 202.531 51.3117 202.036 51.3166C201.508 51.3014 200.987 51.4353 200.534 51.7025C200.089 51.982 199.681 52.3171 199.322 52.6996V48.2932H198.347V59.872H199.322ZM212.315 59.7836C212.789 59.5803 213.211 59.2755 213.55 58.891C213.903 58.4864 214.17 58.0162 214.337 57.508C214.529 56.9268 214.622 56.3182 214.613 55.7069C214.617 55.1252 214.538 54.546 214.379 53.9861C214.235 53.4786 213.989 53.0053 213.654 52.5951C213.323 52.1988 212.907 51.8803 212.436 51.6623C211.893 51.4341 211.31 51.3166 210.721 51.3166C210.132 51.3166 209.549 51.4341 209.007 51.6623C208.534 51.8813 208.118 52.2029 207.788 52.6031C207.455 53.0152 207.207 53.4877 207.057 53.9942C206.891 54.55 206.809 55.1272 206.813 55.7069C206.801 56.3578 206.905 57.0058 207.122 57.6206C207.304 58.1282 207.589 58.5934 207.96 58.9875C208.306 59.348 208.727 59.6282 209.195 59.8077C209.68 59.9922 210.194 60.0902 210.713 60.0971C211.263 60.1039 211.809 59.9971 212.315 59.7836ZM213.411 57.0095C213.31 57.4109 213.14 57.7919 212.907 58.1352C212.68 58.4663 212.377 58.7392 212.023 58.9312C211.619 59.1391 211.168 59.2415 210.713 59.2287C210.287 59.2372 209.865 59.1492 209.478 58.9714C209.126 58.8038 208.82 58.5557 208.584 58.2477C208.334 57.9121 208.15 57.533 208.042 57.1301C207.912 56.6668 207.848 56.1877 207.853 55.7069C207.853 55.265 207.907 54.8248 208.016 54.3962C208.115 53.9945 208.286 53.6135 208.519 53.2705C208.748 52.9424 209.052 52.6724 209.407 52.4825C209.809 52.2748 210.259 52.1723 210.713 52.185C211.168 52.171 211.619 52.2647 212.029 52.4584C212.379 52.6337 212.68 52.8903 212.907 53.2062C213.145 53.5439 213.315 53.9231 213.411 54.3238C213.523 54.7763 213.577 55.2409 213.573 55.7069C213.576 56.1462 213.521 56.5839 213.411 57.0095ZM217.662 54.3319C217.771 53.927 217.955 53.5454 218.204 53.2062C218.441 52.8926 218.746 52.6368 219.098 52.4584C219.476 52.2715 219.894 52.1777 220.317 52.185C220.707 52.1805 221.094 52.2544 221.454 52.4021C221.8 52.5462 222.111 52.7629 222.364 53.0373C222.635 53.3335 222.843 53.6809 222.975 54.0585C223.128 54.5063 223.202 54.9769 223.193 55.4495C223.219 55.9436 223.175 56.4389 223.063 56.921C222.968 57.3495 222.792 57.7561 222.543 58.1191C222.309 58.4596 221.994 58.7384 221.626 58.9312C221.222 59.137 220.772 59.2393 220.317 59.2287C219.902 59.2355 219.491 59.1387 219.124 58.9473C218.774 58.7626 218.469 58.5047 218.23 58.1915C217.977 57.858 217.787 57.4821 217.668 57.0818C217.536 56.6462 217.471 56.1937 217.473 55.739C217.469 55.2635 217.532 54.7898 217.662 54.3319ZM217.473 58.5372C217.778 59.0439 218.228 59.4496 218.767 59.7031C219.299 59.9626 219.885 60.0974 220.479 60.0971C221.056 60.1112 221.628 59.987 222.146 59.7353C222.605 59.5048 223.005 59.175 223.316 58.7704C223.635 58.3494 223.869 57.8717 224.005 57.3633C224.159 56.8188 224.235 56.256 224.233 55.6908C224.238 55.1106 224.167 54.5322 224.022 53.97C223.897 53.4653 223.668 52.9916 223.349 52.579C223.035 52.1833 222.63 51.8665 222.169 51.6543C221.622 51.4147 221.028 51.2993 220.431 51.3166C220.15 51.318 219.872 51.3558 219.602 51.4291C219.317 51.5056 219.043 51.6135 218.783 51.7508C218.514 51.8917 218.268 52.0705 218.052 52.2815C217.832 52.4923 217.647 52.7366 217.506 53.0051H217.473V51.5417H216.498V63.1526H217.473V58.5372ZM227.574 54.3319C227.684 53.927 227.868 53.5454 228.117 53.2062C228.353 52.8926 228.659 52.6368 229.01 52.4584C229.389 52.2715 229.807 52.1777 230.229 52.185C230.619 52.1805 231.006 52.2544 231.367 52.4021C231.713 52.5462 232.023 52.7629 232.277 53.0373C232.548 53.3335 232.755 53.6809 232.888 54.0585C233.041 54.5063 233.114 54.9769 233.105 55.4495C233.132 55.9436 233.088 56.4389 232.975 56.921C232.881 57.3495 232.704 57.7561 232.455 58.1191C232.221 58.4596 231.907 58.7384 231.539 58.9312C231.134 59.137 230.684 59.2393 230.229 59.2287C229.814 59.2355 229.404 59.1387 229.036 58.9473C228.687 58.7626 228.382 58.5047 228.143 58.1915C227.89 57.858 227.699 57.4821 227.58 57.0818C227.449 56.6462 227.383 56.1937 227.385 55.739C227.381 55.2635 227.445 54.7898 227.574 54.3319ZM227.385 58.5372C227.691 59.0439 228.141 59.4496 228.679 59.7031C229.212 59.9626 229.798 60.0974 230.392 60.0971C230.969 60.1112 231.541 59.987 232.059 59.7353C232.517 59.5048 232.917 59.175 233.229 58.7704C233.548 58.3494 233.781 57.8717 233.918 57.3633C234.071 56.8188 234.148 56.256 234.145 55.6908C234.15 55.1106 234.079 54.5322 233.934 53.97C233.809 53.4653 233.58 52.9916 233.261 52.579C232.947 52.1833 232.543 51.8665 232.082 51.6543C231.535 51.4147 230.941 51.2993 230.343 51.3166C230.063 51.318 229.784 51.3558 229.514 51.4291C229.23 51.5056 228.955 51.6135 228.695 51.7508C228.427 51.8917 228.18 52.0705 227.964 52.2815C227.744 52.4923 227.56 52.7366 227.418 53.0051H227.385V51.5417H226.41V63.1526H227.385V58.5372ZM237.038 59.872V51.5417H236.063V59.872H237.038ZM237.087 49.7245V48.2932H236.014V49.7245H237.087ZM240.483 55.3852C240.483 55.0958 240.496 54.8278 240.515 54.5811C240.541 54.3174 240.602 54.058 240.694 53.8092C240.773 53.5916 240.883 53.3859 241.019 53.1981C241.164 53.0025 241.337 52.8291 241.533 52.6835C241.738 52.5308 241.964 52.4089 242.205 52.3217C242.471 52.228 242.752 52.1817 243.034 52.185C243.814 52.185 244.372 52.3726 244.708 52.7478C245.079 53.2304 245.259 53.8314 245.212 54.4364V59.872H246.186V54.4203C246.187 54.0899 246.168 53.7597 246.131 53.4313C246.087 53.0981 245.961 52.7807 245.764 52.5066C245.493 52.0931 245.102 51.7707 244.643 51.5819C244.183 51.4018 243.691 51.3117 243.197 51.3166C242.669 51.3014 242.148 51.4353 241.695 51.7025C241.249 51.982 240.842 52.3171 240.483 52.6996V51.5417H239.508V59.872H240.483V55.3852ZM254.831 57.0818C254.714 57.4819 254.524 57.8578 254.272 58.1915C254.033 58.504 253.728 58.7617 253.379 58.9473C253.01 59.1387 252.599 59.2355 252.183 59.2287C251.726 59.2404 251.273 59.138 250.866 58.9312C250.503 58.7355 250.191 58.4572 249.956 58.1191C249.71 57.7547 249.534 57.3486 249.436 56.921C249.327 56.4384 249.284 55.9436 249.306 55.4495C249.298 54.9767 249.373 54.5061 249.527 54.0585C249.658 53.6811 249.865 53.3337 250.135 53.0373C250.389 52.7636 250.699 52.547 251.045 52.4021C251.406 52.255 251.793 52.1811 252.183 52.185C252.605 52.1777 253.023 52.2715 253.401 52.4584C253.754 52.6359 254.06 52.8919 254.295 53.2062C254.545 53.5452 254.73 53.9268 254.841 54.3319C254.968 54.7903 255.03 55.2638 255.026 55.739C255.029 56.1937 254.963 56.6462 254.831 57.0818ZM255.026 53.0051H254.994C254.853 52.7367 254.67 52.4924 254.451 52.2815C254.233 52.0719 253.987 51.8933 253.72 51.7508C253.459 51.6135 253.183 51.5056 252.898 51.4291C252.628 51.3554 252.349 51.3176 252.069 51.3166C251.471 51.2996 250.877 51.415 250.33 51.6543C249.87 51.8674 249.468 52.1841 249.154 52.579C248.835 52.9922 248.605 53.4656 248.478 53.97C248.334 54.5325 248.263 55.1107 248.266 55.6908C248.266 56.2559 248.342 56.8185 248.494 57.3633C248.633 57.8714 248.868 58.3488 249.186 58.7704C249.498 59.175 249.898 59.5048 250.356 59.7353C250.873 59.9867 251.444 60.1108 252.02 60.0971C252.615 60.0974 253.202 59.9626 253.736 59.7031C254.273 59.4495 254.722 59.0437 255.026 58.5372C255.039 59.0101 255.015 59.4832 254.955 59.9524C254.903 60.3868 254.768 60.8072 254.555 61.1907C254.342 61.5642 254.026 61.8707 253.645 62.0752C253.153 62.3214 252.604 62.4378 252.053 62.4129C251.77 62.4135 251.487 62.392 251.208 62.3486C250.951 62.3099 250.702 62.2312 250.47 62.1154C250.246 62.0024 250.049 61.8434 249.891 61.649C249.717 61.4234 249.595 61.1626 249.534 60.8851H248.494C248.516 61.164 248.597 61.4352 248.731 61.6812C248.89 61.9805 249.108 62.2456 249.371 62.4611C249.696 62.7195 250.065 62.9183 250.46 63.0481C250.974 63.2141 251.512 63.2929 252.053 63.2813C252.725 63.3054 253.396 63.1875 254.019 62.9355C254.492 62.7331 254.906 62.4149 255.221 62.0109C255.52 61.612 255.729 61.1539 255.832 60.668C255.947 60.1423 256.004 59.6058 256.001 59.0679V51.5417H255.026V53.0051Z" fill="white"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M105.417 30.3891H111.602L101.936 3.38257H95.4947L85.7578 30.3891H91.7182L93.6065 24.8374H103.659L105.417 30.3891ZM95.1437 20.1837L98.6602 9.55696L102.066 20.1837H95.1437ZM126.337 18.498V30.3891H131.651V18.498C131.631 17.7137 131.776 16.9339 132.076 16.208C132.632 15.0109 133.638 14.4123 135.096 14.4123C136.352 14.4123 137.217 14.8764 137.689 15.8047C137.954 16.3919 138.079 17.0311 138.056 17.6737V30.3891H143.464L143.5 17.802C143.521 16.8153 143.459 15.8285 143.315 14.852C143.153 13.9162 142.759 13.0348 142.167 12.287C141.553 11.4991 140.743 10.8808 139.818 10.4913C138.983 10.1548 138.09 9.98007 137.189 9.97669C135.929 9.95972 134.684 10.2426 133.558 10.8014C132.475 11.4098 131.584 12.3042 130.984 13.3847C130.621 12.4508 130.023 11.6244 129.246 10.9844C128.293 10.3128 127.046 9.97691 125.505 9.97669C123.877 9.97669 122.55 10.3676 121.524 11.1494C120.783 11.778 120.158 12.5279 119.674 13.3664V10.453H114.546V30.3875H119.895V18.37C119.895 17.2829 120.037 16.4645 120.321 15.9147C120.841 14.9498 121.853 14.4673 123.357 14.4673C124.653 14.4673 125.524 14.9498 125.97 15.9147C126.213 16.4525 126.336 17.3136 126.337 18.498ZM147.631 16.8857H152.72C152.8 16.2207 153.055 15.5883 153.461 15.0524C153.981 14.4413 154.862 14.1364 156.11 14.1364C157.218 14.1364 158.063 14.292 158.635 14.6034C159.207 14.9147 159.496 15.4802 159.496 16.2984C159.496 16.9702 159.12 17.4648 158.369 17.7824C157.694 18.0242 156.99 18.1782 156.276 18.2404L154.478 18.4601C152.444 18.7174 150.901 19.1449 149.85 19.7427C147.936 20.8421 146.98 22.6193 146.981 25.0745C146.981 26.968 147.577 28.4307 148.768 29.4625C149.96 30.4943 151.469 31.0104 153.295 31.0108C154.643 31.0316 155.973 30.6964 157.147 30.0398C158.081 29.5018 158.929 28.8286 159.662 28.0425C159.701 28.4947 159.75 28.8977 159.812 29.2518C159.883 29.641 159.995 30.0217 160.146 30.3878H165.882V29.6185C165.574 29.4886 165.306 29.2799 165.106 29.0138C164.886 28.5824 164.778 28.104 164.79 27.6211C164.768 26.7174 164.756 25.9479 164.755 25.3128V16.153C164.755 13.747 163.897 12.1102 162.181 11.2426C160.352 10.35 158.334 9.90387 156.295 9.94163C152.899 9.94163 150.504 10.8208 149.109 12.579C148.235 13.7032 147.742 15.1385 147.631 16.8847V16.8857ZM152.275 24.6911C152.25 24.2456 152.351 23.8022 152.567 23.4106C152.783 23.0189 153.105 22.6946 153.497 22.4741C154.248 22.1086 155.055 21.8672 155.886 21.7594L157.072 21.5397C157.547 21.46 158.015 21.3405 158.469 21.1824C158.821 21.0479 159.159 20.879 159.477 20.6784V22.6207C159.441 24.3676 158.945 25.5707 157.988 26.2301C157.072 26.8773 155.974 27.2233 154.849 27.2194C154.191 27.2386 153.548 27.0241 153.035 26.6148C152.528 26.2239 152.275 25.5826 152.275 24.6911ZM185.009 26.1018H174.42L184.658 14.7603V10.4183H168.291V14.669H177.937L167.589 26.3218V30.3891H185.009V26.1024V26.1018ZM202.994 11.6283C201.385 10.5047 199.315 9.94281 196.783 9.94259C193.809 9.94259 191.477 10.8954 189.786 12.801C188.095 14.7065 187.249 17.3754 187.248 20.8077C187.248 23.849 188.014 26.3225 189.545 28.2281C191.077 30.1336 193.465 31.0864 196.708 31.0864C199.955 31.0864 202.406 29.9443 204.06 27.6601C205.056 26.3491 205.658 24.7871 205.799 23.153H200.413C200.348 24.079 200.02 24.9681 199.468 25.718C198.951 26.3778 198.074 26.7076 196.838 26.7074C195.1 26.7074 193.915 25.8768 193.283 24.2157C192.9 23.0767 192.725 21.8792 192.766 20.6793C192.724 19.4255 192.898 18.1737 193.283 16.9783C193.939 15.2318 195.156 14.3585 196.933 14.3583C198.177 14.3583 199.096 14.7614 199.689 15.5676C200.1 16.1704 200.36 16.8611 200.449 17.583H205.854C205.558 14.7365 204.605 12.7518 202.994 11.6289V11.6283ZM208.763 16.8866H213.852C213.932 16.2217 214.187 15.5893 214.593 15.0533C215.113 14.4422 215.994 14.1373 217.242 14.1373C218.353 14.1373 219.195 14.293 219.767 14.6043C220.342 14.9161 220.629 15.4811 220.628 16.2993C220.628 16.9711 220.252 17.4658 219.5 17.7834C218.826 18.0256 218.122 18.1795 217.407 18.2414L215.613 18.461C213.577 18.7184 212.033 19.1459 210.982 19.7437C209.071 20.8431 208.115 22.6203 208.113 25.0754C208.113 26.969 208.708 28.4317 209.9 29.4635C211.092 30.4953 212.601 31.0114 214.427 31.0118C215.775 31.0325 217.105 30.6974 218.278 30.0408C219.213 29.502 220.062 28.8289 220.797 28.0435C220.833 28.4957 220.882 28.8988 220.943 29.2528C221.015 29.642 221.127 30.0227 221.278 30.3888H227.018V29.6195C226.708 29.4896 226.439 29.281 226.238 29.0148C226.018 28.5835 225.911 28.1048 225.926 27.6221C225.9 26.7183 225.887 25.9489 225.887 25.3138V16.153C225.887 13.747 225.029 12.1102 223.313 11.2426C221.484 10.3496 219.466 9.90351 217.427 9.94163C214.031 9.94163 211.637 10.8208 210.244 12.579C209.367 13.7032 208.873 15.1385 208.763 16.8847V16.8866ZM213.41 24.692C213.385 24.2465 213.485 23.8028 213.701 23.411C213.917 23.0192 214.24 22.695 214.632 22.475C215.383 22.109 216.19 21.8676 217.021 21.7604L218.204 21.5407C218.679 21.4614 219.147 21.3418 219.601 21.1833C219.954 21.0489 220.293 20.88 220.612 20.6793V22.6217C220.573 24.3686 220.076 25.5717 219.12 26.2311C218.205 26.8777 217.108 27.2238 215.984 27.2204C215.325 27.2401 214.68 27.0256 214.167 26.6157C213.66 26.2249 213.41 25.5836 213.41 24.692ZM241.347 15.256C241.607 15.2684 241.902 15.2929 242.234 15.3293V9.9783C242 9.9664 241.85 9.95739 241.782 9.95096C241.714 9.94452 241.629 9.94163 241.532 9.94163C239.952 9.94163 238.669 10.3509 237.681 11.1693C237.076 11.6582 236.367 12.5682 235.552 13.8993V10.4183H230.515V30.3891H235.828V20.8434C235.828 19.2431 236.032 18.0584 236.439 17.289C237.167 15.9212 238.593 15.2372 240.716 15.237C240.875 15.237 241.087 15.2431 241.347 15.255V15.256ZM254.038 26.6984C253.859 26.7045 253.69 26.7074 253.528 26.7074C252.455 26.7074 251.812 26.6067 251.604 26.4051C251.396 26.2034 251.288 25.6936 251.288 24.875V14.3207H254.564V10.6013H251.288V5.03159H246.069V10.6013H243.254V14.3207H246.069V26.6148C246.069 27.8608 246.365 28.7828 246.956 29.3808C247.869 30.3215 249.572 30.749 252.065 30.6635L254.564 30.5718V26.6698C254.392 26.682 254.217 26.6912 254.038 26.6974V26.6984Z" fill="white"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 5.99548C0 2.68177 2.68629 -0.0045166 6 -0.0045166H61.7065C65.0202 -0.0045166 67.7065 2.68177 67.7065 5.99548V61.0016C67.7065 64.3153 65.0202 67.0016 61.7065 67.0016H6C2.6863 67.0016 0 64.3153 0 61.0016V5.99548Z" fill="#FF0027"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M27.2455 50.7074C26.5034 50.4394 25.8222 50.029 25.2409 49.4998C24.6595 48.9705 24.1896 48.3328 23.858 47.6233C23.5264 46.9137 23.3398 46.1464 23.3087 45.3653C23.2776 44.5841 23.4028 43.8046 23.677 43.0715L31.9677 21.6241C32.5298 20.1426 33.6618 18.9416 35.1161 18.2837C36.5704 17.6259 38.2288 17.5646 39.7286 18.1134C40.4706 18.3813 41.1518 18.7916 41.7331 19.3209C42.3143 19.8501 42.7841 20.4879 43.1154 21.1974C43.4467 21.907 43.6331 22.6744 43.6637 23.4554C43.6943 24.2365 43.5686 25.0159 43.2938 25.7487L35.0064 47.1961C34.4442 48.6776 33.3123 49.8786 31.858 50.5365C30.4037 51.1945 28.7454 51.2559 27.2455 50.7074ZM24.041 24.7516L18.7923 38.3203L13.9206 25.7487C13.646 25.0157 13.5206 24.2362 13.5515 23.4551C13.5823 22.674 13.769 21.9066 14.1006 21.1971C14.4322 20.4876 14.9023 19.85 15.4839 19.321C16.0654 18.7919 16.7469 18.3819 17.4891 18.1144C17.6191 18.0671 17.7523 18.0243 17.8823 17.9858C21.9285 16.8073 25.5425 20.8708 24.041 24.7516ZM59.5826 51.0776H19.9168C19.7115 51.078 19.5082 51.0384 19.3184 50.9611C19.1285 50.8837 18.9559 50.7701 18.8105 50.6268C18.665 50.4834 18.5495 50.3131 18.4706 50.1255C18.3916 49.938 18.3507 49.7369 18.3503 49.5338C18.3507 49.3306 18.3916 49.1295 18.4706 48.942C18.5495 48.7544 18.665 48.5841 18.8105 48.4408C18.9559 48.2974 19.1285 48.1838 19.3184 48.1064C19.5082 48.0291 19.7115 47.9895 19.9168 47.9899H59.5826C59.7879 47.9895 59.9913 48.0291 60.1811 48.1064C60.371 48.1838 60.5435 48.2974 60.689 48.4408C60.8344 48.5841 60.9499 48.7544 61.0289 48.942C61.1079 49.1295 61.1487 49.3306 61.1491 49.5338C61.1481 49.944 60.9825 50.3369 60.6887 50.6263C60.395 50.9157 59.9971 51.0778 59.5826 51.077V51.0776ZM34.1354 54.9803C34.1334 55.6824 33.9917 56.3772 33.7183 57.025C33.445 57.6729 33.0453 58.2611 32.5422 58.7561C32.0391 59.2511 31.4425 59.6431 30.7862 59.9099C30.13 60.1766 29.4271 60.3128 28.7177 60.3107C27.2852 60.3145 25.9097 59.7551 24.8938 58.7555C23.8778 57.7559 23.3046 56.398 23.3 54.9803H34.1354ZM54.3014 54.9803C54.2994 55.6824 54.1577 56.3772 53.8844 57.025C53.611 57.6729 53.2114 58.2611 52.7083 58.7561C52.2052 59.2511 51.6085 59.6431 50.9523 59.9099C50.296 60.1766 49.5932 60.3128 48.8838 60.3107C47.4515 60.3144 46.0765 59.7549 45.0611 58.7552C44.0457 57.7556 43.4731 56.3977 43.4693 54.9803H54.3014ZM67.7108 17.3814H66.2873L55.1692 47.1968C54.6131 48.678 53.4864 49.8807 52.0359 50.5412C50.5854 51.2017 48.9295 51.2662 47.431 50.7205C45.9326 50.1748 44.7138 49.0635 44.0419 47.6301C43.3699 46.1967 43.2996 44.5581 43.8463 43.0734L55.9524 10.5975C56.3728 9.47749 57.1239 8.50849 58.108 7.81641C59.0921 7.12432 60.2638 6.74115 61.4709 6.71669C61.5164 6.71219 61.5619 6.7122 61.6074 6.7122H67.7076L67.7108 17.3814ZM61.6074 6.71155C61.5619 6.71155 61.5164 6.71155 61.4709 6.71605V6.71155H61.6074Z" fill="white"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_833_4251">
                    <rect width="266" height="67" fill="white"/>
                    </clipPath>
                    </defs>
                    </svg>
                    </a>
            </div>
        <div class="footer-about-section">
            Spondonit have been launched in 2008 to serve the IT related services. Spondonit have done a wonderful job for the clients they got with a creative
        </div>

        <div class="footer-contact-address">
            <ul>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                        <path d="M6.74603 1.17765C5.18396 0.781933 3.55028 0.950263 2.26938 1.66693C0.965628 2.39638 0.0503584 3.6882 0.00520842 5.41908C-0.0652916 8.12109 0.560974 11.7474 3.04509 16.0059C5.49734 20.2096 8.20533 22.7293 10.4513 24.2275C11.8703 25.1742 13.4388 25.1991 14.7783 24.5818C16.097 23.9742 17.1686 22.7614 17.7251 21.2569C18.0051 20.4996 17.9391 19.6576 17.5446 18.9532L16.1144 16.3992C15.2049 14.775 13.2414 14.0638 11.5028 14.7289L10.5042 15.1108C10.0204 15.2959 9.57533 15.2107 9.32243 14.9623C8.47463 14.1295 7.86897 12.9988 7.5942 11.7808C7.5078 11.3978 7.68332 10.9449 8.10735 10.6249L9.00905 9.94438C10.5169 8.80648 10.9429 6.72465 10.0034 5.08588L8.54556 2.54326C8.15555 1.86303 7.50614 1.3702 6.74603 1.17765ZM1.5047 5.4582C1.53495 4.29859 2.12168 3.46839 3.00179 2.97597C3.90476 2.47075 5.13681 2.31736 6.37767 2.63172C6.74372 2.72445 7.05645 2.96176 7.24427 3.28935L8.70206 5.83197C9.2658 6.81523 9.01017 8.06433 8.10548 8.74707L7.20378 9.42754C6.42498 10.0153 5.88578 11.0239 6.13097 12.1109C6.4635 13.585 7.20029 14.9805 8.27136 16.0324C9.05342 16.8006 10.1691 16.8451 11.0402 16.5118L12.0387 16.1299C13.082 15.7309 14.2599 16.1575 14.8056 17.1321L16.2359 19.6861C16.4159 20.0073 16.4459 20.3913 16.3182 20.7366C15.8829 21.9135 15.0666 22.7974 14.1506 23.2195C13.2557 23.6319 12.243 23.6197 11.2837 22.9797C9.22751 21.6081 6.67797 19.2567 4.34076 15.25C1.99565 11.2299 1.44155 7.87845 1.5047 5.4582ZM16.0571 1.09726C15.695 0.896098 15.2384 1.02655 15.0372 1.38864C14.8361 1.75074 14.9666 2.20734 15.3287 2.40849L15.9045 2.72847C19.557 4.75765 21.9836 8.4477 22.3994 12.6053L22.4466 13.0776C22.4877 13.4896 22.8554 13.7904 23.2674 13.7491C23.6796 13.708 23.9804 13.3404 23.9391 12.9282L23.8919 12.456C23.4272 7.80931 20.7153 3.68514 16.6331 1.41723L16.0571 1.09726ZM14.2998 5.11702C14.513 4.76184 14.9736 4.64667 15.3288 4.85977L15.515 4.97148C17.9645 6.44124 19.6463 8.91133 20.1159 11.7291L20.1827 12.1296C20.2508 12.5382 19.9748 12.9246 19.5662 12.9927C19.1576 13.0608 18.7712 12.7848 18.7031 12.3762L18.6363 11.9757C18.239 9.59145 16.8159 7.50136 14.7432 6.25773L14.5571 6.14602C14.2019 5.9329 14.0867 5.47221 14.2998 5.11702Z" fill="white"/>
                    </svg>

                    +2 810 854-36-79
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="21" viewBox="0 0 25 21" fill="none">
                        <path d="M4.0625 0.00390625H20.9375C23.1038 0.00390625 24.874 1.69947 24.9936 3.83588L25 4.06641V15.9414C25 18.1077 23.3044 19.8779 21.168 19.9975L20.9375 20.0039H4.0625C1.89621 20.0039 0.125938 18.3083 0.00642508 16.1719L0 15.9414V4.06641C0 1.90012 1.69556 0.129844 3.83197 0.010331L4.0625 0.00390625H20.9375H4.0625ZM23.125 6.72016L12.9366 12.0835C12.7024 12.2068 12.4289 12.2244 12.1835 12.1364L12.0634 12.0835L1.875 6.72141V15.9414C1.875 17.0892 2.75889 18.0304 3.88309 18.1217L4.0625 18.1289H20.9375C22.0853 18.1289 23.0265 17.245 23.1178 16.1208L23.125 15.9414V6.72016ZM20.9375 1.87891H4.0625C2.91479 1.87891 1.97351 2.76279 1.88225 3.88699L1.875 4.06641V4.60266L12.5 10.1945L23.125 4.60141V4.06641C23.125 2.91869 22.2411 1.97742 21.1169 1.88616L20.9375 1.87891Z" fill="white"/>
                    </svg>

                    support@spondon.com
                </li>
            </ul>
        </div>

        <div class="footer-social-section">
            <p class="footer-social-section-title">Follow Us on</p>

            <ul class="footer-social-links">
                <li>
                    <a href="#" class="social-icon-container">
                        <i class="fab fa-facebook-f facebook"></i>
                    </a>
                    </li>
                <li>
                    <a href="#" class="social-icon-container">
                    <i class="fab fa-twitter twitter"></i></a>
                </li>
                <li>
                    <a href="#" class="social-icon-container">
                        <i class="fab fa-youtube youtube"></i></a>
                    </li>
                </li>
            </ul>
        </div>
        </div>
    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 mb-4 mb-xl-0">
        <p class="footer-section-title">Quick Link</p>

        <ul class="footer-quick-links mb-0 p-0">
            <li><a href="">Dashboard</a></li>
            <li><a href="">Blog</a></li>
            <li><a href="">Help and Support</a></li>
            <li><a href="">Affiliate</a></li>
            <li><a href="">Terms</a></li>
            <li><a href="">Help and Support</a></li>
            <li><a href="">Affiliate</a></li>
            <li><a href="">Terms</a></li>
        </ul>
    </div>
    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 mb-4 mb-xl-0">
        <p class="footer-section-title">Quick Link</p>

        <ul class="footer-quick-links mb-0 p-0">
            <li><a href="">InfixEdu for business</a></li>
            <li><a href="">Teach on infixEdu</a></li>
            <li><a href="">Get the app</a></li>
            <li><a href="">About Us</a></li>
            <li><a href="">Contant Us</a></li>
        </ul>
    </div>
    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 mb-4 mb-xl-0">
        <p class="footer-section-title">Subscribe</p>
        <div class="input-group news-letter-email">

            <input type="text" class="form-control" placeholder="Username" aria-label="Username">
            <div class="input-group-prepend">
                <span class="input-group-text email-submission">GO!</span>
              </div>
          </div>

          <p class="footer-section-title">Secure Payment</p>

          <div class="footer-payment-method-contaienr">
            <img src="{{asset('public/frontend/default/img/payment-method/payment-method-1.png')}}" class="payment-method-1" alt="payment method">
            <img src="{{asset('public/frontend/default/img/payment-method/payment-method-2.png')}}" class="payment-method-2" alt="payment method">
          </div>


          <div class="footer-get-app">
                <svg xmlns="http://www.w3.org/2000/svg" width="174" height="60" viewBox="0 0 174 60" fill="none">
                    <rect opacity="0.1" width="174" height="60" rx="30" fill="white"/>
                    <path d="M128.81 40.9307H130.645V28.4503H128.81V40.9307ZM145.34 32.9463L143.236 38.357H143.173L140.99 32.9463H139.013L142.288 40.5085L140.42 44.7153H142.334L147.381 32.9463H145.34ZM134.931 39.5132C134.331 39.5132 133.492 39.2079 133.492 38.4533C133.492 37.4901 134.537 37.1208 135.438 37.1208C136.244 37.1208 136.625 37.2971 137.115 37.5381C136.972 38.6943 135.992 39.5132 134.931 39.5132ZM135.154 32.6733C133.825 32.6733 132.449 33.2676 131.879 34.5841L133.508 35.2743C133.856 34.5841 134.504 34.3595 135.185 34.3595C136.134 34.3595 137.099 34.937 137.115 35.965V36.0933C136.782 35.9006 136.07 35.6117 135.201 35.6117C133.444 35.6117 131.657 36.5908 131.657 38.4213C131.657 40.0912 133.097 41.1671 134.71 41.1671C135.943 41.1671 136.625 40.6051 137.051 39.9465H137.115V40.9105H138.887V36.1252C138.887 33.9095 137.256 32.6733 135.154 32.6733ZM123.811 34.4655H121.201V30.1877H123.811C125.183 30.1877 125.962 31.3404 125.962 32.3266C125.962 33.2937 125.183 34.4655 123.811 34.4655ZM123.764 28.4503H119.367V40.9307H121.201V36.2025H123.764C125.798 36.2025 127.798 34.7081 127.798 32.3266C127.798 29.9455 125.798 28.4503 123.764 28.4503ZM99.7842 39.5155C98.5163 39.5155 97.4552 38.4377 97.4552 36.9586C97.4552 35.4623 98.5163 34.3692 99.7842 34.3692C101.036 34.3692 102.018 35.4623 102.018 36.9586C102.018 38.4377 101.036 39.5155 99.7842 39.5155ZM101.892 33.6451H101.828C101.416 33.1467 100.624 32.6963 99.626 32.6963C97.534 32.6963 95.6169 34.5623 95.6169 36.9586C95.6169 39.3385 97.534 41.1881 99.626 41.1881C100.624 41.1881 101.416 40.7377 101.828 40.2233H101.892V40.834C101.892 42.459 101.036 43.3271 99.6574 43.3271C98.5329 43.3271 97.8356 42.507 97.5501 41.8156L95.95 42.491C96.4091 43.6164 97.6289 45 99.6574 45C101.813 45 103.635 43.7131 103.635 40.5766V32.9537H101.892V33.6451ZM104.903 40.9307H106.74V28.4503H104.903V40.9307ZM109.45 36.8135C109.403 35.1729 110.702 34.3368 111.637 34.3368C112.366 34.3368 112.983 34.7069 113.19 35.2373L109.45 36.8135ZM115.154 35.3979C114.806 34.4495 113.744 32.6963 111.573 32.6963C109.418 32.6963 107.628 34.4172 107.628 36.9422C107.628 39.3226 109.403 41.1881 111.779 41.1881C113.696 41.1881 114.806 39.9983 115.265 39.3065L113.839 38.3413C113.364 39.0491 112.714 39.5155 111.779 39.5155C110.844 39.5155 110.179 39.0812 109.751 38.2287L115.344 35.8807L115.154 35.3979ZM70.5921 33.9991V35.8004H74.8385C74.7117 36.8135 74.379 37.5533 73.8719 38.068C73.2537 38.695 72.2871 39.3869 70.5921 39.3869C67.9775 39.3869 65.9336 37.2479 65.9336 34.5942C65.9336 31.9405 67.9775 29.8012 70.5921 29.8012C72.0024 29.8012 73.032 30.3643 73.7927 31.0881L75.0448 29.8172C73.9829 28.7881 72.5729 28 70.5921 28C67.0105 28 64 30.9594 64 34.5942C64 38.2287 67.0105 41.1881 70.5921 41.1881C72.5249 41.1881 73.9829 40.5447 75.1236 39.3385C76.2962 38.1484 76.6608 36.4758 76.6608 35.1246C76.6608 34.7069 76.6288 34.3209 76.5655 33.9991H70.5921ZM81.4886 39.5155C80.2207 39.5155 79.1273 38.454 79.1273 36.9422C79.1273 35.4143 80.2207 34.3692 81.4886 34.3692C82.756 34.3692 83.8494 35.4143 83.8494 36.9422C83.8494 38.454 82.756 39.5155 81.4886 39.5155ZM81.4886 32.6963C79.1745 32.6963 77.2893 34.4815 77.2893 36.9422C77.2893 39.3869 79.1745 41.1881 81.4886 41.1881C83.8018 41.1881 85.6874 39.3869 85.6874 36.9422C85.6874 34.4815 83.8018 32.6963 81.4886 32.6963ZM90.6481 39.5155C89.3811 39.5155 88.2873 38.454 88.2873 36.9422C88.2873 35.4143 89.3811 34.3692 90.6481 34.3692C91.9159 34.3692 93.0089 35.4143 93.0089 36.9422C93.0089 38.454 91.9159 39.5155 90.6481 39.5155ZM90.6481 32.6963C88.3349 32.6963 86.4496 34.4815 86.4496 36.9422C86.4496 39.3869 88.3349 41.1881 90.6481 41.1881C92.9621 41.1881 94.8474 39.3869 94.8474 36.9422C94.8474 34.4815 92.9621 32.6963 90.6481 32.6963Z" fill="white"/>
                    <path d="M67.3982 23.2861C66.4539 23.2861 65.6418 22.9527 64.9869 22.2956C64.3318 21.6381 64 20.8149 64 19.8576C64 18.9003 64.332 18.0785 64.9869 17.4195C65.6418 16.7623 66.4539 16.429 67.3982 16.429C67.8792 16.429 68.3282 16.5124 68.7572 16.686C69.1864 16.8597 69.5376 17.1007 69.8141 17.4162L69.8793 17.4907L69.1427 18.2298L69.0691 18.139C68.8857 17.9128 68.6525 17.7371 68.3569 17.6094C68.0625 17.482 67.74 17.4232 67.3982 17.4232C66.7331 17.4232 66.1813 17.6499 65.7205 18.1107C65.2701 18.5808 65.0433 19.1533 65.0433 19.8576C65.0433 20.5624 65.27 21.1348 65.7209 21.6051C66.1817 22.0657 66.7335 22.2936 67.3982 22.2936C68.007 22.2936 68.5105 22.123 68.9063 21.7853C69.2749 21.471 69.4962 21.0463 69.5745 20.505H67.2928V19.5306H70.5606L70.5746 19.6198C70.6013 19.791 70.6202 19.9564 70.6202 20.1152C70.6202 21.0244 70.344 21.7666 69.8022 22.3126C69.1905 22.9633 68.386 23.2861 67.3982 23.2861ZM95.7728 23.2861C94.8272 23.2861 94.0245 22.9525 93.3781 22.2956C92.7308 21.6458 92.4092 20.8219 92.4092 19.8576C92.4092 18.8932 92.7304 18.0697 93.3776 17.4199C94.0241 16.7629 94.8272 16.429 95.7728 16.429C96.7166 16.429 97.5196 16.7626 98.1659 17.4294C98.8134 18.0791 99.1348 18.901 99.1348 19.8575C99.1348 20.8219 98.8136 21.6454 98.1663 22.2952C97.5196 22.9526 96.7089 23.2861 95.7728 23.2861ZM71.5554 23.1441V16.571H71.6607H75.4669V17.5653H72.5806V19.3704H75.1839V20.3448H72.5806V22.1515H75.4669V23.1441H71.5554ZM77.8609 23.1441V17.5653H76.0902V16.571H80.6568V17.5653H80.5514H78.8861V23.1441H77.8609ZM83.5752 23.1441V16.571H84.6004V16.6767V23.1441H83.5752ZM87.1811 23.1441V17.5653H85.4105V16.571H89.977V17.5653H89.8717H88.2064V23.1441H87.1811ZM100.045 23.1441V16.571H101.201L104.143 21.2981L104.118 20.4007V16.571H105.143V23.1441H104.128L101.045 18.1782L101.07 19.075V19.0764V23.1441H100.045ZM95.7728 22.2936C96.4379 22.2936 96.9808 22.0659 97.4234 21.6059L97.424 21.6051C97.8729 21.1545 98.0931 20.5738 98.0931 19.8575C98.0931 19.143 97.8734 18.561 97.4246 18.1106L97.4234 18.1094C96.9809 17.6494 96.438 17.4232 95.7728 17.4232C95.1065 17.4232 94.5637 17.6491 94.1128 18.109C93.6723 18.5703 93.4525 19.1432 93.4525 19.8575C93.4525 20.5735 93.6718 21.1442 94.1124 21.6056C94.5633 22.0656 95.1066 22.2936 95.7728 22.2936Z" fill="white"/>
                    <path d="M42.7481 29.5629L32.1016 40.8629C32.102 40.8652 32.1028 40.8672 32.1032 40.8695C32.4297 42.0965 33.5504 43 34.8805 43C35.4122 43 35.9114 42.8563 36.3395 42.6039L36.3735 42.584L48.3575 35.6688L42.7481 29.5629Z" fill="#EA4335"/>
                    <path d="M53.5129 27.6391L53.5027 27.6321L48.3289 24.6328L42.5 29.8196L48.3492 35.668L53.4957 32.6985C54.398 32.2114 55.0105 31.2602 55.0105 30.1633C55.0105 29.0743 54.4062 28.1278 53.5129 27.6391Z" fill="#FBBC04"/>
                    <path d="M32.0976 19.4164C32.0336 19.6524 32 19.8996 32 20.1563V40.1239C32 40.3801 32.0332 40.6281 32.098 40.8633L43.1109 29.8524L32.0976 19.4164Z" fill="#4285F4"/>
                    <path d="M42.8191 30.1396L48.3297 24.6306L36.3593 17.6904C35.9242 17.4298 35.4164 17.2794 34.873 17.2794C33.5429 17.2794 32.4207 18.1845 32.0941 19.413C32.0937 19.4142 32.0938 19.415 32.0938 19.4162L42.8191 30.1396Z" fill="#34A853"/>
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" width="174" height="60" viewBox="0 0 174 60" fill="none">
                    <rect opacity="0.1" width="174" height="60" rx="30" fill="white"/>
                    <path d="M112.527 28.2038V30.4948H111.091V31.9972H112.527V37.1022C112.527 38.8454 113.315 39.5427 115.299 39.5427C115.648 39.5427 115.98 39.5012 116.27 39.4513V37.9655C116.021 37.9904 115.864 38.007 115.59 38.007C114.701 38.007 114.311 37.592 114.311 36.6457V31.9972H116.27V30.4948H114.311V28.2038H112.527Z" fill="white"/>
                    <path d="M121.324 39.6672C123.964 39.6672 125.582 37.8991 125.582 34.9689C125.582 32.0554 123.956 30.279 121.324 30.279C118.685 30.279 117.058 32.0554 117.058 34.9689C117.058 37.8991 118.676 39.6672 121.324 39.6672ZM121.324 38.0817C119.772 38.0817 118.9 36.9445 118.9 34.9689C118.9 33.0099 119.772 31.8644 121.324 31.8644C122.868 31.8644 123.748 33.0099 123.748 34.9689C123.748 36.9362 122.868 38.0817 121.324 38.0817Z" fill="white"/>
                    <path d="M126.967 39.4929H128.752V34.1554C128.752 32.8854 129.707 32.0304 131.06 32.0304C131.375 32.0304 131.906 32.0886 132.056 32.1384V30.3786C131.865 30.3288 131.524 30.3039 131.259 30.3039C130.08 30.3039 129.076 30.9513 128.818 31.8395H128.686V30.4533H126.967V39.4929Z" fill="white"/>
                    <path d="M136.487 31.798C137.807 31.798 138.67 32.7194 138.712 34.1388H134.146C134.246 32.7277 135.167 31.798 136.487 31.798ZM138.703 37.0524C138.371 37.758 137.633 38.1481 136.553 38.1481C135.126 38.1481 134.204 37.1437 134.146 35.5583V35.4587H140.53V34.8361C140.53 31.9972 139.01 30.279 136.495 30.279C133.947 30.279 132.328 32.1135 132.328 35.0021C132.328 37.8908 133.914 39.6672 136.504 39.6672C138.571 39.6672 140.015 38.6711 140.422 37.0524H138.703Z" fill="white"/>
                    <path d="M100.823 36.1547C100.961 38.3744 102.81 39.794 105.564 39.794C108.506 39.794 110.347 38.3056 110.347 35.931C110.347 34.064 109.298 33.0316 106.751 32.438L105.383 32.1024C103.765 31.7239 103.112 31.2163 103.112 30.3301C103.112 29.2117 104.127 28.4804 105.65 28.4804C107.095 28.4804 108.093 29.1944 108.274 30.3387H110.149C110.037 28.2481 108.196 26.7769 105.675 26.7769C102.965 26.7769 101.159 28.2481 101.159 30.4592C101.159 32.2831 102.182 33.3671 104.428 33.892L106.028 34.2791C107.671 34.6663 108.394 35.2341 108.394 36.1805C108.394 37.2817 107.259 38.0819 105.71 38.0819C104.049 38.0819 102.897 37.3334 102.733 36.1547H100.823Z" fill="white"/>
                    <path d="M82.3357 30.3039C81.1072 30.3039 80.0447 30.9181 79.4969 31.9474H79.3641V30.4533H77.6458V42.4977H79.4305V38.1232H79.5716C80.0447 39.0778 81.0657 39.6423 82.3523 39.6423C84.6351 39.6423 86.0877 37.841 86.0877 34.9689C86.0877 32.0969 84.6351 30.3039 82.3357 30.3039ZM81.8294 38.0402C80.3353 38.0402 79.3973 36.8615 79.3973 34.9772C79.3973 33.0846 80.3353 31.9059 81.8377 31.9059C83.3484 31.9059 84.2532 33.0597 84.2532 34.9689C84.2532 36.8864 83.3484 38.0402 81.8294 38.0402Z" fill="white"/>
                    <path d="M92.3325 30.3039C91.104 30.3039 90.0415 30.9181 89.4937 31.9474H89.3609V30.4533H87.6426V42.4977H89.4273V38.1232H89.5684C90.0415 39.0778 91.0625 39.6423 92.3491 39.6423C94.6319 39.6423 96.0845 37.841 96.0845 34.9689C96.0845 32.0969 94.6319 30.3039 92.3325 30.3039ZM91.8262 38.0402C90.3321 38.0402 89.3941 36.8615 89.3941 34.9772C89.3941 33.0846 90.3321 31.9059 91.8345 31.9059C93.3452 31.9059 94.25 33.0597 94.25 34.9689C94.25 36.8864 93.3452 38.0402 91.8262 38.0402Z" fill="white"/>
                    <path d="M74.4438 39.4929H76.4914L72.009 27.078H69.9356L65.4531 39.4929H67.4319L68.5762 36.1977H73.3081L74.4438 39.4929ZM70.8733 29.3321H71.0196L72.8177 34.5802H69.0666L70.8733 29.3321Z" fill="white"/>
                    <path d="M65.6484 17.713V23.702H67.8108C69.5955 23.702 70.6289 22.6022 70.6289 20.6888C70.6289 18.8046 69.5872 17.713 67.8108 17.713H65.6484ZM66.5781 18.5597H67.707C68.948 18.5597 69.6826 19.3483 69.6826 20.7013C69.6826 22.0751 68.9604 22.8553 67.707 22.8553H66.5781V18.5597Z" fill="white"/>
                    <path d="M73.794 23.7892C75.1138 23.7892 75.9231 22.9052 75.9231 21.4401C75.9231 19.9833 75.1097 19.0951 73.794 19.0951C72.4742 19.0951 71.6607 19.9833 71.6607 21.4401C71.6607 22.9052 72.47 23.7892 73.794 23.7892ZM73.794 22.9965C73.0179 22.9965 72.5821 22.4279 72.5821 21.4401C72.5821 20.4606 73.0179 19.8878 73.794 19.8878C74.566 19.8878 75.0059 20.4606 75.0059 21.4401C75.0059 22.4237 74.566 22.9965 73.794 22.9965Z" fill="white"/>
                    <path d="M82.8153 19.1823H81.9229L81.1178 22.6312H81.0472L80.1175 19.1823H79.2625L78.3329 22.6312H78.2665L77.4571 19.1823H76.5523L77.7975 23.702H78.7147L79.6444 20.3734H79.7149L80.6488 23.702H81.5743L82.8153 19.1823Z" fill="white"/>
                    <path d="M83.8429 23.702H84.7353V21.0582C84.7353 20.3527 85.1544 19.9127 85.8144 19.9127C86.4743 19.9127 86.7897 20.2738 86.7897 21.0001V23.702H87.682V20.776C87.682 19.701 87.1259 19.0951 86.1173 19.0951C85.4367 19.0951 84.9884 19.3981 84.7685 19.9003H84.702V19.1823H83.8429V23.702Z" fill="white"/>
                    <path d="M89.0874 23.702H89.9797V17.4183H89.0874V23.702Z" fill="white"/>
                    <path d="M93.3357 23.7892C94.6555 23.7892 95.4648 22.9052 95.4648 21.4401C95.4648 19.9833 94.6514 19.0951 93.3357 19.0951C92.0159 19.0951 91.2024 19.9833 91.2024 21.4401C91.2024 22.9052 92.0117 23.7892 93.3357 23.7892ZM93.3357 22.9965C92.5596 22.9965 92.1238 22.4279 92.1238 21.4401C92.1238 20.4606 92.5596 19.8878 93.3357 19.8878C94.1077 19.8878 94.5476 20.4606 94.5476 21.4401C94.5476 22.4237 94.1077 22.9965 93.3357 22.9965Z" fill="white"/>
                    <path d="M98.1236 23.0255C97.638 23.0255 97.2852 22.7889 97.2852 22.3822C97.2852 21.9838 97.5674 21.7721 98.19 21.7306L99.294 21.66V22.0377C99.294 22.598 98.7959 23.0255 98.1236 23.0255ZM97.8953 23.7767C98.4888 23.7767 98.9827 23.5194 99.2525 23.067H99.323V23.702H100.182V20.6141C100.182 19.6595 99.543 19.0951 98.41 19.0951C97.3848 19.0951 96.6543 19.5931 96.563 20.3693H97.4263C97.5259 20.0497 97.8704 19.8671 98.3685 19.8671C98.9786 19.8671 99.294 20.1368 99.294 20.6141V21.0043L98.0696 21.0748C96.9947 21.1412 96.3887 21.6102 96.3887 22.4237C96.3887 23.2496 97.0237 23.7767 97.8953 23.7767Z" fill="white"/>
                    <path d="M103.21 23.7767C103.833 23.7767 104.36 23.4821 104.63 22.9882H104.7V23.702H105.555V17.4183H104.663V19.9003H104.597C104.352 19.4022 103.829 19.1075 103.21 19.1075C102.069 19.1075 101.334 20.0123 101.334 21.4401C101.334 22.8719 102.061 23.7767 103.21 23.7767ZM103.463 19.9086C104.211 19.9086 104.68 20.5021 104.68 21.4442C104.68 22.3905 104.215 22.9757 103.463 22.9757C102.708 22.9757 102.256 22.3988 102.256 21.4401C102.256 20.4896 102.712 19.9086 103.463 19.9086Z" fill="white"/>
                    <path d="M111.342 23.7892C112.662 23.7892 113.471 22.9052 113.471 21.4401C113.471 19.9833 112.657 19.0951 111.342 19.0951C110.022 19.0951 109.208 19.9833 109.208 21.4401C109.208 22.9052 110.018 23.7892 111.342 23.7892ZM111.342 22.9965C110.566 22.9965 110.13 22.4279 110.13 21.4401C110.13 20.4606 110.566 19.8878 111.342 19.8878C112.114 19.8878 112.554 20.4606 112.554 21.4401C112.554 22.4237 112.114 22.9965 111.342 22.9965Z" fill="white"/>
                    <path d="M114.652 23.702H115.544V21.0582C115.544 20.3527 115.964 19.9127 116.624 19.9127C117.283 19.9127 117.599 20.2738 117.599 21.0001V23.702H118.491V20.776C118.491 19.701 117.935 19.0951 116.927 19.0951C116.246 19.0951 115.798 19.3981 115.578 19.9003H115.511V19.1823H114.652V23.702Z" fill="white"/>
                    <path d="M122.601 18.0575V19.203H121.883V19.9542H122.601V22.5067C122.601 23.3783 122.995 23.7269 123.987 23.7269C124.161 23.7269 124.327 23.7062 124.473 23.6813V22.9384C124.348 22.9508 124.269 22.9591 124.132 22.9591C123.688 22.9591 123.493 22.7516 123.493 22.2784V19.9542H124.473V19.203H123.493V18.0575H122.601Z" fill="white"/>
                    <path d="M125.671 23.702H126.563V21.0624C126.563 20.3776 126.97 19.9169 127.7 19.9169C128.331 19.9169 128.667 20.2821 128.667 21.0043V23.702H129.559V20.7843C129.559 19.7094 128.966 19.0992 128.003 19.0992C127.322 19.0992 126.845 19.4022 126.625 19.9086H126.555V17.4183H125.671V23.702Z" fill="white"/>
                    <path d="M132.779 19.8546C133.438 19.8546 133.87 20.3153 133.891 21.025H131.608C131.658 20.3195 132.119 19.8546 132.779 19.8546ZM133.887 22.4818C133.721 22.8346 133.351 23.0297 132.812 23.0297C132.098 23.0297 131.637 22.5275 131.608 21.7347V21.6849H134.8V21.3737C134.8 19.9542 134.04 19.0951 132.783 19.0951C131.508 19.0951 130.699 20.0123 130.699 21.4567C130.699 22.901 131.492 23.7892 132.787 23.7892C133.82 23.7892 134.542 23.2911 134.746 22.4818H133.887Z" fill="white"/>
                    <path d="M52.3437 28.1023C52.3706 26.0148 53.4916 24.0397 55.27 22.9463C54.1481 21.344 52.269 20.3281 50.3139 20.267C48.2287 20.0481 46.2071 21.5148 45.1445 21.5148C44.0613 21.5148 42.4253 20.2887 40.6636 20.325C38.3672 20.3991 36.2264 21.7047 35.1092 23.7124C32.7076 27.8703 34.499 33.9812 36.7995 37.3422C37.9505 38.988 39.2957 40.8264 41.0558 40.7612C42.7783 40.6897 43.4216 39.6629 45.5007 39.6629C47.5605 39.6629 48.164 40.7612 49.9599 40.7197C51.8081 40.6897 52.9726 39.0666 54.0832 37.4053C54.9102 36.2326 55.5466 34.9365 55.9688 33.5651C53.7967 32.6464 52.3462 30.4606 52.3437 28.1023Z" fill="white"/>
                    <path d="M48.9516 18.0566C49.9593 16.8469 50.4558 15.2919 50.3356 13.722C48.796 13.8838 47.3738 14.6196 46.3525 15.7829C45.3537 16.9195 44.834 18.4471 44.9322 19.957C46.4724 19.9729 47.9865 19.257 48.9516 18.0566Z" fill="white"/>
                </svg>
          </div>
    </div>
</div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-12 mb-4 mb-xl-0 text-center text-xl-left"><span class="copyright">© 2022 All Rights Reserved</span></div>
                <div class="col-xl-8">
                    <ul class="mb-0 p-0 links d-flex justify-content-xl-end justify-content-sm-center flex-column align-items-center g-3 g-md-5 flex-md-row">
                        <li><a href="">Privacy Policy</a></li>
                        <li><a href="">Terms of Use</a></li>
                        <li><a href="">Sales and Refunds</a></li>
                        <li><a href="">Legal</a></li>
                        <li><a href="">Site Map</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script type="module">

        $(document).ready(function(){
            $(".flash-sale-products-slider-item").owlCarousel({
                items: 6,
                margin: 20,
                loop: true,
                nav: true,
                navText : ['<i class="ti-arrow-left" aria-hidden="true"></i>','<i class="ti-arrow-right" aria-hidden="true"></i>'],
                lazyLoad: true,
                autoPlay: true,
                autoplayTimeout: 2000,
                responsive: {
                    1400: {
                        items: 6
                    },
                    1200: {
                        items: 5
                    },
                    991: {
                        items: 4
                    },
                    767: {
                        items: 3
                    },
                    576: {
                        items: 2
                    },
                    0: {
                        items: 1
                    }
                }
            });
        });
    </script>
    {{-- Footer Section:End --}}

@endsection
