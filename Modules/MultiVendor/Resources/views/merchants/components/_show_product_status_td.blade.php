<label class="switch_toggle" for="checkbox{{ $product->id }}">
    <input type="checkbox" id="checkbox{{ $product->id }}" {{$product->status?'checked':''}} value="{{$product->id}}" data-id="{{$product->id}}" class="update_active_status">
    <div class="slider round"></div>
</label>