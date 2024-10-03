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
        <form action="{{route('setup.update.oneclickorder.status')}}" enctype="multipart/form-data" method="POST">
            @csrf

        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">{{__('setup.One Click Order Complete Configuration')}}</h3>
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
                                                    <td>{{__('setup.Status')}}</td>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>{{__('setup.One Click Order Complete')}}</td>
                                                    <td>
                                                        <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="status">
                                                                <input type="checkbox" name="status" id="status" value="1" class="status_change_checkbox" @if(!empty($oneClickOrder->status) && $oneClickOrder->status==1) checked @endif>
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
