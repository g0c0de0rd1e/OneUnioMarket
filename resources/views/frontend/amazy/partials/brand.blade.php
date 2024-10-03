@isset ($brandList)
    @if (count($brandList) > 0)
        <div class="single_pro_categry">
            <h4 class="font_18 f_w_700">
            {{__('common.filter_by_brands')}}
            </h4>
            <ul class="Check_sidebar mb_35">
                @foreach($brandList as $key => $brand)
                    <li>
                        <label class="primary_checkbox d-flex">
                            <input type="checkbox" class="getProductByChoice" data-id="brand" data-value="{{ $brand->id }}">
                            <span class="checkmark mr_10"></span>
                            <span class="label_name">{{$brand->name}}</span>
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endisset