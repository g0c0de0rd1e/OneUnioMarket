<div class="amaz_brand">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title d-flex align-items-center gap-3 mb_30">
                    <h3 class="m-0 flex-fill">{{$top_brands->title}}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="amazBrand_boxes">
                    @foreach($top_brands->getBrandByQuery() as $key => $brand)
                        <a href="{{route('frontend.category-product',['slug' => $brand->slug, 'item' =>'brand'])}}" class="single_brand d-block">
                            <img src="{{ showImage($brand->logo?$brand->logo:'frontend/default/img/brand_image.png') }}" alt="">
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>