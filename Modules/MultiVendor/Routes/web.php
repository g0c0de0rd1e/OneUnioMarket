<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\ProductController;

Route::get('/seller/login', [LoginController::class, 'showSellerLoginForm'])->name('seller.login');
Route::post('/seller/login', [LoginController::class, 'sellerLogin'])->name('seller.login_submit');
Route::get('/seller', function(){
    return redirect(url('/seller/login'));
});
Route::middleware(['auth','admin'])->prefix('admin')->group(function() {
    Route::get('/merchants', 'MerchantController@index')->name('admin.merchants_list');
    Route::get('/inactive-merchants', 'MerchantController@inactiveMerchants')->name('admin.inactiveMerchants');
    Route::get('/merchants-{id}', 'MerchantController@secretLogin')->name('admin.secret_login')->middleware(['permission']);
    Route::get('/merchants/get-data', 'MerchantController@getData')->name('admin.merchants_list.get-data');
    Route::get('/merchant-create', 'MerchantController@create')->name('admin.merchants_create')->middleware(['permission']);
    Route::post('/merchant-add-form-data', 'MerchantController@store')->name('admin.merchants_store')->middleware('prohibited_demo_mode');
    Route::post('/merchant-gst-status-change', 'MerchantController@gst_status_update')->name('admin.merchants_gst_status_update')->middleware('prohibited_demo_mode');
    Route::get('/merchant/{id}/details', 'MerchantController@show')->name('admin.merchant_show_details')->middleware(['permission']);
    Route::get('/merchant/{id}/details/get-orders', 'MerchantController@getOrders')->name('admin.merchant_show_details.get-orders');
    Route::post('/merchant-order-request-details', 'MerchantController@orders_show')->name('order.merchant_order_show_details');
    Route::get('/merchant/{id}/details/get-order-refund', 'MerchantController@getOrderRefund')->name('admin.merchant_show_details.order.refund');
    Route::post('/merchant-refund-request-details', 'MerchantController@merchant_show')->name('refund.merchant_refund_show_details');
    Route::get('/merchant/{id}/details/get-wallet-history', 'MerchantController@getWalletHistory')->name('admin.merchant_show_details.get-wallet-history');
    Route::get('/merchant/{id}/details/get-product', 'MerchantController@getProduct')->name('admin.merchant_show_details.get-product');
    Route::get('/profile-edit/{id}','MerchantController@edit')->name('admin.merchant_edit_profile')->middleware(['permission']);
    Route::post('/commission-update','MerchantController@update_commission')->name('admin.update_commission')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/change-trusted-status/{id}','MerchantController@change_merchant_trusted_status')->name('admin.change_merchant_trusted_status')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/update-status/{userId}','MerchantController@update_status')->name('admin.update_status')->middleware(['prohibited_demo_mode']);
    Route::post('/change-seller-password-store','MerchantController@changeSellerPasswordStore')->name('admin.change-seller-password-store')->middleware(['prohibited_demo_mode']);
    
    Route::get('/subscription-payment-list', 'SellerController@subscription_payment_index')->name('admin.subscription_payment_list')->middleware(['permission']);
    Route::get('/subscription-payment-list-dtbl', 'SellerController@subscription_payment_dtbl')->name('admin.subscription_payment_dtbl');
    Route::post('/subscription-payment-approve', 'SellerController@approve')->name('admin.subscription_payment_approve')->middleware(['prohibited_demo_mode','permission']);
    Route::get('/seller-subscription-crone-job', 'SellerController@subscription_crone_job')->name('subscription_crone_job');
    // Configuration
    Route::get('/seller-configuration', 'MerchantController@seller_configuration')->name('admin.seller_configuration');
    Route::post('/seller-configuration', 'MerchantController@seller_configuration_update')->name('admin.seller_configuration_update')->middleware('prohibited_demo_mode');
    Route::get('/seller-commisions', 'CommisionController@index')->name('admin.seller_commission_index');
    Route::get('/seller-commisions-list', 'CommisionController@item_index')->name('admin.seller_commission_item_index')->middleware(['permission']);
    Route::get('/seller-commisions/{id}/edit', 'CommisionController@edit')->name('admin.seller_commission_edit')->middleware(['permission']);
    Route::post('/seller-commisions/{id}/update', 'CommisionController@update')->name('admin.seller_commission_update')->middleware('prohibited_demo_mode');
});
Route::middleware(['auth','seller'])->prefix('seller')->as('seller.')->group(function() {
    Route::get('/dashboard', 'SellerController@index')->name('dashboard');
    Route::get('/seller-dashboard-cards-info/{type}', 'SellerController@dashboardCards')->name('dashboard_card');
    Route::get('/seller-subscription-payment-select/{id}', 'SellerController@subscriptionPaymentPage')->name('subscription_payment_select')->middleware('permission');
    Route::post('/seller-subscription-payment', 'SellerController@subscriptionPayment')->name('subscription_payment')->middleware('prohibited_demo_mode');
    Route::get('/my-subscription-payment-list', 'SellerController@my_subscription_payment')->name('my_subscription_payment_list')->middleware('permission');
    //seller profile
    Route::get('/profile','ProfileController@index')->name('profile.index');
    Route::get('/profile/tab/{id}','ProfileController@tabSelect')->name('profile.content-tabselect');
    Route::post('/profile/seller-account/update/{id}','ProfileController@sellerAccountUpdate')->name('profile.seller-account.update')->middleware('prohibited_demo_mode');
    Route::post('/profile/business-information/update/{id}','ProfileController@businessInformationUpdate')->name('profile.business-information.update')->middleware('prohibited_demo_mode');
    Route::post('/profile/bank-account/update/{id}','ProfileController@bankAccountUpdate')->name('profile.bank-account.update')->middleware('prohibited_demo_mode');
    Route::post('/profile/warehouse-address/update/{id}','ProfileController@warehouseAddressUpdate')->name('profile.warehouse-address.update')->middleware('prohibited_demo_mode');
    Route::post('/profile/return-address/update/{id}','ProfileController@returnAddressUpdate')->name('profile.return-address.update')->middleware('prohibited_demo_mode');
    Route::post('/profile/return-address/change','ProfileController@returnAddresChange')->name('profile.return-address.change')->middleware('prohibited_demo_mode');
    Route::post('/profile/business-information/img-delete','ProfileController@businessImgDelete')->name('profile.business-information.img-delete')->middleware('prohibited_demo_mode');
    Route::post('/profile/bank-account/img-delete','ProfileController@bankImgDelete')->name('profile.bank-account.img-delete')->middleware('prohibited_demo_mode');
    //seller setting
    Route::get('/setting','SettingController@index')->name('setting.index');
    Route::get('/setting/tab/{id}','SettingController@sectionControl')->name('setting.tab');
    Route::post('/setting/logo/update/{id}','SettingController@logoUpdate')->name('setting.logo.update')->middleware('prohibited_demo_mode');
    //social link
    Route::post('setting/social-link/store', 'SettingController@socialLinkStore')->name('setting.social-link.store')->middleware('prohibited_demo_mode');
    Route::post('setting/social-link/update', 'SettingController@socialLinkUpdate')->name('setting.social-link.update')->middleware('prohibited_demo_mode');
    Route::post('setting/social-link/delete', 'SettingController@socialLinkDelete')->name('setting.social-link.delete')->middleware('prohibited_demo_mode');
    // Shipping Method
    Route::post('/store', 'ShippingController@store')->name('shipping_methods.store')->middleware('prohibited_demo_mode');
    Route::post('/delete', 'ShippingController@destroy')->name('shipping_methods.destroy')->middleware('prohibited_demo_mode');
    //seller commission
    Route::get('/seller-commission','SellerCommissionController@index')->name('category_commission_info.index');
    // Sub-Seller
    Route::get('/my-staff','SubSellerController@index')->name('sub_seller.index');
    Route::get('/my-staff-create','SubSellerController@create')->name('sub_seller.create');
    Route::get('/my-staff-edit/{id}','SubSellerController@edit')->name('sub_seller.edit');
    Route::post('/my-staff-store','SubSellerController@store')->name('sub_seller.store')->middleware('prohibited_demo_mode');
    Route::post('/my-staff-update/{id}','SubSellerController@update')->name('sub_seller.update')->middleware('prohibited_demo_mode');
    Route::get('/my-staff-delete/{id}','SubSellerController@delete')->name('sub_seller.delete')->middleware('prohibited_demo_mode');
    Route::get('/my-staff-access-permission/{id}','SubSellerController@access_permission')->name('sub_seller.access_permission');
    Route::post('/my-staff-access-permission-store','SubSellerController@access_permission_store')->name('sub_seller.access_permission_store')->middleware('prohibited_demo_mode');
    // seller bulk upload
    Route::get('/bulk-product-upload','SellerController@bulk_product_upload')->name('bulk_product_upload');
    Route::post('/bulk-product-upload-store',[ProductController::class,'bulk_product_store'])->name('bulk_product_store')->middleware('prohibited_demo_mode');
    Route::get('download-category-list-csv', 'MerchantController@csv_category_download')->name('csv_category_download');
    Route::get('download-brand-list-csv', 'MerchantController@csv_brand_download')->name('csv_brand_download');
    Route::get('download-unit-list-csv', 'MerchantController@csv_unit_download')->name('csv_unit_download');
    Route::get('download-media-id-list-csv', 'MerchantController@csv_media_ids_download')->name('csv_media_ids_download');
    // order commission for admin
    Route::get('/order-commssion-for-admin','SellerController@orderCommissionForAdmin')->name('order-commssion-for-admin');
    Route::get('/order-commssion-for-admin-data','SellerController@getOrderCommision')->name('order-commssion-for-admin-data');
    // followers
    Route::get('/follow-seller', 'FollowSellerController@index')->name('seller_follow')->middleware('permission');
    Route::get('/followers-seller', 'FollowSellerController@seller_followers')->name('seller_followers');
    Route::post('/follower-remove','FollowSellerController@removeFollower')->name('follower-remove')->middleware('prohibited_demo_mode');
});


