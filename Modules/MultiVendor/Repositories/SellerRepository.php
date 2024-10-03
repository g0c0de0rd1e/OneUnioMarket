<?php
namespace Modules\MultiVendor\Repositories;

use App\Models\OrderPayment;
use Carbon\Carbon;

class SellerRepository {

    public function orderCommissionForAdmin($data){
        $year = Carbon::now()->year;
        if($data == 'today'){
            $payments = OrderPayment::whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->where('amount_goes_to_seller', 1)->where('commision_amount', '>', 0)->whereHas('order', function($query){
                return $query->whereHas('packages', function($q){
                    return $q->where('seller_id', getParentSellerId());
                });
            })->sum('commision_amount');
        }
        elseif($data == 'week'){
            $payments = OrderPayment::whereBetween('created_at', [Carbon::now()->subDays(7)->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->where('amount_goes_to_seller', 1)->where('commision_amount', '>', 0)->whereHas('order', function($query){
                return $query->whereHas('packages', function($q){
                    return $q->where('seller_id', getParentSellerId());
                });
            })->sum('commision_amount');
        }
        elseif($data == 'month'){
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $payments = OrderPayment::whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->where('amount_goes_to_seller', 1)->where('commision_amount', '>', 0)->whereHas('order', function($query){
                return $query->whereHas('packages', function($q){
                    return $q->where('seller_id', getParentSellerId());
                });
            })->sum('commision_amount');
        }
        elseif($data == 'year'){
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $payments = OrderPayment::whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->where('amount_goes_to_seller', 1)->where('commision_amount', '>', 0)->whereHas('order', function($query){
                return $query->whereHas('packages', function($q){
                    return $q->where('seller_id', getParentSellerId());
                });
            })->sum('commision_amount');
        }
        return $payments;
    }

    public function orderCommissionForAdminViaFilter($data = 'today'){
        $year = Carbon::now()->year;
        if($data == 'today'){
            $payments = OrderPayment::whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->where('amount_goes_to_seller', 1)->where('commision_amount', '>', 0)->whereHas('order', function($query){
                return $query->whereHas('packages', function($q){
                    return $q->where('seller_id', getParentSellerId());
                });
            });
        }
        elseif($data == 'week'){
            $payments = OrderPayment::whereBetween('created_at', [Carbon::now()->subDays(7)->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->where('amount_goes_to_seller', 1)->where('commision_amount', '>', 0)->whereHas('order', function($query){
                return $query->whereHas('packages', function($q){
                    return $q->where('seller_id', getParentSellerId());
                });
            });
        }
        elseif($data == 'month'){
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $payments = OrderPayment::whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->where('amount_goes_to_seller', 1)->where('commision_amount', '>', 0)->whereHas('order', function($query){
                return $query->whereHas('packages', function($q){
                    return $q->where('seller_id', getParentSellerId());
                });
            });
        }
        elseif($data == 'year'){
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $payments = OrderPayment::whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->where('amount_goes_to_seller', 1)->where('commision_amount', '>', 0)->whereHas('order', function($query){
                return $query->whereHas('packages', function($q){
                    return $q->where('seller_id', getParentSellerId());
                });
            });
        }
        return $payments;
    }
}
