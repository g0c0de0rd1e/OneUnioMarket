<?php

namespace SpondonIt\Service\Repositories;
ini_set('max_execution_time', -1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class LicenseRepository
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function revoke()
    {

        $ac = Storage::exists('.access_code') ? Storage::get('.access_code') : null;
        $e = Storage::exists('.account_email') ? Storage::get('.account_email') : null;
        $c = Storage::exists('.app_installed') ? Storage::get('.app_installed') : null;
        $v = Storage::exists('.version') ? Storage::get('.version') : null;

        $url = verifyUrl(config('spondonit.verifier', 'auth')) . '/api/cc?a=remove&u=' . app_url() . '&ac=' . $ac . '&i=' . config('app.item') . '&e=' . $e . '&c=' . $c . '&v=' . $v;

        $response = curlIt($url);
        Log::info($response);
        Auth::logout();

        Artisan::call('db:wipe', ['--force' => true]);

        envu([
            'DB_PORT' => '3306',
            'DB_HOST' => 'localhost',
            'DB_DATABASE' => "",
            'DB_USERNAME' => "",
            'DB_PASSWORD' => "",
        ]);

        Storage::delete(['.access_code', '.account_email']);
        Storage::put('.app_installed', '');

        if($goto = gv($response, 'goto')){
            return redirect($goto)->send();
        }
    }


    public function revokeModule($params)
    {

        $name = gv($params, 'name');
        $e = Storage::exists('.account_email') ? Storage::get('.account_email') : null;
        $module_class_name = config('spondonit.module_manager_model');
        $moduel_class = new $module_class_name;
        $s = $moduel_class->where('name', $name)->first();

        if ($s) {
            $row = gbv($params, 'row');
            $file = gbv($params, 'file');

            $dataPath = base_path('Modules/' . $name . '/' . $name . '.json');

            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $item_id = $array[$name]['item_id'];
            $version = $array[$name]['versions'][0];

            if (!$s->purchase_code) {
                Log::info('Module purchase code not found');
            }

            $url = verifyUrl(config('spondonit.verifier', 'auth')) . '/api/cc?a=remove&u=' . app_url() . '&ac=' . $s->purchase_code . '&i=' . $item_id . '&t=Module' . '&v=' . $version . '&e=' . $e;

            $response = curlIt($url);
            Log::info($response);
            $s->delete();
            $this->disableModule($name, $row, $file);
        }

    }

    protected function disableModule($module_name, $row = false, $file = false)
    {

        $settings_model_name = config('spondonit.settings_model');
        $settings_model = new $settings_model_name;
        if ($row) {
            $config = $settings_model->firstOrNew(['key' => $module_name]);
            $config->value = 0;
            $config->save();
        } else if ($file) {
            app('general_settings')->put([
                $module_name => 0
            ]);
        } else {
            $config = $settings_model->find(1);
            $config->$module_name = 0;
            $config->save();
        }
        $module_model_name = config('spondonit.module_model');
        $module_model = new $module_model_name;
        $ModuleManage = $module_model::find($module_name)->disable();
    }

    public function revokeTheme($params)
    {

        $name = gv($params, 'name');
        $e = Storage::exists('.account_email') ? Storage::get('.account_email') : null;

        $query = DB::table(config('spondonit.theme_table', 'themes'))->where('name', $name);
        $s = $query->first();

        if ($s) {
            if (!$s->purchase_code) {
                Log::info('Theme purchase code not found');
            }


            $url = verifyUrl(config('spondonit.verifier', 'auth')) . '/api/cc?a=remove&u=' . app_url() . '&ac=' . $s->purchase_code . '&i=' . $s->item_code . '&t=Theme' . '&v=' . $s->version . '&e=' . $s->email;

            $response = curlIt($url);
            Log::info($response);


            $query->update([
                'email' => null,
                'installed_domain' => null,
                'activated_date' => null,
                'purchase_code' => null,
                'checksum' => null,
                'is_active' => 0,
            ]);

            //change to default theme
            if ($s->is_active == 1) {
                $default = DB::table(config('spondonit.theme_table', 'themes'))->where('id', 1)->update(
                    [
                        'is_active' => 1
                    ]
                );

                $check = DB::table(config('spondonit.theme_table', 'themes'))->where('is_active', 1)->first();
                if (function_exists('UpdateGeneralSetting')) {
                    UpdateGeneralSetting('frontend_active_theme', $check->name);
                }
                Cache::forget('frontend_active_theme');
                Cache::forget('getAllTheme');
                Cache::forget('color_theme');
                if (function_exists('GenerateGeneralSetting')) {
                    if (function_exists('SaasDomain')) {
                        GenerateGeneralSetting(SaasDomain());
                    } else {
                        GenerateGeneralSetting();
                    }
                }

            }
        }

    }

}
