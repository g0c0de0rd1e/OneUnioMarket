<?php

namespace Modules\Shipping\Http\Controllers;


use App\Models\OrderPackageDetail;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Routing\Controller;
use Modules\Shipping\Repositories\OrderRepository;
use Exception;
use Modules\ShipRocket\Repositories\ShipRocketRepository;
use Modules\Torod\Repositories\TorodRepository;

class OrderSyncWithCarrierController extends Controller
{
    public function OrderSyncWithCarrier($package)
    {
        if($package->carrier){

            if($package->carrier->slug == 'Shiprocket'){
                if(sellerWiseShippingConfig($package->seller_id)['order_confirm_and_sync'] == 'Automatic'){

                    if($package->order->customer_id){
                        $deliveryPostCode = $package->order->address->shipping_postcode;
                    }else{
                        $deliveryPostCode = $package->order->guest_info->shipping_post_code;
                    }
                    $COD = $package->order->payment_type == 1 ? 1 : 0;
                    $WEIGHT = $package->weight > 0 ? $package->weight/1000 : 0;
                    $pinCodeDetails = [
                        'pickup_postcode' => $package->pickupPoint->pin_code , //Postcode from where the order will be picked.
                        'delivery_postcode' => $deliveryPostCode, //Postcode where the order will be delivered
                        'weight' => $WEIGHT, //package weight in kgs
                        'cod' => $COD, //1 for Cash on Delivery and 0 for Prepaid orders.
                    ];

                    $shipRocketRepo = new ShipRocketRepository();
                    $courierId = $shipRocketRepo->checkRecommendedCourier($pinCodeDetails,$package);
                    if($courierId){
                        OrderPackageDetail::where('id',$package->id)->update(['shipped_by'=>$courierId]);
                    }
                }
                $shipRocket = new ShipRocketRepository();
                $shipRocket->orderCreate($package);

                return true;
            }elseif($package->carrier->slug == 'torod'){

                if(sellerWiseShippingConfig($package->seller_id)['order_confirm_and_sync'] == 'Automatic'){

                    if($package->order->customer_id){
                        $deliveryPostCode = $package->order->address;
                    }else{
                        $deliveryPostCode = $package->order->guest_info;
                    }

                    $cod = $package->order->payment_type == 1 ? 'COD' : 'Prepaid';
                    $weight = $package->weight > 0 ? $package->weight/1000 : 0;


                    $shippingData = [
                        'name' => $deliveryPostCode->shipping_name,
                        'email' => $deliveryPostCode->shipping_email,
                        'phone_number' => $deliveryPostCode->shipping_phone, //$deliveryPostCode->shipping_phone,
                        'item_description' => $package->number_of_product.' Items',
                        'order_total' => $package->order->grand_total,
                        'payment' => $cod,
                        'weight' => $weight,
                        'no_of_box' => $package->number_of_product,
                        'type' => 'normal',
                        'district_id' => '51',
                        'locate_address' => $deliveryPostCode->shipping_address,
                        "reference_id" => $package->order_number,
                        'meta_data' => json_encode([
                            "order_id" => $package->order->id,
                        ]),
                    ];

                    $torod = new TorodRepository($package->seller_id);



                    $ship = $torod->postOrder($shippingData);
                    if(!empty($package->carrier->id)){
                        OrderPackageDetail::where('id',$package->id)->update(['shipped_by'=> $package->carrier->id,'carrier_order_id' => $ship->order_id]);
                    }


                }
                return true;
            }else{
                return true;
            }

        }else {
            return true;
        }
    }


    public function orderTracking($trackingId)
    {
        try{
            $orderRepo = new OrderRepository();
            $package = $orderRepo->findOrderByTrackingId($trackingId);
            if($package){
                if($package->carrier){
                    if($package->carrier->slug == 'Shiprocket'){
                        $shipRocket = new ShipRocketRepository();
                        $res = $shipRocket->tracking($trackingId,$package);
                        if($res){
                             return $res['status'];
                        }
                        else{
                            return 'failed';
                        }
                    }else{
                        return 'something happen';
                    }

                }else {
                    return 'carrier not found';
                }
            }else{
                return 'order not found';
            }

        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }
    }




}
