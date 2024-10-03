<?php

namespace Modules\MultiVendor\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Product\Entities\Category;
use Modules\Product\Repositories\CategoryRepository;

class SellerCommissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }

    public function index()
    {
        $categoryRepo = new CategoryRepository(new Category);
        $data['CategoryList'] = $categoryRepo->getAll();
        return view('multivendor::seller_commission.category_commision_info', $data);
    }
}
