@extends('backEnd.master')
@section('mainContent')
<link rel="stylesheet" href="{{asset(asset_path('backend/css/role_module_style.css'))}}">
<link rel="stylesheet" href="{{asset(asset_path('modules/seller/css/access_permission.css'))}}" />
    <div class="role_permission_wrap">
        <div class="permission_title">
            <h4>@lang('hr.assign_permission') - {{$user->first_name . ' ' . $user->last_name}} </h4>
        </div>
    </div>
    <form class="form-horizontal" action="{{ route('seller.sub_seller.access_permission_store') }}" method="post">
        @csrf
        <div class="erp_role_permission_area ">
        <!-- single_permission  -->
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <div  class="mesonary_role_header">
                @foreach ($MainMenuList as $key => $Module)

                    @if(permissionCheck($Module->route))
                    <div class="single_role_blocks">
                        <div class="single_permission" id="{{ $Module->id }}">
                            <div class="permission_header d-flex align-items-center justify-content-between">
                                <div>
                                    <input type="checkbox" name="module_id[]" value="{{ $Module->id }}" id="Main_Module_{{ $key }}" class="common-radio permission-checkAll main_module_id_{{ $Module->id }}" {{ $user->permissions->contains('id',$Module->id) ? 'checked' : '' }} >
                                    <label for="Main_Module_{{ $key }}">{{ $Module->name }}</label>
                                </div>
                                @if($Module->id == 608)
                                    <input type="hidden" name="module_id[]" value="{{$Module->id}}">
                                @endif
                                <div class="arrow collapsed" data-toggle="collapse" data-target="#Role{{ $Module->id }}"></div>
                            </div>

                            <div id="Role{{ $Module->id }}" class="collapse">
                                <div  class="permission_body">
                                    <ul>
                                        @foreach ($SubMenuList->where('parent_id',$Module->id) as $SubMenu)
                                            @if(permissionCheck($SubMenu->route))
                                            <li>
                                                <div class="submodule">
                                                    <input id="Sub_Module_{{ $SubMenu->id }}" name="module_id[]" value="{{ $SubMenu->id }}"  class="infix_csk common-radio  module_id_{{ $Module->id }} module_link" {{ $user->permissions->contains('id',$SubMenu->id) ? 'checked' : '' }}  type="checkbox" >

                                                    <label for="Sub_Module_{{ $SubMenu->id }}">{{ $SubMenu->name }}</label>
                                                    <br>
                                                </div>

                                                <ul class="option">
                                                    @foreach ($ActionList->where('parent_id',$SubMenu->id) as $action)
                                                        @if(permissionCheck($action->route))
                                                        <li>
                                                            <div class="module_link_option_div" id="{{ $SubMenu->id }}">
                                                                <input id="Option_{{  $action->id }}" name="module_id[]" value="{{  $action->id }}"  class="infix_csk common-radio module_id_{{ $Module->id }} module_option_{{ $Module->id }}_{{ $SubMenu->id }} module_link_option" {{ $user->permissions->contains('id',$action->id) ? 'checked' : ''  }}  type="checkbox" >
                                                                <label for="Option_{{  $action->id }}">{{$action->name}}</label>
                                                                <br>
                                                            </div>
                                                       </li>
                                                       @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                @endforeach
            </div>
            <div class="row mt-40">
                <div class="col-lg-12 text-center">
                    <button class="primary-btn fix-gr-bg">
                        <span class="ti-check"></span>
                        @lang('common.submit')
                    </button>
                </div>
            </div>
        </div>
    </form>

@endsection



@push('scripts')
<script type="text/javascript">

    (function($){
        "use strict";

        $(document).ready(function(){
            $('.permission-checkAll').on('click', function () {
                if($(this).is(":checked")){
                    $( '.module_id_'+$(this).val() ).each(function() {
                        $(this).prop('checked', true);
                    });
                }else{
                    $( '.module_id_'+$(this).val() ).each(function() {
                        $(this).prop('checked', false);
                    });
                }
            });

            $('.module_link').on('click', function () {
                var module_id = $(this).parents('.single_permission').attr("id");
                var module_link_id = $(this).val();
                if($(this).is(":checked")){
                    $(".module_option_"+module_id+'_'+module_link_id).prop('checked', true);
                }else{
                    $(".module_option_"+module_id+'_'+module_link_id).prop('checked', false);
                }
                var checked = 0;
                $( '.module_id_'+module_id ).each(function() {
                    if($(this).is(":checked")){
                        checked++;
                    }
                });

                if(checked > 0){
                    $(".main_module_id_"+module_id).prop('checked', true);
                }else{
                    $(".main_module_id_"+module_id).prop('checked', false);
                }
            });

            $('.module_link_option').on('click', function () {
                var module_id = $(this).parents('.single_permission').attr("id");
                var module_link = $(this).parents('.module_link_option_div').attr("id");
                // module link check
                var link_checked = 0;
                $( '.module_option_'+module_id+'_'+ module_link).each(function() {
                    if($(this).is(":checked")){
                        link_checked++;
                    }
                });

                if(link_checked > 0){
                    $("#Sub_Module_"+module_link).prop('checked', true);
                }else{
                    $("#Sub_Module_"+module_link).prop('checked', false);
                }

                // module check
                var checked = 0;

                $( '.module_id_'+module_id ).each(function() {
                    if($(this).is(":checked")){
                        checked++;
                    }
                });

                if(checked > 0){
                    $(".main_module_id_"+module_id).prop('checked', true);
                }else{
                    $(".main_module_id_"+module_id).prop('checked', false);
                }
            });
        });
    })(jQuery);

</script>

@endpush
