@if(count($reviews) > 0)
@foreach(@$reviews as $key => $review)
    <div class="single_reviews flex-column">
        <div class="single_reviews">
            <div class="thumb">
                @if(@$review->customer->avatar != null)
                    {{\Illuminate\Support\Str::limit(@$review->customer->first_name,1,$end='')}}{{\Illuminate\Support\Str::limit(@$review->customer->last_name,1,$end='')}}
                @elseif($review->is_anonymous == 1)
                    <img src="{{showImage('frontend/default/img/avatar.jpg')}}" alt="{{\Illuminate\Support\Str::limit(@$review->customer->first_name,1,$end='')}}{{\Illuminate\Support\Str::limit(@$review->customer->last_name,1,$end='')}}" title="{{\Illuminate\Support\Str::limit(@$review->customer->first_name,1,$end='')}}{{\Illuminate\Support\Str::limit(@$review->customer->last_name,1,$end='')}}"/>
                @else
                    <img src="{{showImage(@$review->customer->avatar)}}" alt="{{\Illuminate\Support\Str::limit(@$review->customer->first_name,1,$end='')}}{{\Illuminate\Support\Str::limit(@$review->customer->last_name,1,$end='')}}" title="{{\Illuminate\Support\Str::limit(@$review->customer->first_name,1,$end='')}}{{\Illuminate\Support\Str::limit(@$review->customer->last_name,1,$end='')}}"/>
                @endif
            </div>
            <div class="review_content w-100">
                <div class="review_content_head d-flex justify-content-between align-items-start flex-wrap">
                    <div class="review_content_head_left">
                        <h4 class="f_w_700 font_20" >{{$review->is_anonymous==1?'Unknown Name':@$review->customer->first_name.' '.@$review->customer->last_name}}</h4>
                        <div class="rated_customer d-flex align-items-center">
                            <div class="feedmak_stars">
                                @php
                                    $rating = $review->rating;
                                @endphp
                                <x-rating :rating="$rating"/>
                            </div>
                            <span>{{$review->updated_at->diffForHumans()}}</span>
                        </div>
                    </div>
                </div>
                <p>{{$review->review}}</p>

                @if($review->images->count())
                    <div class="review_file mt-3">
                        @php
                            $video = ['mp4'];
                            if (@$review->product->thum_img != null) {
                                $thumbnail = showImage(@$review->product->thum_img);
                            } else {
                                $thumbnail = showImage(@$review->product->product->thumbnail_image_source);
                            }
                        @endphp
                        @foreach($review->images as $key => $image)
                            @php
                                $ext = explode('.',$image->image);

                            @endphp
                            @if(in_array(trim($ext[1]),$video))

                                <div class="review_img_div">
                                    <div class="review_img_div review_video_item">
                                        <a href="{{showImage($image->image)}}">
                                            <img src="{{asset($thumbnail)}}" alt="{{ $review->product->product->product_name }}">
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="review_img_div">
                                    <img class="review_img lightboxed" src="{{showImage($image->image)}}" alt="{{$review->review}}" rel="group{{$review->id}}">
                                </div>
                            @endif
                        @endforeach


                    </div>
                @endif
            </div>
        </div>
        @if(@$review->reply)
            <div class="single_reviews">
                <div class="thumb">
                    @if(@$review->customer->avatar != null)
                        {{\Illuminate\Support\Str::limit(@$review->customer->first_name,1,$end='')}}{{\Illuminate\Support\Str::limit(@$review->customer->last_name,1,$end='')}}
                    @elseif($review->is_anonymous == 1)
                        <img src="{{showImage('frontend/default/img/avatar.jpg')}}" alt="{{\Illuminate\Support\Str::limit(@$review->customer->first_name,1,$end='')}}{{\Illuminate\Support\Str::limit(@$review->customer->last_name,1,$end='')}}" title="{{\Illuminate\Support\Str::limit(@$review->customer->first_name,1,$end='')}}{{\Illuminate\Support\Str::limit(@$review->customer->last_name,1,$end='')}}"/>
                    @else
                        <img src="{{showImage(@$review->customer->avatar)}}" alt="{{\Illuminate\Support\Str::limit(@$review->customer->first_name,1,$end='')}}{{\Illuminate\Support\Str::limit(@$review->customer->last_name,1,$end='')}}" title="{{\Illuminate\Support\Str::limit(@$review->customer->first_name,1,$end='')}}{{\Illuminate\Support\Str::limit(@$review->customer->last_name,1,$end='')}}"/>
                    @endif
                </div>
                <div class="review_content">
                    <div class="review_content_head d-flex justify-content-between align-items-start flex-wrap">
                        <div class="review_content_head_left">
                            <h4 class="f_w_700 font_20" >{{@$review->seller->first_name}}</h4>
                            <div class="rated_customer d-flex align-items-center">
                                <span>{{$review->reply->created_at->diffForHumans()}}</span>
                            </div>
                        </div>
                    </div>
                    <p>{{@$review->reply->review}}</p>

                </div>
            </div>
        @endif
    </div>
@endforeach

@else
<p>{{ __('defaultTheme.no_review_found') }}</p>
@endif

<div class="mb_30 mt_30">
    @if($reviews->lastPage() > 1)
        <x-pagination-component :items="$reviews" type=""/>
    @endif
</div>
