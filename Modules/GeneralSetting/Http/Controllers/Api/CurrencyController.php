<?php

namespace Modules\GeneralSetting\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GeneralSetting\Repositories\CurrencyRepository;

/**
* @group General Setting
*
* APIs for General Setting
*/
class CurrencyController extends Controller
{
    protected $currencyRepo;

    public function __construct(CurrencyRepository $currencyRepo)
    {
        $this->currencyRepo = $currencyRepo;
    }

    /**
     * Currency List
     * @response{
     *      "currencies": [
     *           {
     *               "id": 2,
     *               "name": "Dollars",
     *               "code": "USD",
     *               "status": 1,
     *               "convert_rate": 1,
     *               "symbol": "$",
     *               "created_at": "2021-08-08T04:03:54.000000Z",
     *               "updated_at": "2021-09-16T11:12:27.000000Z"
     *           },
     *           {
     *               "id": 112,
     *               "name": "Taka",
     *               "code": "BDT",
     *               "status": 1,
     *               "convert_rate": 80,
     *               "symbol": "৳",
     *               "created_at": "2021-08-08T04:03:54.000000Z",
     *               "updated_at": "2021-08-24T05:24:56.000000Z"
     *           }
     *       ],
     *       "msg": "success"
     * }
     */

    public function index(){
        $currencies = $this->currencyRepo->getActiveAll();

        return response()->json([
            'currencies' => $currencies,
            'msg' => 'success'
        ]);
    }

}
