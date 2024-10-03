@extends('backEnd.master')
@section('styles')
@if(isRtl())
<link rel="stylesheet" href="{{asset(asset_path('backend/css/chat/chat_update_rtl.css'))}}" />
@else
<link rel="stylesheet" href="{{asset(asset_path('backend/css/chat/chat_update.css'))}}" />
@endif
@endsection
@section('mainContent')
    <div class="chat d-flex flex-wrap">
        <div class="chat-left">
            <div class="chat-lists">
                <h5 class="fw-bold">Pinned Conversession</h5>
                <div class="pinded">
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-pinded"><i class="fa fa-thumbtack"></i></div>
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/1.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-pinded"><i class="fa fa-thumbtack"></i></div>
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/1.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-pinded"><i class="fa fa-thumbtack"></i></div>
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/1.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-pinded"><i class="fa fa-thumbtack"></i></div>
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/1.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-pinded"><i class="fa fa-thumbtack"></i></div>
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/1.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                </div>
                <h5 class="fw-bold">All Conversessions</h5>
                <div class="regular">
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/2.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/2.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/2.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/2.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/2.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/2.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/2.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                    <a href="#" class="chat-list d-flex align-items-center">
                        <div class="chat-list-left d-flex align-items-center">
                            <div class="chat-list-user">
                                <img src="{{asset('public/images/chat-user')}}/2.jpg" alt="">
                            </div>
                            <div class="chat-list-content">
                                <strong class="d-block">Annette Black</strong>
                                <p>Please let me know, How can i install this script very easily</p>
                            </div>
                        </div>
                        <div class="chat-list-right text-end">
                            <p class="text-primary">2:34 PM</p>
                            <div class="badge bg-primary text-white ml-auto">5</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="chat-center" id="mobile_popup">
            <div class="chat-close bg-primary text-white d-md-none">
                <i class="ti-close"></i>
            </div>
            <div class="chat-conversions">
                <div class="chat-receiver">
                    <div class="chat-receiver-img">
                        <img src="{{asset('public/images/support-user')}}/receiver.png" alt="">
                    </div>
                    <div class="chat-receiver-content">
                        <div class="chat-receiver-head d-flex align-items-center justify-content-between">
                            <span><strong class="f_w_600 text-white">Janet</strong> -  Support Agent</span>
                            <span>12:03 PM</span>
                        </div>
                        <p>That works- I was actually planning to get a smoothie anyways 👍</p>
                    </div>
                </div>
                <div class="chat-sender">
                    <p>In a laoreet purus. Integer turpis quam, laoreet id orci nec, ultrices lacinia nuncAliquam erat volutpat. Curabitur fringilla in purus eget egestas. Etiam quis</p>
                    <span class="date">12:03 PM</span>
                </div>
                <div class="chat-receiver">
                    <div class="chat-receiver-img">
                        <img src="{{asset('public/images/support-user')}}/receiver.png" alt="">
                    </div>
                    <div class="chat-receiver-content">
                        <div class="chat-receiver-head d-flex align-items-center justify-content-between">
                            <span><strong class="f_w_600 text-white">Janet</strong> -  Support Agent</span>
                            <span>12:03 PM</span>
                        </div>
                        <p>So i think now you understand well.</p>
                    </div>
                </div>
                <div class="chat-sender">
                    <p>All of the options for changing is the life</p>
                    <span class="date">12:03 PM</span>
                </div>
                <div class="chat-sender">
                    <p><i class="fa fa-image"></i><a href="#">Deserewg.pdf</a></p>
                    <span class="date">12:03 PM</span>
                </div>
                <div class="chat-receiver">
                    <div class="chat-receiver-img">
                        <img src="{{asset('public/images/support-user')}}/receiver.png" alt="">
                    </div>
                    <div class="chat-receiver-content">
                        <div class="chat-receiver-head d-flex align-items-center justify-content-between">
                            <span><strong class="f_w_600 text-white">Janet</strong> -  Support Agent</span>
                            <span>12:03 PM</span>
                        </div>
                        <p>That works- I was actually planning to get a smoothie anyways 👍</p>
                    </div>
                </div>
                <div class="chat-sender">
                    <p>That was actually planning</p>
                    <span class="date">12:03 PM</span>
                </div>
                <div class="chat-receiver">
                    <div class="chat-receiver-img">
                        <img src="{{asset('public/images/support-user')}}/receiver.png" alt="">
                    </div>
                    <div class="chat-receiver-content">
                        <div class="chat-receiver-head d-flex align-items-center justify-content-between">
                            <span><strong class="f_w_600 text-white">Janet</strong> -  Support Agent</span>
                            <span>12:03 PM</span>
                        </div>
                        <p>So i think now you understand well.</p>
                    </div>
                </div>
                <div class="chat-sender">
                    <p>All of the options for changing is the life</p>
                    <span class="date">12:03 PM</span>
                </div>
                <div class="chat-sender">
                    <p><i class="fa fa-image"></i><a href="#">Deserewg.pdf</a></p>
                    <span class="date">12:03 PM</span>
                </div>
                <div class="chat-receiver">
                    <div class="chat-receiver-img">
                        <img src="{{asset('public/images/support-user')}}/receiver.png" alt="">
                    </div>
                    <div class="chat-receiver-content">
                        <div class="chat-receiver-head d-flex align-items-center justify-content-between">
                            <span><strong class="f_w_600 text-white">Janet</strong> -  Support Agent</span>
                            <span>12:03 PM</span>
                        </div>
                        <p>That works- I was actually planning to get a smoothie anyways 👍</p>
                    </div>
                </div>
                <div class="chat-sender">
                    <p>That was actually planning</p>
                    <span class="date">12:03 PM</span>
                </div>
                <div class="chat-receiver">
                    <div class="chat-receiver-img">
                        <img src="{{asset('public/images/support-user')}}/receiver.png" alt="">
                    </div>
                    <div class="chat-receiver-content">
                        <div class="chat-receiver-head d-flex align-items-center justify-content-between">
                            <span><strong class="f_w_600 text-white">Janet</strong> -  Support Agent</span>
                            <span>12:03 PM</span>
                        </div>
                        <p>So i think now you understand well.</p>
                    </div>
                </div>
                <div class="chat-sender">
                    <p>All of the options for changing is the life</p>
                    <span class="date">12:03 PM</span>
                </div>
                <div class="chat-sender">
                    <p><i class="fa fa-image"></i><a href="#">Deserewg.pdf</a></p>
                    <span class="date">12:03 PM</span>
                </div>
                <div class="chat-receiver">
                    <div class="chat-receiver-img">
                        <img src="{{asset('public/images/support-user')}}/receiver.png" alt="">
                    </div>
                    <div class="chat-receiver-content">
                        <div class="chat-receiver-head d-flex align-items-center justify-content-between">
                            <span><strong class="f_w_600 text-white">Janet</strong> -  Support Agent</span>
                            <span>12:03 PM</span>
                        </div>
                        <p>That works- I was actually planning to get a smoothie anyways 👍</p>
                    </div>
                </div>
                <div class="chat-sender">
                    <p>That was actually planning</p>
                    <span class="date">12:03 PM</span>
                </div>
                <div class="chat-receiver">
                    <div class="chat-receiver-img">
                        <img src="{{asset('public/images/support-user')}}/receiver.png" alt="">
                    </div>
                    <div class="chat-receiver-content">
                        <div class="chat-receiver-head d-flex align-items-center justify-content-between">
                            <span><strong class="f_w_600 text-white">Janet</strong> -  Support Agent</span>
                            <span>12:03 PM</span>
                        </div>
                        <p>So i think now you understand well.</p>
                    </div>
                </div>
                <div class="chat-sender">
                    <p>All of the options for changing is the life</p>
                    <span class="date">12:03 PM</span>
                </div>
                <div class="chat-sender">
                    <p><i class="fa fa-image"></i><a href="#">Deserewg.pdf</a></p>
                    <span class="date">12:03 PM</span>
                </div>
            </div>
            <div class="chat-footer d-flex align-items-center justify-content-between">
                <button class="bg-transparent border-0 p-0"><i class="fa fa-microphone"></i></button>
                <button class="bg-transparent border-0 p-0"><i class="fa fa-paperclip"></i></button>
                <button class="bg-transparent border-0 p-0 mr-0"><i class="fa fa-smile"></i></button>
                <div class="form-box position-relative">
                    <input type="text" class="form-control" placeholder="Type Here ....">
                    <button class="border-0">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.16641 5.2668L13.2414 2.90846C16.4164 1.85013 18.1414 3.58346 17.0914 6.75846L14.7331 13.8335C13.1497 18.5918 10.5497 18.5918 8.96641 13.8335L8.26641 11.7335L6.16641 11.0335C1.40807 9.45013 1.40807 6.85846 6.16641 5.2668Z" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M8.4248 11.3755L11.4081 8.38379" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="chat-right">
            <div class="order-wrap">
                <div class="chat-user">
                    <div class="chat-user-head d-flex align-items-center">
                        <div class="chat-user-img">
                            <img src="{{asset(asset_path('images/chat-user'))}}/1.jpg" alt="">
                        </div>
                        <div class="chat-user-content">
                            <h6 class="mb-0 fw-600 text-white">Robert Downey JR.</h6>
                            <p class="text-white mb-0">Dhaka</p>
                        </div>
                    </div>
                    <p class="text-white d-flex align-items-center"><i class="fa fa-envelope"></i> <a href="mailto:demomail@spondonit.com">demomail@spondonit.com</a></p>
                    <p class="text-white d-flex align-items-center"><i class="fa fa-phone"></i> <a href="tel:1 866 832 3090">1 866 832 3090</a></p>
                </div>
                <h6 class="text-primary">Support Against This Order</h6>
                <div>
                    <div class="order-list d-flex align-items-center">
                        <div class="img">
                            <img src="{{asset('public/images/products/1.png')}}" alt="">
                        </div>
                        <div class="content">
                            <p>Osadharon ekti travel bag</p>
                        </div>
                    </div>
                    <div class="order-list d-flex align-items-center">
                        <div class="img">
                            <img src="{{asset('public/images/products/2.png')}}" alt="">
                        </div>
                        <div class="content">
                            <p>Hot & Cold Water Bottle</p>
                        </div>
                    </div>
                    <div class="order-list d-flex align-items-center">
                        <div class="img">
                            <img src="{{asset('public/images/products/3.png')}}" alt="">
                        </div>
                        <div class="content">
                            <p>Infix Advocate</p>
                        </div>
                    </div>
                </div>
                <div class="order-info bg-white">
                    <table class="w-100">
                        <tr>
                            <td>Order Number </td>
                            <td>: </td>
                            <td>#45323433</td>
                        </tr>
                        <tr>
                            <td>Order Date </td>
                            <td>: </td>
                            <td>25th Nov 2022</td>
                        </tr>
                        <tr>
                            <td>Delivery Date </td>
                            <td>: </td>
                            <td>22th Dec 2023</td>
                        </tr>
                        <tr>
                            <td>Order Status </td>
                            <td>: </td>
                            <td>Closed</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    if($(window).width() < 767){
       $(document).on('click', '.chat-list', function(e){
            e.stopPropagation();
            $('.chat-center').fadeIn('fast');
            $('body').addClass('overflow-hidden')
       })
       $(document).on('click', '.chat-close', function(e){
            $('.chat-center').fadeOut('fast');
            $('body').removeClass('overflow-hidden');
       })
    }
</script>
@endsection
