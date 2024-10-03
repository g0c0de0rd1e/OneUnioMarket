<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth','admin'])->prefix('appearance')->as('appearance.')->group(function() {
    //themes
    Route::resource('/themes', 'ThemeController')->except('destroy','update','edit')->middleware('permission');
    Route::post('/themes/store','ThemeController@store')->name('themes.store')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/themes/active','ThemeController@active')->name('themes.active')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/themes/detele','ThemeController@destroy')->name('themes.delete')->middleware('prohibited_demo_mode');
    //Slider
    Route::get('/sliders','HeaderController@index')->name('slider.index')->middleware('permission');
    Route::get('/sliders/setup/{id}','HeaderController@setup')->name('slider.setup')->middleware('permission');
    Route::post('/sliders/update','HeaderController@update')->name('slider.update')->middleware('prohibited_demo_mode');
    Route::post('/sliders/update-status','HeaderController@update_status')->name('slider.update_status')->middleware(['permission','prohibited_demo_mode']);
    Route::post('/sliders/setup/add-element','HeaderController@addElement')->name('slider.setup.add-element')->middleware('prohibited_demo_mode');
    Route::post('/sliders/setup/update-element','HeaderController@updateElement')->name('slider.setup.update-element')->middleware('prohibited_demo_mode');
    Route::post('/sliders/setup/delete-element','HeaderController@deleteElement')->name('slider.setup.delete-element')->middleware('prohibited_demo_mode');
    Route::post('/sliders/setup/sort-element','HeaderController@sortElement')->name('slider.setup.sort-element')->middleware('prohibited_demo_mode');
    Route::post('/sliders/setup/get-slider-type-data','HeaderController@getSliderTypeData')->name('slider.get-slider-type-data');
    Route::get('/dashboard', 'DashboardController@index')->name('dashoboard.index')->middleware('permission');
    Route::post('/setup-update', 'DashboardController@update_status')->name('dashoboard.status_update')->middleware(['permission','prohibited_demo_mode']);
    //color
    Route::get('/get-data','ColorController@get_data')->name('color.get_data');
    Route::post('/color-activate/{id}','ColorController@activate')->name('color.activate')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/color-clone/{id}','ColorController@clone')->name('color.clone')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/color/delete/{id}','ColorController@destroy')->name('color.delete')->middleware(['permission','prohibited_demo_mode']);
    Route::resource('color', ColorController::class);
    //theme color
    Route::get('/theme-color','ThemeColorController@index')->name('themeColor.index')->middleware('permission');
    Route::post('/theme-color/{id}','ThemeColorController@update')->name('themeColor.update')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/theme-color-activate/{id}','ThemeColorController@activate')->name('themeColor.activate')->middleware(['permission','prohibited_demo_mode']);
    Route::get('/pre-loader', 'PreloaderSettingController@index')->name('pre-loader')->middleware('permission');
    Route::post('/pre-loader', 'PreloaderSettingController@update')->name('pre-loader.update')->middleware(['permission','prohibited_demo_mode']);
    // custom asset
    Route::get('/custom-asset', 'CustomAssetController@index')->name('custom-asset')->middleware('permission');
    Route::post('/custom-asset/store', 'CustomAssetController@store')->name('custom-asset-store')->middleware(['permission','prohibited_demo_mode']);
});


