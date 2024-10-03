<?php

use App\Models\Order;
use App\Models\OrderPackageDetail;
use Carbon\Carbon;
use App\Models\OrderProductDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Modules\Torod\Entities\TorodCourier;
use Modules\Otp\Entities\OtpConfiguration;
use Modules\Seller\Entities\SellerProduct;
use Modules\GeneralSetting\Entities\GeneralSetting;
use Modules\GeneralSetting\Entities\BusinessSetting;
use Modules\Shipping\Entities\SellerWiseCarrierConfig;

if (! function_exists('showStatus')) {
    function showStatus($status)
    {
        if($status == 1){
            return __("common.active");
        }
        return __("common.inactive");
    }
}

if (! function_exists('permissionCheck')) {
    function permissionCheck($route_name)
    {
        if(auth()->check()){
            if(auth()->user()->role->type == "superadmin"){
                return TRUE;
            }elseif (auth()->user()->role->type == "custom") {
                if(auth()->user()->permissions->contains('route',$route_name)){
                    return TRUE;
                }else{
                    return FALSE;
                }
            }else{
                $roles = app('permission_list');
                $role = $roles->where('id',auth()->user()->role_id)->first();
                if($role != null && $role->permissions->contains('route',$route_name)){
                    if($role->name != 'Sub Seller'){
                        return TRUE;
                    }else{
                        if(auth()->user()->permissions->contains('route',$route_name)){
                            return TRUE;
                        }else{
                            return FALSE;
                        }
                    }
                }else{
                    return FALSE;
                }
            }
        }
        return FALSE ;
    }
}

if(!function_exists('getCurrency')){
    function getCurrency()
    {
        if(app('user_currency') != null){
            return app('user_currency')->symbol;
        }else{
            return app('general_setting')->currency_symbol;
        }
    }
}

if (! function_exists('single_price')) {
    function single_price($price)
    {
        if(app('user_currency') != null){
            if (app('user_currency')->symbol == "€") {
                $formet =',';
                $spaceorcomma = ' ';
            }else{
                $formet = '.';
                $spaceorcomma = ',';
            }
            $price_formet = getNumberTranslate(number_format(($price * app('user_currency')->convert_rate), app('general_setting')->decimal_limit, $formet, $spaceorcomma));
            if(app('general_setting')->currency_symbol_position == 'left'){
                return app('user_currency')->symbol . $price_formet;
            }
            elseif(app('general_setting')->currency_symbol_position == 'left_with_space'){
                return app('user_currency')->symbol ." ". $price_formet;
            }
            elseif(app('general_setting')->currency_symbol_position == 'right'){
                return $price_formet.app('user_currency')->symbol;
            }
            elseif(app('general_setting')->currency_symbol_position == 'right_with_space'){
                return $price_formet. " " . app('user_currency')->symbol;
            } else{
                return app('user_currency')->symbol ." ". $price_formet;
            }
        }

        if(app('general_setting')->currency_symbol != null){
            if (app('general_setting')->currency_symbol == "€") {
                $formet =',';
                $spaceorcomma = ' ';
            }else{
                $formet = '.';
                $spaceorcomma = ',';
            }
            $price_formet = getNumberTranslate(number_format($price, app('general_setting')->decimal_limit, $formet, $spaceorcomma));
            if(app('general_setting')->currency_symbol_position == 'left'){
                return app('general_setting')->currency_symbol . $price_formet;
            }
            elseif(app('general_setting')->currency_symbol_position == 'left_with_space'){
                return app('general_setting')->currency_symbol ." ". $price_formet;
            }
            elseif(app('general_setting')->currency_symbol_position == 'right'){
                return $price_formet . app('general_setting')->currency_symbol;
            }
            elseif(app('general_setting')->currency_symbol_position == 'right_with_space'){
                return $price_formet ." ".app('general_setting')->currency_symbol;
            }else{
                return app('general_setting')->currency_symbol ." ". $price_formet;
            }
        }else {
            return '$ '.getNumberTranslate(number_format($price, 2));
        }
    }
}

if (! function_exists('step_decimal')) {
    function step_decimal(){
        $step_value = app('general_setting')->decimal_limit;
        if($step_value > 1){
            $process_value = '0.';
            for($i=1;$i<=$step_value;$i++){
                $process_value .= '0';
            }
            return doubleval($process_value.'1');
        }
        return 0;
    }
}

if(!function_exists('hasBusinessInfo')){
    function hasBusinessInfo(){
        $business_info = DB::table('seller_business_information')->where('user_id',auth()->user()->id)->first();
        if(!empty($business_info) && $business_info->business_owner_name != '' &&  $business_info->business_address1 != '' && $business_info->business_country != '' && $business_info->business_state != '' ){
            return true;
        }
        return false;
    }
}

//returns combinations of customer choice options array
if (! function_exists('combinations')) {
    function combinations($arrays) {
        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;
    }
}

if(!function_exists('product_attribute_editable')){
    function product_attribute_editable($product_id){
        $seller_product_exsist = SellerProduct::whereHas('product', function($query) use ($product_id){
            return $query->where('product_id', $product_id)->where('user_id','!=',1);
        })->pluck('id');
        $order_exsist = OrderProductDetail::where('type', 'product')->whereHas('seller_product_sku', function($query) use($product_id){
            return $query->whereHas('product', function($q) use($product_id){
                return $q->whereHas('product', function($q1) use($product_id){
                    return $q1->where('product_id', $product_id);
                });
            });
        })->pluck('id');
        if($seller_product_exsist->count() || $order_exsist->count()){
            return false;
        }
        return true;
    }
}

if (!function_exists('dateConvert')) {
    function dateConvert($input_date){
        if(!$input_date){
            return $input_date;
        }
        try {
            $system_date_format = app('general_setting')->dateFormat->format;
            return getNumberTranslate(Carbon::parse($input_date)->translatedFormat($system_date_format));
        } catch (\Throwable $th) {
            return $input_date;
        }
    }
}

if (! function_exists('gateway_name')) {
    function gateway_name($number) {
        switch ($number) {
            case '1':
                return __("payment_gatways.cash_on_delivery");
                break;
            case '2':
                return __("payment_gatways.wallet");
                break;
            case '3':
                return __("payment_gatways.paypal");
                break;
            case '4':
                return __("payment_gatways.stripe");
                break;
            case '5':
                return __("payment_gatways.paystack");
                break;
            case '6':
                return __("payment_gatways.razorpay");
                break;
            case '7':
                return __("payment_gatways.bank_payment");
                break;
            case '8':
                return __("payment_gatways.instamojo");
                break;
            case '9':
                return __("payment_gatways.paytm");
                break;
            case '10':
                return __("payment_gatways.midtrans");
                break;
            case '11':
                return __("payment_gatways.payumoney");
                break;
            case '12':
                return __("payment_gatways.jazzcash");
                break;
            case '13':
                return __("payment_gatways.google_pay");
                break;
            case '14':
                return __("payment_gatways.flutter_wave_payment");
                break;
            case '15':
                return __("payment_gatways.bkash");
                break;
            case '16':
                return __("payment_gatways.ssl_commerz");
                break;
            case '17':
                return __("payment_gatways.mercado_pago");
                break;
            case '18':
                return __("payment_gatways.tabby");
                break;
            case '19':
                return __("payment_gatways.ccavenue");
                break;
            case 'BankPayment':
                return __("payment_gatways.bank_payment");
                break;
            default:
            return "No Gateway";
            break;
        }
    }
}

if (! function_exists('wallet_balance')) {
    function wallet_balance(){
        $deposite = auth()->user()->wallet_balances->where('type', 'Deposite')->sum('amount');
        $refund_back = auth()->user()->wallet_balances->where('type', 'Refund Back')->sum('amount');
        $expensed = auth()->user()->wallet_balances->where('type', 'Cart Payment')->sum('amount');
        $rest_money = $deposite + $refund_back - $expensed;
        return $rest_money;
    }
}

if (! function_exists('seller_wallet_balance_pending')) {
    function seller_wallet_balance_pending(){
        $deposite = auth()->user()->wallet_balances->where('type', 'Deposite')->where('status', 0)->sum('amount');
        $withdraw = auth()->user()->wallet_balances->where('type', 'Withdraw')->where('status', 0)->sum('amount');
        $expense = auth()->user()->wallet_balances->where('type', 'Refund')->where('status', 0)->sum('amount');
        $income = auth()->user()->wallet_balances->where('type', 'Sale Payment')->where('status', 0)->sum('amount');
        $rest_money = $deposite + $income - $expense - $withdraw;
        return $rest_money;
    }
}

if (! function_exists('seller_wallet_balance_running')) {
    function seller_wallet_balance_running(){
        $deposite = auth()->user()->wallet_balances->where('type', 'Deposite')->where('status', 1)->sum('amount');
        $withdraw = auth()->user()->wallet_balances->where('type', 'Withdraw')->where('status', 1)->sum('amount');
        $expense = auth()->user()->wallet_balances->where('type', 'Refund')->where('status', 1)->sum('amount');
        $income = auth()->user()->wallet_balances->where('type', 'Sale Payment')->where('status', 1)->sum('amount');
        $expensed = auth()->user()->wallet_balances->where('status',1)->where('type', 'Cart Payment')->sum('amount');
        $rest_money = $deposite + $income - $expense - $withdraw -$expensed;
        if($rest_money < 0){
            return 0;
        }
        return $rest_money;
    }
}

if(!function_exists('sellerPendingEarning')) {
    function sellerPendingEarning()
    {
        $amount = 0;
        $seller = getParentSeller()->sellerAccount;
        $ids= [];
        $shipping_cost = 0;
        $orders = OrderPackageDetail::where('seller_id', $seller->user_id)->where('delivery_status','!=',5)->select(['shipping_cost','order_id'])->get();

        foreach ($orders as $key => $order) {
            $ids[$key]=$order->order_id;
            $shipping_cost+= $order->shipping_cost;
        }
        if($seller->seller_commission_id == 1)
        {
            $product_amount = OrderProductDetail::whereIn('package_id', $ids)->sum('total_price');
            $commission_rate = $seller->commission_rate;
            $comission = ($product_amount * $commission_rate) / 100;

            $seller_amount  = $product_amount - $comission;
        }elseif($seller->seller_commission_id == 2){

        }else{
            $seller_amount = OrderProductDetail::whereIn('package_id', $ids)->sum('total_price');
        }


        return $seller_amount + $shipping_cost;

    }
}

if (!function_exists('filterDateFormatingForSearchQuery')) {
    function filterDateFormatingForSearchQuery($value)
    {
        $data = explode("-",$foo = preg_replace('/\s+/', ' ', $value));
        return [Carbon::parse($data[0])->format('Y-m-d'),Carbon::parse($data[1])->format('Y-m-d')];
    }
}

if (!function_exists('barcodeList')) {
    function barcodeList()
    {
        return $array = array("C39", "C39+", "C39E", "C39E+", "C93", "I25", "POSTNET", "EAN2", "EAN5", "PHARMA2T");
    }
}

if (!function_exists('auto_approve_seller')) {
    function auto_approve_seller()
    {
        $autoApproveSetting = GeneralSetting::first();
        return $autoApproveSetting->auto_approve_seller;
    }
}

if (!function_exists('auto_approve_seller_review')) {
    function auto_approve_seller_review()
    {
        $autoApproveSetting = GeneralSetting::first();
        return $autoApproveSetting->auto_approve_seller_review;
    }
}

if (!function_exists('auto_approve_product_review')) {
    function auto_approve_product_review()
    {
        $autoApproveSetting = GeneralSetting::first();
        return $autoApproveSetting->auto_approve_product_review;
    }
}

if (!function_exists('otp_configuration')) {
    function otp_configuration($key)
    {
        if(isModuleActive('Otp')){
            $otpConfiguration = OtpConfiguration::where('key',$key)->first();
            return $otpConfiguration->value ?? NULL;
        }
        return NULL;
    }
}

if (!function_exists('smsGatewaySetting')) {
    function smsGatewaySetting()
    {
        try {
            if (Cache::has('sms_gateway_setting')) {
                $sms_gate_way =  Cache::get('sms_gateway_setting');
                return $sms_gate_way;
            } else {
                $setting = \Modules\GeneralSetting\Entities\SmsGatewaySetting::first();
                if($setting){
                    $data = collect($setting->toArray())->except(['id','created_at','updated_at'])->all();
                    Cache::forget('sms_gateway_setting');
                    Cache::rememberForever('sms_gateway_setting', function () use($data) {
                        return $data;
                    });
                    $sms_gate_way =  Cache::get('sms_gateway_setting');
                    return $sms_gate_way;
                }
                return false;
            }
        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('validationMessage')) {
    function validationMessage($validation_rules)
    {
        $message = [];
        foreach ($validation_rules as $attribute => $rules) {

            if (is_array($rules)) {
                $single_rule = $rules;
            } else {
                $single_rule = explode('|', $rules);
            }

            foreach ($single_rule as $rule) {
                $string = explode(':', $rule);
                $key = $attribute;
                if (strpos($attribute, '.')) {
                    $attr = explode('.', $attribute);
                    $key = $attr[0] ?? '';
                }
                $message [$attribute . '.' . $string[0]] = __('validation.' . $key . '.' . $string[0]);
            }
        }
        return $message;
    }
}

if (!function_exists('showDate')) {
    function showDate($date)
    {
        try {
            if (!$date) {
                return '';
            }
            return date(app('general_setting')->dateFormat->format, strtotime($date));
        } catch (\Exception $e) {
            return '';
        }
    }
}

if (!function_exists('showImage')) {
    function showImage($path)
    {

        if($path){
            if(strpos($path, 'amazonaws.com') != false || strpos($path, 'digitaloceanspaces.com') != false || strpos($path, 'drive.google.com') != false || strpos($path, 'wasabisys.com') != false || strpos($path, 'backblazeb2.com') != false || strpos($path, 'dropboxusercontent.com') != false || strpos($path, 'b-cdn.net') != false || strpos($path, 'contabostorage.com') != false){

                if(strpos($path, 'drive.google.com')){
                    $qs = getQueryParams($path);
                    return 'https://lh3.google.com/u/0/d/'.$qs['id'];
                }else{
                    return $path;
                }
            }
            else{
                return asset(asset_path($path));
            }
        }else{
            return asset(asset_path(themeDefaultImg()));
        }
    }
}

if (!function_exists('activeFileStorage')) {
    function activeFileStorage()
    {
        try {
            if (Cache::has('file_storage')) {
                $file_storage =  Cache::get('file_storage');
                return $file_storage;
            } else {
                $row = BusinessSetting::where('category_type','file_storage')->where('status',1)->first();
                if($row){
                    Cache::forget('file_storage');
                    Cache::rememberForever('file_storage', function () use($row) {
                        return $row->type;
                    });
                    $file_storage =  Cache::get('file_storage');
                    return $file_storage;
                }else{
                    return 'Local';
                }
            }
        } catch (Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('putEnvConfigration')) {
    function putEnvConfigration($envKey, $envValue)
    {
        $value = '"' . $envValue . '"';
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $str .= "\n";
        $keyPosition = strpos($str, "{$envKey}=");
        if (is_bool($keyPosition)) {
            $str .= $envKey . '="' . $envValue . '"';
        } else {
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
            $str = str_replace($oldLine, "{$envKey}={$value}", $str);
            $str = substr($str, 0, -1);
        }
        if (!file_put_contents($envFile, $str)) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('currencyCode')) {
    function currencyCode()
    {
        $currency_code = app('general_setting')->currency_code;
        if(\Session::has('currency')){
            $currency = \Modules\GeneralSetting\Entities\Currency::where('id', session()->get('currency'))->first();
            $currency_code = $currency->code;
        }
        if(auth()->check()){
            $currency_code = auth()->user()->currency_code;
        }
        return $currency_code;
    }
}

if (!function_exists('routeIsExist')) {
    function routeIsExist($route)
    {
        if (Route::has($route)) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('validRouteUrl')) {
    function validRouteUrl($route)
    {
        $url = null;
        try {
            if (routeIsExist($route)) {
                $url = \route($route);
            }
        } catch (\Exception $e) {
        }
        return $url;
    }
}

if(!function_exists('isGuestAddtoCart'))
{
     function isGuestAddtoCart(){
        if( app('general_setting')->user_login_checkout == 1){
            if(auth()->check()){
                return true;
            }else{
                return false;
            }
        }else{
           return true;
        }
     }
}


if(!function_exists('manualActivation'))
{
    function manualActivation()
    {
        if( app('general_setting')->user_manual_activation == 1){
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('convertCurrency'))
{
    function convertCurrency($amount)
    {
        $currency_code = app('general_setting')->currency_code;
        if(\Session::has('currency')){
            $currency = \Modules\GeneralSetting\Entities\Currency::where('id', session()->get('currency'))->first();
            $currency_code = $currency->code;
        }
        if(auth()->check()){
            $currency_code = auth()->user()->currency_code;
        }

        $selectedCurrency = \Modules\GeneralSetting\Entities\Currency::where('code', $currency_code)->first();
        $rate = $selectedCurrency->convert_rate;
        $final_amount = $rate * $amount;
        return round($final_amount,2);
    }
}


if(!function_exists('shippingCredentials'))
{
    function shippingCredentials($carrier_id , $seller_id = null)
    {
        if($seller_id == null){
            $seller_id = getParentSellerId();
        }

        $credential = SellerWiseCarrierConfig::where('seller_id',$seller_id)->where('carrier_id',$carrier_id)->first();
        return $credential;
    }
}

if(!function_exists('getTorodCouriers'))
{
    function getTorodCouriers()
    {
        return TorodCourier::all();
    }
}
