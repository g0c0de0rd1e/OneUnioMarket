<?php

namespace Modules\FormBuilder\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Exception;
use Modules\FormBuilder\Entities\CustomForm;
use Modules\FormBuilder\Repositories\FormBuilderRepositories;
use Modules\FrontendCMS\Entities\InQuery;
use Modules\FrontendCMS\Entities\Pricing;
use Modules\FrontendCMS\Repositories\QueryRepository;

class FormBuilderController extends Controller
{
    protected $formBuilderRepo;
    public function __construct(FormBuilderRepositories $formBuilderRepo)
    {
        $this->formBuilderRepo = $formBuilderRepo;
    }
    public function index()
    {
        try{
            $data['forms'] = $this->formBuilderRepo->all();
            return view('formbuilder::form.index',$data);
        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }
    }
    public function show($id)
    {
        try{
            $data['pricing_plans'] = Pricing::where('status', 1)->get(['name', 'id']);
            $queryRepo = new QueryRepository(new InQuery ());
            $data['QueryList'] = $queryRepo->getAllActive();
            $data['item'] = $this->formBuilderRepo->find($id);
            if($data['item']->form_data){
                $data['form_data'] = json_decode($data['item']->form_data);
            }
            return view('formbuilder::form.show',$data);
        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }
    }
    public function builder($id)
    {
        try{
            $data['row'] = $this->formBuilderRepo->find($id);
            // for contact form
            $queryRepo = new QueryRepository(new InQuery ());
            $queryList = $queryRepo->getAllActive();
            $queryTypeOptions = [];
            foreach ($queryList as $q){
                $queryTypeOptions[] =  [
                    "label" => $q->name,
                    "value" => $q->id
                ];
            }
            //end contact form
            //for seller form
            $pricing_plans = [];
            $pricingPlans = Pricing::where('status', 1)->get(['name', 'id']);
            foreach ($pricingPlans as $p){
                $pricing_plans[] =  [
                    "label" => $p->name,
                    "value" => $p->id,
//                    "selected" => session()->get('pricing_id') == $p->id ? true : false,
                ];
            }
            //end seller form
            $data['formData'] = [];
            if($data['row']->form_data == null){
                //affiliate
                if($id == 1){
                    $data['default_Data'] =  [
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.first_name'),
                            "placeholder" => __('common.first_name'),
                            "name" => "first_name",
                            "required" => true,
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.last_name'),
                            "placeholder" => __('common.last_name'),
                            "name" => "last_name",
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.email_or_phone'),
                            "placeholder" => __('common.email_or_phone'),
                            "name" => "email",
                            "type" => "text",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.password'),
                            "placeholder" => __('common.password'),
                            "name" => "password",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.confirm_password'),
                            "placeholder" => __('common.confirm_password'),
                            "name" => "password_confirmation",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __("defaultTheme.by_signing_up_you_agree_to"). "<a href='#' class='term_link_set'>".__("defaultTheme.terms_of_service"). " </a>" .__("common.add")." <a href='#' class='policy_link_set'>".__("defaultTheme.privacy_policy")."</a>",
                            "name" => "accept",
                            "type" => "checkbox",
                            "inline" => true,
                            "disabledFieldButtons" => ['remove','copy'],
                        ]
                    ];
                    $data['formData'] = json_encode($data['default_Data']);
                }
                //end affiliate
                //customer
                if($id == 2){
                    $data['default_Data'] =  [
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.first_name'),
                            "placeholder" => __('common.first_name'),
                            "name" => "first_name",
                            "required" => true,
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.last_name'),
                            "placeholder" => __('common.last_name'),
                            "name" => "last_name",
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.email_or_phone'),
                            "placeholder" => __('common.email_or_phone'),
                            "name" => "email",
                            "type" => "text",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.referral_code'),
                            "placeholder" => __('common.referral_code'),
                            "name" => "referral_code",
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.password'),
                            "placeholder" => __('common.password'),
                            "name" => "password",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.confirm_password'),
                            "placeholder" => __('common.confirm_password'),
                            "name" => "password_confirmation",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __("defaultTheme.by_signing_up_you_agree_to"). "<a href='#' class='term_link_set'>".__("defaultTheme.terms_of_service"). " </a>" .__("common.add")." <a href='#' class='policy_link_set'>".__("defaultTheme.privacy_policy")."</a>",
                            "name" => "accept",
                            "type" => "checkbox",
                            "inline" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ]
                    ];
                    $data['formData'] = json_encode($data['default_Data']);
                }
                //end customer
                //seller
                if($id == 3){
                    $data['default_Data'] =  [
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.account_type'),
                            "name" => "account_type",
                            "required" => true,
                            "type" => "select",
                            "values" => [],
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.shop_name'),
                            "placeholder" => __('common.shop_name'),
                            "name" => "name",
                            "required" => true,
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.email_address'),
                            "placeholder" => __('common.email_address'),
                            "name" => "email",
                            "type" => "text",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.phone_number'),
                            "placeholder" => __('common.phone_number'),
                            "name" => "phone",
                            "type" => "text",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.password'),
                            "placeholder" => __('common.password'),
                            "name" => "password",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.confirm_password'),
                            "placeholder" => __('common.confirm_password'),
                            "name" => "password_confirmation",
                            "type" => "text",
                            "subtype" => "password",
                            "required" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => "By signing up, you agree to <a href=\"#\" class=\"term_link_set\">Terms of Service </a> and <a href=\"#\" class=\"policy_link_set\">Privacy Policy</a>",
                            "name" => "accept",
                            "type" => "checkbox",
                            "inline" => true,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ]
                    ];
                    $data['formData'] = json_encode($data['default_Data']);
                }
                //end seller
                //contact us
                if($id == 4){
                    $data['default_Data'] =  [
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.name'),
                            "placeholder" => __('defaultTheme.enter_name'),
                            "name" => "name",
                            "required" => true,
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.email_address'),
                            "placeholder" => __('common.email_address'),
                            "name" => "email",
                            "subtype" => "email",
                            "required" => true,
                            "type" => "text",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('defaultTheme.inquery_type'),
                            "name" => "query_type",
                            "required" => true,
                            "type" => "select",
                            "values" => $queryTypeOptions,
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],
                        [
                            "className" => "form-control default-field",
                            "label" => __('common.message'),
                            "placeholder" => __('defaultTheme.write_messages'),
                            "name" => "message",
                            "required" => true,
                            "type" => "textarea",
                            "disabledFieldButtons" => ['remove','edit','copy'],
                        ],

                    ];
                    $data['formData'] = json_encode($data['default_Data']);
                }
                //end contact us

                //lead
                if($id == 5){
                    $data['default_Data'] =  [];
                    $data['formData'] = json_encode($data['default_Data']);
                }
                //end lead
            }
            else{
                $form_data = json_decode($data['row']->form_data);
                $data['eData'] = [];
                  foreach ($form_data as $row){
                      if(property_exists($row,'className') && strpos($row->className, 'default-field') !== false){
                          $row->disabledFieldButtons = ['remove','edit','copy'];
                      }
                      $data['eData'][]= $row;
                  }
                $data['formData'] = json_encode($data['eData']);

            }
            return view('formbuilder::form.builder',$data);
        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }

    }
    public function builderUpdate(Request $request)
    {
        try {
            CustomForm::where('id',$request->id)->update([
                'form_data' => $request->formData
            ]);
            return response()->json(['message'=>__("formBuilder.form_create_successfully")]);
        } catch (\Throwable $th) {

            Toastr::error(__("common.operation_failed"), __("common.failed"));
            return redirect()->back();
        }
    }
}
