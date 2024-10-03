<?php

namespace App\Http\Controllers\Frontend;
use App\Repositories\DigitalGiftCardRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DigitalGiftCardController extends Controller
{
    protected $digitalgiftcardrepository;

    public function __construct(DigitalGiftCardRepository $digitalgiftcardrepository)
    {
        $this->digitalgiftcardrepository = $digitalgiftcardrepository;
        $this->middleware('maintenance_mode');
    }

    public function index(){
        $data['giftCards'] = $this->digitalgiftcardrepository->getAll(null, null);
        return view(theme('pages.digital_gift_card'),$data);
    }

    public function fetchData(Request $request)
    {
        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
            $data['sort_by'] = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
            $data['paginate'] = $request->paginate;
        }
        $data['giftCards'] = $this->digitalgiftcardrepository->getAll($sort_by, $paginate);
        return view(theme('partials._digital_giftcard_list'), $data);
    }

    public function filterByType(Request $request)
    {

        $paginate = null;
        $sort_by = null;
        if ($request->has('paginate')) {
            $data['paginate'] = $request->paginate;
        }
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
            $data['sort_by'] = $request->sort_by;
        }

        $data['giftCards'] =  $this->digitalgiftcardrepository->getByFilterByType($request->except('_token'), $sort_by, $paginate);

        return view(theme('partials._digital_giftcard_list'), $data);
    }

    public function digital_gift_card_details($id)
    {
        $data['giftCards'] = $this->digitalgiftcardrepository->details($id);
        return view(theme('partials._digital_gift_card_details'), $data);

    }
}
