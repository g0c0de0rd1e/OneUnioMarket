<div class="product_img_div">
    @if ($product->thum_img)
        <img class="fix_height" src="{{ showImage($product->thum_img) }}" alt="{{ $product->product->product_name }}">
    @elseif ($product->product->thumbnail_image_source != null)
        <img class="fix_height" src="{{ showImage($product->product->thumbnail_image_source) }}"
            alt="{{ $product->product->product_name }}">
    @else
        <img class="fix_height" src="{{ showImage('frontend/img/no_image.png') }}" alt="{{ $product->product->product_name }}">
    @endif
</div>
