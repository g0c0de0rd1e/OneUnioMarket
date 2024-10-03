<div class="main-title mb-25">
    <h3 class="mb-0">{{ __('general_settings.logo_banner') }}</h3>
</div>
<form action="{{route('seller.setting.logo.update',$seller->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST')

    <div class="row">
        <div class="col-md-12">
            <div class="single_system_wrap_inner text-center">
                <div class="logo">
                    <span>{{ __('common.logo') }} ({{getNumberTranslate(200)}} X {{getNumberTranslate(200)}})px</span>
                </div>
                <div class="logo_img">
                    <img id="seller_logos" src="{{showImage($seller->photo?$seller->photo:'backend/img/default.png') }}"
                        alt="">
                </div>
                <div class="update_logo_btn mt-20">
                    <button class="primary-btn small fix-gr-bg ">
                        <input placeholder="{{ __('general_settings.upload_logo') }}" type="file" name="logo" id="site_logo">
                        {{ __('general_settings.upload_logo') }}
                    </button>
                </div>

            </div>
        </div>

        <div class="col-md-12">
            <div class="single_system_wrap_inner text-center">
                <div class="logo">
                    <span>{{ __('common.banner') }} ({{getNumberTranslate(1920)}} X {{getNumberTranslate(350)}})px</span>
                </div>

                <div class="logo_img">
                    <img id="seller_banner"
                        src="{{showImage($seller->sellerAccount->banner?$seller->sellerAccount->banner:'backend/img/default.png')}}"
                        alt="">
                </div>

                <div class="update_logo_btn mt-20">
                    <button class="primary-btn small fix-gr-bg ">
                        <input placeholder="{{ __('general_settings.upload_logo') }}o" type="file" name="banner" id="favicon_logo">
                        {{ __('common.update') }} {{ __('common.banner') }}
                    </button>
                </div>

            </div>
        </div>

    </div>


    <div class="submit_btn text-center mt-4">
        <button class="primary_btn_large" id="banner_logo_submit_btn" type="submit"> <i class="ti-check"></i>
            {{ __('common.update') }}</button>
    </div>
</form>
