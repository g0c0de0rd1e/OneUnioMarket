<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Marketing\Services\NewUserZoneService;

class NewUserZoneController extends Controller
{
    private $newUserZoneService;
    public function __construct(NewUserZoneService $newUserZoneService)
    {
        $this->newUserZoneService = $newUserZoneService;
    }

    public function getAll()
    {
        try {
            $data = $this->newUserZoneService->getActiveNewUserZone();
            return response()->json([
                'new_user_zone' => $data['new_user_zone'],
                'allCategoryProducts' => $data['allCategoryProducts'],
                'allCouponCategoryProducts' => $data['allCouponCategoryProducts'],
                'message' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Not found'
            ], 400);
        }
    }
}
