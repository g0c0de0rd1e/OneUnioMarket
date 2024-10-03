<?php

namespace Modules\GiftCard\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Schema;
use Modules\GiftCard\Entities\GiftCard;
use Yajra\DataTables\Facades\DataTables;
use Modules\GiftCard\Entities\DigitalGiftCard;
use Modules\GiftCard\Services\GiftCardService;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\GiftCard\Http\Requests\CreateGiftCardRequest;
use Modules\GiftCard\Http\Requests\UpdateGiftCardRequest;

class GiftCardController extends Controller
{
    protected $giftcardService;

    public function __construct(GiftCardService $giftcardService)
    {
        $this->giftcardService = $giftcardService;
        $this->middleware(['auth','maintenance_mode']);
    }

    public function index()
    {
        return view('giftcard::giftcard.index');
    }

    public function bulk_upload_page()
    {
        return view('giftcard::giftcard.bulk_upload');
    }

    public function bulk_store (Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx|max:2048'
        ]);
        ini_set('max_execution_time', 0);
        DB::beginTransaction();
        try {
            $this->giftcardService->csvUploadCategory($request->except("_token"));
            DB::commit();
            Toastr::success(__('common.uploaded_successfully'),__('common.success'));
            LogActivity::successLog('gift card uploaded.');
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            if ($e->getCode() == 23000) {
                Toastr::error(__('common.duplicate_entry_is_exist_in_your_file'));
            }
            else {
                Toastr::error(__('common.operation_failed'));
            }
            return back();
        }
    }

    public function getData(){

        $card = $this->giftcardService->getAll();
        return DataTables::of($card)
            ->addIndexColumn()

            ->addColumn('number_of_sale', function($card){
                return count($card->uses);
            })
            ->addColumn('selling_price', function($card){
                return getNumberTranslate($card->selling_price);
            })
            ->addColumn('number_of_sale', function($card){
                return getNumberTranslate($card->number_of_sale ?? 0);
            })
            ->addColumn('status', function($card){
                return view('giftcard::giftcard.components._status_td',compact('card'));
            })
            ->addColumn('thumbnail_image', function($card){
                return view('giftcard::giftcard.components._thumbnail_image_td',compact('card'));
            })
            ->addColumn('action', function($card){
                return view('giftcard::giftcard.components._action_td',compact('card'));
            })
            ->rawColumns(['status','thumbnail_image','action'])
            ->toJson();
    }
    //------------------------------------------------------//
    //               GET Digital GIFT CARD DATA METHOD      //
    //------------------------------------------------------//
    public function digitalGiftCard(){
        $giftCards = GiftCard::with('addGiftCard','addGiftCard.giftCoupons')->where('type','gift_card')->get();

        return DataTables::of($giftCards)
        ->addIndexColumn()
        ->addColumn('gift_name', function($giftCards){
            return $giftCards->name ?? '';
        })
        ->addColumn('thumbnail_image_one', function($giftCards){
            return view('giftcard::giftcard.components._digital_giftcard_thumbnail_image_td',compact('giftCards'));
        })
        ->addColumn('gift_card_value', function($giftCards){
            return $giftCards->addGiftCard->pluck('gift_card_value')->implode(', ') ?? '';

        })
        ->addColumn('gift_selling_price', function($giftCards){
            return $giftCards->addGiftCard->pluck('gift_selling_price')->implode(', ') ?? '';
        })
        ->addColumn('number_of_gift_card', function($giftCards){
            return $giftCards->addGiftCard->pluck('number_of_gift_card')->implode(', ') ?? '';
        })
        ->addColumn('gift_selling_coupon', function($giftCards){
             return view('giftcard::giftcard.components._gift_selling_coupon_td',compact('giftCards'));
        })
        ->addColumn('action_td', function($giftCards){

            return view('giftcard::giftcard.components._action_digital_td',compact('giftCards'));
        })
        ->addColumn('status', function($giftCards){
            $card = $giftCards;
            return view('giftcard::giftcard.components._status_td',compact('card'));
        })
        ->rawColumns(['gift_card_value','thumbnail_image_one','action_td', 'status'])
        ->toJson();
    }

    public function create()
    {
        $shippings = $this->giftcardService->getShipping();
        return view('giftcard::giftcard.create', compact('shippings'));
    }

    public function store(CreateGiftCardRequest $request)
    {
        $request->validated();
        $request_data =  $request->all();

        DB::beginTransaction();
        try{
            unset($request_data['product_type']);
            unset($request_data['_token']);
            if($request->product_type == 'gift_card'){
                $request_data['product_type'] = 2;
            }else{
                $request_data['product_type'] = 1;
            }
            Schema::disableForeignKeyConstraints();
            $this->giftcardService->store($request_data);
            Schema::enableForeignKeyConstraints();
            DB::commit();
            LogActivity::successLog('GiftCard Created');
            Toastr::success(__('common.created_successfully'), __('common.success'));
            return redirect()->route('admin.giftcard.index');
        }catch(\Exception $e){

            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            dd($e);
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function statusChange(Request $request){
        try{
            $this->giftcardService->statusChange($request->except('_token'));
            LogActivity::successLog('gift card status changed');
            return response()->json([
                'success' => 'Status Updated Successfully'
            ],200);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());

            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }
    public function show($id)
    {
        $card = $this->giftcardService->getById($id);
        return view('giftcard::giftcard.view',compact('card'));
    }
    public function digitalGiftShow($id)
    {
        $giftCards = $this->giftcardService->getGiftCardById($id);
        return view('giftcard::digitalgiftcard.view',compact('giftCards'));
    }


    public function edit($id)
    {
        $card = $this->giftcardService->getById($id);
        $shippings = $this->giftcardService->getShipping();
        return view('giftcard::giftcard.edit',compact('card', 'shippings'));
    }
    public function digitalGiftEdit($id)
    {
        $giftCards = $this->giftcardService->getGiftCardById($id);
        return view('giftcard::digitalgiftcard.edit',compact('giftCards'));
    }

    public function update(UpdateGiftCardRequest $request, $id)
    {

        DB::beginTransaction();
        try{
            $this->giftcardService->update($request->except('_token'),$id);
            DB::commit();
            LogActivity::successLog('gift card updated');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return redirect()->route('admin.giftcard.index');
        }catch(\Exception $e){
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function digitalGiftUpdate(Request $request, $id)
    {
        //dd($request->all());
        DB::beginTransaction();
        try{
            $this->giftcardService->digitalCardUpdate($request->except('_token'),$id);
            DB::commit();
            LogActivity::successLog('gift card updated');
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return redirect()->route('admin.giftcard.index');
        }catch(\Exception $e){
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function destroy(Request $request)
    {
        try{
            $result = $this->giftcardService->deleteById($request->id);
            if ($result == "not_possible") {
                return response()->json([
                    'msg' => __('common.related_data_exist_in_multiple_directory')
                ]);
            }
            else {
                LogActivity::successLog('gift card deleted');
                return view('giftcard::giftcard.components._list');
            }
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function digitalDelete(Request $request)
    {
        try{
            $result = $this->giftcardService->giftDeleteById($request->id);
            if ($result == "not_possible") {
                return response()->json([
                    'msg' => __('common.related_data_exist_in_multiple_directory')
                ]);
            }
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

}
