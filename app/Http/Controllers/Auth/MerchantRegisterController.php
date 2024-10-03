<?php

namespace App\Http\Controllers\Auth;
use Exception;
use App\Traits\Otp;
use App\Models\User;
use App\Rules\RealEmail;
use App\Traits\SendMail;
use App\Traits\ImageStore;
use App\Traits\GenerateSlug;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\FrontendCMS\Entities\Pricing;
use Modules\RolePermission\Entities\Role;
use \Modules\FrontendCMS\Services\FaqService;
use Illuminate\Foundation\Auth\RegistersUsers;
use \Modules\FrontendCMS\Services\QueryService;
use Modules\MultiVendor\Entities\SellerAccount;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\SidebarManager\Entities\Backendmenu;
use \Modules\FrontendCMS\Services\BenefitService;
use \Modules\FrontendCMS\Services\PricingService;
use Modules\FrontendCMS\Entities\MerchantContent;
use Modules\MultiVendor\Rules\SellerValidateRule;
use App\Traits\Notification as TraitsNotification;
use Modules\MultiVendor\Entities\SellerBankAccount;
use Modules\MultiVendor\Entities\SellerSubcription;
use Modules\SidebarManager\Entities\BackendmenuUser;
use Modules\MultiVendor\Entities\SellerReturnAddress;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\MultiVendor\Events\SellerShippingRateEvent;
use \Modules\FrontendCMS\Services\WorkingProcessService;
use Modules\GeneralSetting\Entities\NotificationSetting;
use Modules\MultiVendor\Entities\SellerWarehouseAddress;
use Modules\MultiVendor\Events\SellerCarrierCreateEvent;
use \Modules\FrontendCMS\Services\MerchantContentService;
use \Modules\MultiVendor\Repositories\MerchantRepository;
use Modules\MultiVendor\Events\SellerShippingConfigEvent;
use Modules\MultiVendor\Repositories\CommisionRepository;
use Modules\MultiVendor\Entities\SellerBusinessInformation;
use Modules\MultiVendor\Events\SellerPickupLocationCreated;
use Modules\GeneralSetting\Entities\UserNotificationSetting;
use Modules\FormBuilder\Repositories\FormBuilderRepositories;

class MerchantRegisterController extends Controller
{
    use RegistersUsers, TraitsNotification, SendMail, Otp, GenerateSlug;
    protected $merchantContentService;
    protected $benefitService;
    protected $faqService;
    protected $workingProcessService;
    protected $pricingService;
    protected $queryService;

    public function __construct(
        MerchantContentService $merchantContentService,
        BenefitService $benefitService,
        WorkingProcessService $workingProcessService,
        FaqService $faqService,
        PricingService $pricingService,
        QueryService $queryService
    ) {
        $this->middleware('maintenance_mode');

        $this->merchantContentService = $merchantContentService;
        $this->benefitService = $benefitService;
        $this->faqService = $faqService;
        $this->workingProcessService = $workingProcessService;
        $this->pricingService = $pricingService;
        $this->queryService = $queryService;

    }


    protected function redirectTo()
    {
        if (app('business_settings')->where('type', 'email_verification')->first()->status == 1 && !isModuleActive('Otp') && !otp_configuration('otp_activation_for_seller')) {
            return redirect('/user-email-verify');
        }
        if(session()->has('pricing_id')){
            return  redirect('/seller/seller-subscription-payment-select/'.encrypt(session()->get('seller_pricing')));
        }
        return redirect('/seller/dashboard');
    }


    public function showRegisterFormStepFirst()
    {
        if (app('business_settings')->where('category_type', 'vendor_configuration')->where('type', 'Multi-Vendor System Activate')->first()->status) {
            if (auth()->check() && auth()->user()->role->type == 'customer') {
                $commisionRepo = new CommisionRepository();
                $data['commissions'] = $commisionRepo->getAllActive();
                $data['content'] = MerchantContent::firstOrFail();
                $data['benefitList'] = $this->benefitService->getAllActive();
                $data['faqList'] = $this->faqService->getAllActive();
                $data['content'] = $this->merchantContentService->getAll();
                $data['pricingList'] = $this->pricingService->getAllActive();
                $data['workProcessList'] = $this->workingProcessService->getAllActive();
                $data['QueryList'] = $this->queryService->getAllActive();
                return view(theme('pages.marchant'), $data);
            } elseif (!auth()->check()) {
                $commisionRepo = new CommisionRepository();
                $data['commissions'] = $commisionRepo->getAllActive();
                $data['content'] = MerchantContent::firstOrFail();
                $data['benefitList'] = $this->benefitService->getAllActive();
                $data['faqList'] = $this->faqService->getAllActive();
                $data['content'] = $this->merchantContentService->getAll();
                $data['pricingList'] = $this->pricingService->getAllActive();
                $data['workProcessList'] = $this->workingProcessService->getAllActive();
                $data['QueryList'] = $this->queryService->getAllActive();
                return view(theme('pages.marchant'), $data);
            } else {
                return abort(404);
            }
        } else {
            Toastr::error(__('auth.multi_vendor_system_is_temporary_disabled'));
            return back();
        }
    }

    public function showRegisterForm(Request $request, $id)
    {

        if(config('app')['sync'] && auth()->check()){
            if ($request->ajax()) {
                return response()->json(['error' => __('common.restricted_in_demo_mode')], 422);
            }
            Toastr::error(__('common.restricted_in_demo_mode'));
            return back();
        }
        if (app('business_settings')->where('category_type', 'vendor_configuration')->where('type', 'Multi-Vendor System Activate')->first()->status) {
            if (auth()->check() && auth()->user()->role->type == 'customer') {
                $commisionRepo = new CommisionRepository();
                $commission = $commisionRepo->findBySlug($id);
                if (session()->has('commission_id')) {
                    session()->forget('commission_id');
                    session()->forget('commission_rate');
                }
                session()->put('commission_id', $commission->id);
                session()->put('commission_rate', $commission->rate);
                if ($commission->id == 3) {
                    $data['pricing_plans'] = Pricing::where('status', 1)->get();
                    $data['content'] = MerchantContent::firstOrFail();
                    return view(theme('pages.merchant_create_by_subscription'), $data);
                } else {
                    session()->forget('pricing_id');
                }
                $registerRepo = new MerchantRepository();
                $registerRepo->customerToSellerConvert([
                    'commission_id' => session()->get('commission_id'),
                    'commission_rate' => session()->get('commission_rate'),
                ]);
                return redirect()->route('seller.dashboard');
            } elseif (!auth()->check()) {
                $commisionRepo = new CommisionRepository();
                $commission = $commisionRepo->findBySlug($id);
                if (session()->has('commission_id')) {
                    session()->forget('commission_id');
                    session()->forget('commission_rate');
                }
                session()->put('commission_id', $commission->id);
                session()->put('commission_rate', $commission->rate);

                $data['row'] = '';
                $data['form_data'] = '';
                if(Module::has('FormBuilder')){
                    if(Schema::hasTable('custom_forms')){
                        $formBuilderRepo = new FormBuilderRepositories();
                        $data['row'] = $formBuilderRepo->find(3);
                        if($data['row']->form_data){
                            $data['form_data'] = json_decode($data['row']->form_data);
                        }
                    }
                }
                if ($commission->id == 3) {
                    $data['pricing_plans'] = Pricing::where('status', 1)->get();
                    $data['content'] = MerchantContent::firstOrFail();
                    return view(theme('pages.merchant_create_by_subscription'), $data);
                } else {
                    session()->forget('pricing_id');
                }
                return view(theme('pages.merchant_create_step_two'), $data);
            } else {
                return abort(404);
            }
        } else {
            Toastr::error(__('auth.multi_vendor_system_is_temporary_disabled'));
            return back();
        }
    }

    public function showRegisterForm2(Request $request)
    {

        if (app('business_settings')->where('category_type', 'vendor_configuration')->where('type', 'Multi-Vendor System Activate')->first()->status) {
            if (auth()->check() && auth()->user()->role->type == 'customer') {
                if (session()->has('pricing_id')) {
                    session()->forget('pricing_id');
                    session()->forget('pricing_type');
                }
                session()->put('pricing_id', $request->id);
                session()->put('pricing_type', $request->type);
                $data['pricing_plans'] = Pricing::where('status', 1)->get(['name', 'id']);
                $registerRepo = new MerchantRepository();
                $registerRepo->customerToSellerConvert([
                    'commission_id' => session()->get('commission_id'),
                    'commission_rate' => session()->get('commission_rate'),
                    'pricing_id' => session()->get('pricing_id'),
                    'pricing_type' => session()->get('pricing_type'),
                ]);
                return redirect()->route('seller.dashboard');
            } elseif (!auth()->check()) {
                if (session()->has('pricing_id')) {
                    session()->forget('pricing_id');
                    session()->forget('pricing_type');
                }
                session()->put('pricing_id', $request->id);
                session()->put('pricing_type', $request->type);

                $data['row'] = '';
                $data['form_data'] = '';
                if(Module::has('FormBuilder')){
                    if(Schema::hasTable('custom_forms')){
                        $formBuilderRepo = new FormBuilderRepositories();
                        $data['row'] = $formBuilderRepo->find(3);
                        if($data['row']->form_data){
                            $data['form_data'] = json_decode($data['row']->form_data);
                        }
                    }
                }
                $data['pricing_plans'] = Pricing::where('status', 1)->get(['name', 'id']);
                return view(theme('pages.merchant_create_step_two'), $data);
            } else {
                return abort(404);
            }
        } else {
            Toastr::error(__('auth.multi_vendor_system_is_temporary_disabled'));
            return back();
        }
    }

    protected function validator(array $data)
    {
        if (env('NOCAPTCHA_FOR_REG') == "true" && app('theme')->folder_path == 'amazy') {
            $g_recaptcha = 'required';
        }else{
            $g_recaptcha = 'nullable';
        }


        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $email = ['required', 'string', 'max:255','email',new RealEmail(),'unique:users,email'];
         }elseif (preg_match("/^\\+?\\d{1,4}?[-.\\s]?\\(?\\d{1,3}?\\)?[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,9}$/",$data['email'])) {
             $email = ['required', 'string','min:7', 'max:16','unique:users,phone'];
         }else {
             $email = ['required', 'string', 'max:255','email',new RealEmail()];
         }

        return Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:255','unique:seller_accounts,seller_shop_display_name',new SellerValidateRule($data['name'])],
                'email' => $email,
                'phone' => ['required', 'string', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'g-recaptcha-response' =>$g_recaptcha,

            ],
            [
                'name.required' => 'This Name Filed is required',
                'email.required' => 'This Email is required',
                'email.email' => 'This is not a valid email',
                'email.unique' => 'Email has already taken',
                'password.required' => 'This Password Filed is required',
                'password.min' => 'The password field minimum 8 character.',
                'g-recaptcha-response.required' => 'The google recaptcha field is required.',
            ]
        );
    }

    public function register(Request $request)
    {

        if (app('business_settings')->where('category_type', 'vendor_configuration')->where('type', 'Multi-Vendor System Activate')->first()->status == 0) {
            Toastr::error(__('auth.multi_vendor_system_is_temporary_disabled'));
            return back();
        }

        $this->validator($request->all())->validate();

        if (isModuleActive('Otp') && otp_configuration('otp_activation_for_seller')) {
            try {
                if (!$this->sendOtpForSeller($request)) {
                    Toastr::error(__('otp.something_wrong_on_otp_send'), __('common.error'));
                    return back();
                }
                return view(theme('auth.otp_seller'), compact('request'));
            } catch (Exception $e) {
                LogActivity::errorLog($e->getMessage());
                Toastr::error(__('otp.something_wrong_on_otp_send'), __('common.error'));
                return back();
            }
        }

        event(new Registered($user = $this->create($request)));

        if (auto_approve_seller()) {
            $this->guard()->login($user);
        } else {
            Toastr::success(__('common.successfully_registered') . ' ' . __('auth.wait_for_approval'), __('common.success'));
            return back();
        }

        Toastr::success(__('common.successfully_registered') . ' ' . __('auth.please_verify_your_email'), __('common.success'));

        if ($response = $this->registered($request, $user)) {

            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 201)
            : $this->redirectTo();
    }



    protected function othersFieldValue($data)
    {
        return json_encode($data);
    }

    protected function create($data)
    {
        $c_data = [];
        if($data->has('custom_field')){
            foreach (json_decode($data['custom_field']) as  $key => $f){
                if($data->hasFile($f)){
                    $file = ImageStore::saveImage($data[$f], 165, 165);
                    $c_data[$f] = $file;
                }else{
                    $c_data[$f] = $data[$f];
                }
            }
        }
        $role = Role::where('type', 'seller')->first();
        $user =  User::create([
            'first_name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $role->id,
            'username' => $data['phone'],
            'phone' => $data['phone'],
            'verify_code' => sha1(time()),
            'password' => Hash::make($data['password']),
            'others' => $this->othersFieldValue($c_data),
            'currency_id' => app('general_setting')->currency,
            'lang_code' => app('general_setting')->language_code,
            'currency_code' => app('general_setting')->currency_code,
        ]);
        // Auto approve check
        if (auto_approve_seller()) {
            $user->is_active = 1;
        } else {
            $user->is_active = 0;
        }
        $user->slug = $this->productSlug($data['name']);
        $user->save();
        // User Notification Setting Create
        (new UserNotificationSetting())->createForRegisterUser($user->id);
        $this->adminNotificationUrl = '/admin/merchants';
        $this->routeCheck = 'admin.merchants_list';
        $this->typeId = EmailTemplateType::where('type', 'seller_create_email_template')->first()->id; //register email templete typeid
        $notification = NotificationSetting::where('slug','seller-created')->first();
        if ($notification) {
            $this->notificationSend($notification->id, $user->id);
        }

        $seller_account = SellerAccount::create([
            'user_id' => $user['id'],
            'seller_id' => 'BDEXCJ' . rand(99999, 10000000),
            'seller_commission_id' => (session()->has('commission_id')) ? session()->get('commission_id') : 1,
            'commission_rate' => (session()->has('commission_rate')) ? session()->get('commission_rate') : 0,
            'subscription_type' => 'yearly',
            'seller_shop_display_name' => $data['name'],
            'seller_phone' => $data['phone']
        ]);

        SellerBusinessInformation::create([
            'user_id' => $user['id']
        ]);
        SellerBankAccount::create([
            'user_id' => $user['id'],
            'business_country' => app('general_setting')->default_country,
            'business_state' => app('general_setting')->default_state
        ]);
        if (session()->has('pricing_id')) {
          $pricing =  SellerSubcription::create([
                'seller_id' => $user['id'],
                'pricing_id' => session()->get('pricing_id')
            ]);
            if (session()->get('pricing_type') == null) {
                $seller_account->update([
                    'subscription_type' => 'yearly'
                ]);
            }

            session()->put('seller_pricing',$pricing->id);
        }
        SellerWarehouseAddress::create([
            'user_id' => $user['id'],
            'warehouse_country' => app('general_setting')->default_country,
            'warehouse_state' => app('general_setting')->default_state
        ]);
        SellerReturnAddress::create([
            'user_id' => $user['id'],
            'return_country' => app('general_setting')->default_country,
            'return_state' => app('general_setting')->default_state
        ]);
        if(!isModuleActive('Otp') && !otp_configuration('otp_activation_for_seller')){
            if (app('business_settings')->where('type', 'email_verification')->first()->status == 1) {
                $code = '<a class="btn btn-success" href="' . url('/verify?code=') . $user['verify_code'] . '">Click Here To Verify Your Account</a>';
                $this->sendSellerVerificationMail($user, $code);
            }
        }
        Event::dispatch(new SellerCarrierCreateEvent($user['id']));
        Event::dispatch(new SellerPickupLocationCreated($user['id']));
        Event::dispatch(new SellerShippingRateEvent($user['id']));
        Event::dispatch(new SellerShippingConfigEvent($user['id']));
        $this->setupSidebar($user);
        return $user;
    }

    public function setupSidebar($user)
    {
        $role_id = $user->role->type;
        if ($role_id == 'seller') {
            $backend_menus = Backendmenu::where(function($q){
                $q->where('user_id', auth()->id())->orWhereNull('user_id');
            })->where('is_seller', 1)->get();
        }else{
            $backend_menus = Backendmenu::where(function($q){
                $q->where('user_id', auth()->id())->orWhereNull('user_id');
            })->where('is_admin', 1)->get();

        }
        $backendMenuUser = BackendmenuUser::with('backendMenu')->where('user_id', $user->id)->get();
            if($backendMenuUser->count() != $backend_menus->count()){

                $backend_menu_not_exsist = $backend_menus->whereNotIn('id', $backendMenuUser->pluck('backendmenu_id')->toArray());
                foreach($backend_menu_not_exsist as $menu){

                    $parent_id = null;
                    $position = 0;
                    if($menu->parent_id){
                        $parentMenu = BackendmenuUser::where('backendmenu_id', $menu->parent_id)->where('user_id', $user->id)->first();
                        if($parentMenu){
                            $parent_id  = $parentMenu->id;
                            $position = BackendmenuUser::where('parent_id', $parent_id)->where('user_id', $user->id)->count() + 1;
                        }
                    }

                    BackendmenuUser::create(['parent_id' => $parent_id, 'user_id' => $user->id, 'backendmenu_id' => $menu->id, 'position' => $position]);
                }
            }
    }

    public function otp_check_for_seller(Request $request)
    {
        try {
            $otp = Session::get('otp');
            $validation_time = Session::get('validation_time');
            if ($otp != $request->otp) {
                Toastr::error(__('otp.invalid_otp'));
                Session::put('code_validation_time', $request->code_validation_time);
                return view(theme('auth.otp_seller'), compact('request'));
            } elseif (date('Y-m-d H:i:s') > $validation_time) {
                Session::put('code_validation_time', 1);
                Toastr::error(__('otp.otp_validation_time_expired'));
                return view(theme('auth.otp_seller'), compact('request'));
            } else {
                Session::forget('otp');
                Session::forget('validation_time');
                Session::forget('code_validation_time');
                event(new Registered($user = $this->create($request)));
                $user->update(['is_verified' => 1]);
                if (auto_approve_seller()) {
                    Toastr::success(__('common.successfully_registered'), __('common.success'));
                    $this->guard()->login($user);
                } else {
                    Toastr::success(__('common.successfully_registered') . ' ' . __('auth.wait_for_approval'), __('common.success'));
                    return redirect()->route('register');
                }
                if ($response = $this->registered($request, $user)) {
                    return $response;
                }
                return $request->wantsJson()? new Response('', 201) : $this->redirectTo();
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->route('register');
        }
    }

}
