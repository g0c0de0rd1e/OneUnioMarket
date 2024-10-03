@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/marketing/css/flash_deal_create.css'))}}" />
<style>
    .fieldtable td{
        padding-left: 0px;
    }
</style>
@endsection
@section('mainContent')
@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <form action="{{route('setup.update.checkout.field.settings')}}" enctype="multipart/form-data" method="POST">
            @csrf
            
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">{{__('setup.Checkout Field Manager')}}</h3>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div id="formHtml" class="col-lg-12">
                        <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">
                                        <table class="table fieldtable">
                                            <thead>
                                                <tr>
                                                    <td>{{__('setup.Field Name')}}</td>
                                                    <td>{{__('setup.Visibility')}}</td>
                                                    <td>{{__('setup.Required')}}</td>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>{{__('setup.Address')}}</td>
                                                    <td>
                                                        <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="address_visibility">
                                                                <input type="checkbox" name="address_visibility" id="address_visibility" value="1" class="address_change_checkbox" @if($checkoutField[0]->field_name=='address' && $checkoutField[0]->visibility==1) {{'checked'}} @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                       <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="address_required">
                                                                <input type="checkbox" name="address_required" id="address_required" value="1" class="addressr_change_checkbox" @if($checkoutField[0]->field_name=='address' && $checkoutField[0]->required==1) {{'checked'}} @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('setup.City')}}</td>
                                                    <td>
                                                       <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="city_visibility">
                                                                <input type="checkbox" name="city_visibility" id="city_visibility" value="1" class="city_change_checkbox" @if($checkoutField[1]->field_name=='city' && $checkoutField[1]->visibility==1) {{'checked'}} @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                       <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="city_required">
                                                                <input type="checkbox" name="city_required" id="city_required" value="1" class="cityr_change_checkbox" @if($checkoutField[1]->field_name=='city' && $checkoutField[1]->required==1) {{'checked'}} @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('setup.State')}}</td>
                                                    <td>
                                                       <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="state_visibility">
                                                                <input type="checkbox" name="state_visibility" id="state_visibility" value="1" class="state_change_checkbox" @if($checkoutField[2]->field_name=='state' && $checkoutField[2]->visibility==1) {{'checked'}} @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                       <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="state_required">
                                                                <input type="checkbox" name="state_required" id="state_required" value="1" class="stater_change_checkbox" @if($checkoutField[2]->field_name=='state' && $checkoutField[2]->required==1) {{'checked'}} @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('setup.Country')}}</td>
                                                    <td>
                                                       <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="country_visibility">
                                                                <input type="checkbox" name="country_visibility" id="country_visibility" value="1" class="country_change_checkbox" @if($checkoutField[3]->field_name=='country' && $checkoutField[3]->visibility==1) {{'checked'}} @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                       <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="country_required">
                                                                <input type="checkbox" name="country_required" id="country_required" value="1" class="countryr_change_checkbox" @if($checkoutField[3]->field_name=='country' && $checkoutField[3]->required==1) {{'checked'}} @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('setup.Postal Code')}}</td>
                                                    <td>
                                                       <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="postal_visibility">
                                                                <input type="checkbox" name="postal_visibility" id="postal_visibility" value="1" class="postal_change_checkbox" @if($checkoutField[4]->field_name=='postal' && $checkoutField[4]->visibility==1) {{'checked'}} @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                       <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="postal_required">
                                                                <input type="checkbox" name="postal_required" id="postal_required" value="1" class="postalr_change_checkbox" @if($checkoutField[4]->field_name=='postal' && $checkoutField[4]->required==1) {{'checked'}} @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                        <button id="submit_btn" type="submit" class="primary-btn fix-gr-bg" data-toggle="tooltip" title="" data-original-title=""> <span class="ti-check"></span> {{__('common.save')}} </button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
    </div>
</section>
@endsection
@push('scripts')
    <script>
        
    </script>
@endpush
