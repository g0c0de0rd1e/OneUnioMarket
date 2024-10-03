@if ($product->stock_manage == 1)
    @php
        $stock = 0;
    @endphp
    @foreach ($product->skus as $sku)
        @php
            $stock += $sku->product_stock;
        @endphp
    @endforeach
@else
    @php
        $stock = __("common.not_manage");
    @endphp
@endif

{{ getNumberTranslate($stock) }}
@if ($product->product->unit_type_id != null)
    ({{ @$product->product->unit_type->name }})
@endif