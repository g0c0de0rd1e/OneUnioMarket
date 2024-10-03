<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::middleware(['admin', 'auth'])->prefix('/admin/giftcard')->as('admin.giftcard.')->group(function() {
    Route::get('/', 'GiftCardController@index')->name('index')->middleware(['permission']);
    Route::get('/get-data', 'GiftCardController@getData')->name('get-data')->middleware(['permission']);
    Route::get('/create', 'GiftCardController@create')->name('create')->middleware(['permission']);
    Route::get('/edit/{id}', 'GiftCardController@edit')->name('edit')->middleware(['permission']);
    Route::get('/view/{id}', 'GiftCardController@show')->name('view');
    Route::post('/store', 'GiftCardController@store')->name('store')->middleware('prohibited_demo_mode');
    Route::post('/update/{id}', 'GiftCardController@update')->name('update')->middleware('prohibited_demo_mode');
    Route::post('/status', 'GiftCardController@statusChange')->name('status')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/delete', 'GiftCardController@destroy')->name('delete')->middleware(['permission','prohibited_demo_mode']);
    Route::get('bulk-gift-card-upload', 'GiftCardController@bulk_upload_page')->name('bulk_gift_card_upload_page')->middleware(['permission']);
    Route::post('bulk-gift-card-upload-store', 'GiftCardController@bulk_store')->name('bulk_gift_card_store')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/digital-gift-cards','GiftCardController@digitalGiftCard')->name('digital_gift_card')->middleware(['permission']);
    Route::get('/digital-gift-edit/{id}','GiftCardController@digitalGiftEdit')->name('digital_gift_edit')->middleware(['permission']);
    Route::post('/digital-gift-update/{id}','GiftCardController@digitalGiftUpdate')->name('digital_gift_update');
    Route::get('/digital-gift-view/{id}', 'GiftCardController@digitalGiftShow')->name('digital_gift_view');
    Route::post('/digital-gift-delete', 'GiftCardController@digitalDelete')->name('digital_gift_delete');
});
