<div class="col-lg-3  col-md-6">
    <div class="footer_widget">
        <div class="footer_title">
            <h3>{{ @$subscribeContent->title }}</h3>
        </div>
        <div class="subcribe-form mb_20 theme_mailChimp2" id="mc_embed_signup">
            <form id="subscriptionForm" method="" class="subscription relative">
                <input name="email" id="subscription_email_id" class="form-control" placeholder="{{ __('defaultTheme.enter_email_address') }}" type="email">
                <div class="message_div d-none">
                </div>
                <button id="subscribeBtn">{{ __('defaultTheme.subscribe') }}</button>
                <div class="info"></div>
            </form>
        </div>
        <div class="social__Links">           
            @foreach($sellerSocialLinks as $sellerSocialLink)
                <a target="__blank" href="{{$sellerSocialLink->url}}">
                    <i class="{{$sellerSocialLink->icon}}"></i>
                </a>
            @endforeach     
        </div>
    </div>
</div>
