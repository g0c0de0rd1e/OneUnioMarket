<?php

namespace App\Repositories;
use File;
use App\Traits\ImageStore;
use App\Traits\Notification;
use Illuminate\Support\Carbon;
use App\Models\OrderPackageDetail;
use Modules\Review\Entities\ReviewImage;
use Modules\Review\Entities\SellerReview;
use Modules\Review\Entities\ProductReview;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\GeneralSetting\Entities\NotificationSetting;

class ProductReviewRepository
{
    use ImageStore, Notification;

    public function store($data, $user = null)
    {

        $current_date  = Carbon::now()->format('d-m-Y');
        $old_review = ProductReview::where('customer_id', $user->id)->where('seller_id', $data['seller_id'])->where('package_id', $data['package_id'])->first();
        if ($old_review) {
            return false;
        } else {
            $product_type_temp = '';

            foreach ($data['product_id'] as $key => $id) {
                $product_type_temp = $data['product_type'][$key];
                $review = ProductReview::create([
                    'customer_id' => $user->id,
                    'seller_id' => $data['seller_id'],
                    'product_id' => $id,
                    'type' => $product_type_temp,
                    'order_id' => $data['order_id'],
                    'package_id' => $data['package_id'],
                    'review' => isset($data['product_review'][$key]) ? $data['product_review'][$key] : null,
                    'rating' => ($product_type_temp == 'product') ? $data['product_rating_' . $id] : $data['giftcard_rating_' . $id],
                    'is_anonymous' => isset($data['is_anonymous']) ? $data['is_anonymous'] : 0
                ]);
                if ($product_type_temp == 'product') {

                    if (isset($data['product_images_' . $id])) {

                        foreach ($data['product_images_' . $id] as $key => $image) {
                            $file_extention = $image->getClientOriginalExtension();
                            $video_extentions = ['mp4'];

                            if(in_array($file_extention, $video_extentions)){

                                    if(!File::isDirectory(public_path('uploads/review_videos/').$current_date)){
                                        File::makeDirectory(public_path('uploads/review_videos/').$current_date, 0777, true, true);
                                    }
                                    $video_name = time().'.'.$file_extention;
                                    $image->move(public_path('uploads/review_videos/'.$current_date),$video_name);
                                    $imagename = 'uploads/review_videos/'.$current_date.'/'. $video_name;
                            }else{
                                $imagename = ImageStore::saveImage($image);
                            }

                            $reviewImg =  ReviewImage::create([
                                'review_id' => $review->id,
                                'product_id' => $id,
                                'type' => $product_type_temp,
                                'image' => $imagename
                            ]);

                            dump($reviewImg);
                        }
                    }
                } else {
                    if (isset($data['gift_images_' . $id])) {
                        foreach ($data['gift_images_' . $id] as $key => $image) {
                            $file_extention = $image->getClientOriginalExtension();
                            $video_extentions = ['mp4'];

                            if(in_array($file_extention, $video_extentions)){
                                    if($image->getSize() < 2283670){
                                        if(!File::isDirectory(asset_path('uploads/review_videos/').$current_date)){
                                            File::makeDirectory(asset_path('uploads/review_videos/').$current_date, 0777, true, true);
                                        }
                                        $video_name = time().'.'.$file_extention;
                                        $image->move(public_path('uploads/review_videos/'.$current_date),$video_name);
                                        $imagename = 'uploads/review_videos/'.$current_date.'/'. $video_name;
                                    }
                                    return false;

                            }else{
                                $imagename = ImageStore::saveImage($image);
                            }

                            ReviewImage::create([
                                'review_id' => $review->id,
                                'product_id' => $id,
                                'type' => $product_type_temp,
                                'image' => $imagename
                            ]);
                        }
                    }
                }
            }
            $sellerReview = SellerReview::create([
                'seller_id' => $data['seller_id'],
                'order_id' => $data['order_id'],
                'rating' => $data['seller_rating'],
                'review' => isset($data['seller_review']) ? $data['seller_review'] : null,
                'customer_id' => $user->id,
                'is_anonymous' => isset($data['is_anonymous']) ? $data['is_anonymous'] : 0
            ]);

            if(auto_approve_seller_review()){
                $sellerReview->status = 1;
                $sellerReview->save();
            }

            if(auto_approve_product_review()){
                // Send Notification to seller direct
                $review->status = 1;
                $review->save();
                if(isModuleActive('MultiVendor')){
                    $notificationUrl = route('seller.product-reviews.index');
                    $notificationUrl = str_replace(url('/'),'',$notificationUrl);
                    $this->notificationUrl = $notificationUrl;
                    $this->adminNotificationUrl = '/review/product-list';
                    $this->routeCheck = 'review.product.index';
                    $this->typeId = EmailTemplateType::where('type', 'review_email_template')->first()->id;
                    $notification = NotificationSetting::where('slug','product-review')->first();
                    if ($notification) {
                        $this->notificationSend($notification->id, $data['seller_id']);
                    }
                }
            }else{
                // Send Notification to admin
                $notificationUrl = route('review.product.index');
                $notificationUrl = str_replace(url('/'),'',$notificationUrl);
                $this->notificationUrl = $notificationUrl;
                $this->adminNotificationUrl = '/review/product-list';
                $this->routeCheck = 'review.product.index';
                $this->typeId = EmailTemplateType::where('type', 'review_email_template')->first()->id;
                $notification = NotificationSetting::where('slug','product-review')->first();
                if ($notification) {
                    $this->notificationSend($notification->id, 1);
                }
            }


            OrderPackageDetail::where('id', $data['package_id'])->update([
                'is_reviewed' => 1
            ]);

            return true;
        }
    }

    public function waitingForReview($user)
    {

        return OrderPackageDetail::with('order', 'products.giftCard', 'products.seller_product_sku.product.product', 'products.seller_product_sku.product_variations.attribute', 'products.seller_product_sku.product_variations.attribute_value.color')->where('delivery_status', '>=', 5)->where('is_reviewed', 0)->whereHas('order', function ($query) use ($user) {
            $query->where('customer_id', $user->id);
        })->get();
    }

    public function reviewList($user_id)
    {
        return OrderPackageDetail::with('order', 'reviews', 'reviews.giftcard', 'reviews.product.product', 'products.seller_product_sku.product_variations.attribute', 'products.seller_product_sku.product_variations.attribute_value.color', 'reviews.product.product', 'reviews.reply', 'reviews.seller', 'reviews.images')->where('is_reviewed', 1)->whereHas('order', function ($query) use ($user_id) {
            $query->where('customer_id', $user_id);
        })->get();
    }
}
