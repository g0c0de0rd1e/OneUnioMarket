<?php

namespace Modules\Setup\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\GiftCard\Entities\GiftCard;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\CategoryProduct;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Seller\Entities\SellerProduct;
use Modules\Setup\Entities\AlgoliaSearchConfiguration;
use Modules\Setup\Entities\CheckoutFieldVisibility;
use Modules\Setup\Entities\OneClickorderReceiveStatus;
use Modules\Setup\Entities\PartialPaymentConfiguration;
use Modules\Setup\Entities\Tag;
use Modules\Setup\Services\SetupService;
use Modules\UserActivityLog\Traits\LogActivity;

class SetupController extends Controller
{
    protected $setupService;

    public function __construct(SetupService $setupService)
    {
        $this->middleware('maintenance_mode');
        $this->setupService = $setupService;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        return view('appearance::dashboard.index');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function update_status(Request $request)
    {
        try {
            app('dashboard_setup')->where('type', $request->type)->first()->update([
                'is_active' => $request->is_active
            ]);
            LogActivity::successLog('setup update status successful.');
            return 1;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function checkoutPageSetup()
    {
        $checkoutField = CheckoutFieldVisibility::all();
        return view('setup::checkoutsetting.checkout_field_settings', compact('checkoutField'));
    }

    public function updateCheckoutPageSetupData(Request $request)
    {
        try {
            $address = CheckoutFieldVisibility::findOrFail(1);
            $address->visibility = $request->address_visibility;
            $address->required = $request->address_required;
            $address->save();

            $city = CheckoutFieldVisibility::findOrFail(2);
            $city->visibility = $request->city_visibility;
            $city->required = $request->city_required;
            $city->save();

            $state = CheckoutFieldVisibility::findOrFail(3);
            $state->visibility = $request->state_visibility;
            $state->required = $request->state_required;
            $state->save();

            $country = CheckoutFieldVisibility::findOrFail(4);
            $country->visibility = $request->country_visibility;
            $country->required = $request->country_required;
            $country->save();

            $postal = CheckoutFieldVisibility::findOrFail(5);
            $postal->visibility = $request->postal_visibility;
            $postal->required = $request->postal_required;
            $postal->save();
            LogActivity::successLog('checkout field update successful.');
            Toastr::success('Checkout field update successful.');
            return redirect(route('setup.checkout.page.setup'));
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function oneClickOrderReceive()
    {
        $oneClickOrder = OneClickorderReceiveStatus::first();
        return view('setup::checkoutsetting.one_click_order_receive', compact('oneClickOrder'));
    }

    public function updateOneClickOrderStatus(Request $request)
    {
        try {
            $oneClickOrderReceive = OneClickorderReceiveStatus::first();
            if( $oneClickOrderReceive){
                $oneClickOrderReceive->status = (isset($request->status) && $request->status==1) ? 1 : 0;
                $oneClickOrderReceive->save();
            }else{
                OneClickorderReceiveStatus::create([
                    "status" => (isset($request->status) && $request->status==1) ? 1 : 0
                ]);
            }

            LogActivity::successLog('one click order complete update successful.');
            Toastr::success('One click order complete update successful.');
            return redirect(route('setup.one.click.order.receive'));
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something want wrong.','Error');
            return redirect(route('setup.one.click.order.receive'));
        }
    }

    public function algoliaSearchConfig()
    {
        $algoliaSearch = AlgoliaSearchConfiguration::first();
        return view('setup::algolia_search.algolia_search_config', compact('algoliaSearch'));
    }

    public function updateAlgoliaSearchConfig(Request $request)
    {
        $status = $request->status;
        $this->setupService->updateAlgoliaSearchConfig($status);

        return response()->json([
            'success' => true,
        ]);
    }

    public function importDataToAlgolia()
    {
        $searchables = [User::class,Category::class,CategoryProduct::class,Product::class,ProductSku::class,SellerProduct::class,Tag::class];
        if(isModuleActive('GiftCard')){
            $searchables[] = GiftCard::class;
        }

        try {
            foreach($searchables as $searchable){
                $class = new $searchable;
                $class->get()->searchable();
            }
            // Artisan::call('scout:import');
            LogActivity::successLog('Data import to Algolia successful.');
            Toastr::success('Data import to Algolia successful');
            return redirect(route('setup.algolia.search.config'));
        } catch (\Exception $e) {
            dd($e);
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    //partial payment settings
    public function partialPaymentConfig()
    {
        $partialPayment = PartialPaymentConfiguration::first();
        return view('setup::partial_payment.partial_payment_config', compact('partialPayment'));
    }

    public function updatePartialPaymentConfig(Request $request)
    {
        $status = $request->status;
        $this->setupService->updatePartialPaymentConfig($status);

        return response()->json([
            'success' => true,
        ]);
    }
}
