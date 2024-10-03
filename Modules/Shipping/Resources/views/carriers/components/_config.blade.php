<div class="col-md-12 mb-20">
    <div class="box_header_right">
        <div class=" float-none pos_tab_btn justify-content-start">
            @php
               $carriers =  $carriers->where('name','!=','Manual')->where('status',1);
            @endphp
            <ul class="nav nav_list" role="tablist">
                @foreach($carriers as $key => $cary)

                    <li class="nav-item mb-2">
                        <a class="nav-link @if($key == 0)  active show  @endif" href="#{{ $cary->slug }}" role="tab"
                        data-toggle="tab" id="1" aria-selected="true"> {{ $cary->name }} </a>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <div class="white_box_30px mb_30">
        <div class="tab-content">
            @foreach($carriers as $key => $cary)
               @if($cary->name == "Shiprocket")
                    @if(isModuleActive('ShipRocket') && $cary->status == 1)
                        <div role="tabpanel" class="tab-pane fade {{ $key == 0 ? 'active show':'' }}" id="{{ $cary->slug }}">
                            <div class="box_header common_table_header ">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('shipping.shiprocket')}}</h3>
                                </div>
                            </div>
                            @include('shiprocket::config',['shipRocket'=>$cary])
                        </div>
                    @endif
                @endif


                @if($cary->name == "Torod")
                    <div role="tabpanel" class="tab-pane fade {{ $key == 0 ? 'active show':'' }}" id="{{ $cary->slug }}">
                        <div class="box_header common_table_header ">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('torod.torod')}}</h3>
                            </div>
                        </div>
                        @include('torod::config',['torod' => $cary])
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
