<?php

namespace SpondonIt\Service\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use SpondonIt\Service\Repositories\InitRepository;
use SpondonIt\Service\Repositories\InstallRepository;

class CheckController extends Controller
{

    private $initRepo, $request;

    public function __construct(InitRepository $initRepo, Request $request)
    {
        $this->initRepo = $initRepo;
        $this->request = $request;
    }

    public function verify()
    {
        $requests = $this->request->all();

        $response = gv($requests, 'response', []);
        $params = gv($requests, 'params', []);
        try {
            if (gbv($response, 'status')) {
                return $this->successAction($requests, $response, $params);
            }

            if (gv($params, 'a') == 'verify') {
                Log::info('Initial License Verification failed. Message: ' . gv($response, 'message'));
                Storage::delete(['.access_code', '.account_email']);
                Storage::deleteDirectory(config('app.item'));
                Storage::put('.app_installed', '');
                Storage::put('.logout', 'true');
                Auth::logout();
                $goto = route('service.install');
                if (gv($requests, 'from') == 'browser') {
                    return redirect($goto)->send();
                }
                return [
                    'status' => false,
                    'goto' => $goto
                ];
            }

            return $response;

        } catch (\Exception $e) {

            $message = $e->getMessage();

            \Log::error($e);
            $goto = gv($params, 'current', url('login'));
            if (gv($params, 'a') == 'verify') {
                Storage::put('.access_log', date('Y-m-d'));
            }

            if(!$goto){
                $goto = route('service.install');
            }


            if (gv($requests, 'from') == 'browser') {
                Toastr::error($message);
                return redirect($goto)->send();
            }

            return [
                'status' => false,
                'goto' => $goto,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function successAction($requests, $response, $params)
    {


        if (gv($params, 'a') == 'install') {
            if (gv($params, 't', 'Product') == 'Module') {
                return $this->installModule($requests, $params, $response);
            }
            $checksum = $response['checksum'] ?? null;
            $license_code = $response['license_code'] ?? null;

            if (gbv($params, 'ri')) {
                Storage::put('.app_installed', $checksum);
                Storage::put('.install_count', Storage::get('.install_count') + 1);
                $goto = url('/');
                $message = __('service::install.re_installation_process_complete');
            } else {
                Storage::put('.temp_app_installed', $checksum ?? '');
                $goto = route('service.database');
                $message = gv($response, 'message', __('service::install.valid_license'));
            }

            Storage::put('.access_code', $license_code ?? '');
            Storage::put('.account_email', gv($params, 'e'));
            Storage::put('.access_log', date('Y-m-d'));
            Toastr::success($message);
        } elseif (gv($params, 'a') == 'verify') {
            Storage::put('.access_log', date('Y-m-d'));
            $goto = gv($params, 'current', url('dashboard'));
        }


        if (gv($requests, 'from') == 'browser') {
            return redirect($goto);
        }

        return [
            'status' => true,
            'goto' => $goto
        ];
    }

    public function installModule($reqests, $params, $response)
    {
        $repo = App::make(InstallRepository::class);

        $result = $repo->processModuleInstallation($params, $response);
        $goto = gv($params, 'current', url('dashboard'));

        if ($result) {
            if (request()->wantsJson()) {
                return response()->json(['message' => __('service::install.module_verify'), 'goto' => $goto]);
            }
            Toastr::success(__('service::install.module_verify'), 'Success');

        }
        return redirect()->to($goto);
    }

}
