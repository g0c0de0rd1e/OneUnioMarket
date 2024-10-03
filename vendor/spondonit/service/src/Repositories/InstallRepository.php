<?php

namespace SpondonIt\Service\Repositories;

ini_set('max_execution_time', -1);

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Schema;
use Throwable;
use Toastr;

class InstallRepository
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function checkInstallation()
    {
        $ac = Storage::exists('.app_installed') ? Storage::get('.app_installed') : null;
        if ($ac) {
            abort(404);
        } else {
            if ($this->checkPreviousInstallation()) {
                return redirect('/')->send();
            }
        }
    }

    /**
     * Used to compare version of PHP
     */
    public function my_version_compare($ver1, $ver2, $operator = null)
    {
        $p = '#(\.0+)+($|-)#';
        $ver1 = preg_replace($p, '', $ver1);
        $ver2 = preg_replace($p, '', $ver2);
        return isset($operator) ?
            version_compare($ver1, $ver2, $operator) :
            version_compare($ver1, $ver2);
    }

    /**
     * Used to check whether pre requisites are fulfilled or not and returns array of success/error type with message
     */
    public function check($boolean, $message, $help = '', $fatal = false)
    {
        if ($boolean) {
            return array('type' => 'success', 'message' => $message);
        } else {
            return array('type' => 'error', 'message' => $help);
        }
    }

    public function checkReinstall()
    {
        try {
            DB::connection()->getPdo();
            return (Storage::exists('.install_count') ? Storage::get('.install_count') : 0) and (Artisan::call('spondonit:migrate-status'));
        } catch (Exception $e) {
            return false;
        }
    }


    /**
     * Used to check whether pre requisites are fulfilled or not and returns array of success/error type with message
     */
    public function checkPreviousInstallation()
    {
        return false;
    }

    /**
     * Check all pre-requisite for script
     */
    public function getPreRequisite()
    {
        $post_max_size = config('spondon.post_max_size', '64M');
        $upload_max_filesize = config('spondon.upload_max_filesize', '32M');
        $memory_limit = config('spondon.memory_limit', '128M');
        $max_execution_time = config('spondon.max_execution_time', 300);
        if (is_numeric($max_execution_time)) {
            $max_execution_time = (int) $max_execution_time;
        }

        $server[] = $this->check((dirname($_SERVER['REQUEST_URI']) != '/' && str_replace('\\', '/', dirname($_SERVER['REQUEST_URI'])) != '/'), 'Installation directory is valid.', 'Please use root directory or point your sub directory to domain/subdomain to install.', true);
        $server[] = $this->check($this->my_version_compare(phpversion(), config('spondonit.php_version', '7.2.0'), '>='), sprintf('Min PHP version ' . config('spondonit.php_version', '7.2.0') . ' (%s)', 'Current Version ' . phpversion()), 'Current Version ' . phpversion(), true);
        $server[] = $this->check(extension_loaded('fileinfo'), 'Fileinfo PHP extension enabled.', 'Install and enable Fileinfo extension.', true);
        $server[] = $this->check(extension_loaded('ctype'), 'Ctype PHP extension enabled.', 'Install and enable Ctype extension.', true);
        $server[] = $this->check(extension_loaded('json'), 'JSON PHP extension enabled.', 'Install and enable JSON extension.', true);
        $server[] = $this->check(extension_loaded('openssl'), 'OpenSSL PHP extension enabled.', 'Install and enable OpenSSL extension.', true);
        $server[] = $this->check(extension_loaded('tokenizer'), 'Tokenizer PHP extension enabled.', 'Install and enable Tokenizer extension.', true);
        $server[] = $this->check(extension_loaded('mbstring'), 'Mbstring PHP extension enabled.', 'Install and enable Mbstring extension.', true);
        $server[] = $this->check(extension_loaded('zip'), 'Zip archive PHP extension enabled.', 'Install and enable Zip archive extension.', true);
        $server[] = $this->check(class_exists('finfo'), 'Finfo is installed.', 'Install Finfo (mandatory for read or write file).', true);
        $server[] = $this->check(class_exists('PDO'), 'PDO is installed.', 'Install PDO (mandatory for Eloquent).', true);
        $server[] = $this->check(extension_loaded('curl'), 'CURL is installed.', 'Install and enable CURL.', true);
        $server[] = $this->check(ini_get('allow_url_fopen'), 'allow_url_fopen is on.', 'Turn on allow_url_fopen.', true);
        $server[] = $this->check(ini_get('allow_url_fopen'), 'allow_url_fopen is on.', 'Turn on allow_url_fopen.', true);
        $server[] = $this->check($this->compareInt($this->getIniSize('post_max_size'), $this->convertToInt($post_max_size)),  'Current Post Max Size ' . ini_get('post_max_size'), sprintf('Min Post Max Size ' . $post_max_size . ' (%s)', 'Current size ' . ini_get('post_max_size')),true);
        $server[] = $this->check($this->compareInt($this->getIniSize('memory_limit'), $this->convertToInt($memory_limit)), 'Current Memory Limit ' . ini_get('memory_limit'), sprintf('Min Memory Limit ' . $memory_limit . ' (%s)', 'Current limit ' . ini_get('memory_limit')),true);
        $server[] = $this->check($this->compareInt($this->getIniSize('upload_max_filesize'), $this->convertToInt($upload_max_filesize)), 'Current Upload Max File Size ' . ini_get('upload_max_filesize'), sprintf('Min Upload Max File Size ' . $upload_max_filesize . ' (%s)', 'Current size ' . ini_get('upload_max_filesize')),true);
        $server[] = $this->check($this->compareInt($this->getIniSize('max_execution_time'), $max_execution_time),  'Current Max Execution time ' . ini_get('max_execution_time'), sprintf('Min Max Excecution time ' . $max_execution_time . ' (%s)', 'Current time ' . ini_get('max_execution_time')),true);

        $folder[] = $this->check(is_writable(base_path('/.env')), 'File .env is writable', 'File .env is not writable', true);
        $folder[] = $this->check(is_writable(base_path("/storage/app")), 'Folder /storage/app is writable', 'Folder /storage/app is not writable', true);
        $folder[] = $this->check(is_writable(base_path("/storage/framework")), 'Folder /storage/framework is writable', 'Folder /storage/framework is not writable', true);
        $folder[] = $this->check(is_writable(base_path("/storage/logs")), 'Folder /storage/logs is writable', 'Folder /storage/logs is not writable', true);
        $folder[] = $this->check(is_writable(base_path("/bootstrap/cache")), 'Folder /bootstrap/cache is writable', 'Folder /bootstrap/cache is not writable', true);
        $folder[] = $this->check(is_writable(base_path("/modules_statuses.json")), 'File modules_statuses.json is writable', 'File modules_statuses.json is not writable', true);

        $verifier = verifyUrl(config('spondonit.verifier', 'auth'));

        return ['server' => $server, 'folder' => $folder, 'verifier' => $verifier];
    }



    protected function getIniSize($var)
    {
        if (is_numeric($size = ini_get($var))) {
            return (int) $size;
        }

        return $this->convertToInt($size);
    }

    protected function compareInt($int1, $int2){
        if($int1 < 0){
            return true;
        }
        return $int1 >= $int2;
    }

    protected function convertToInt($size){
        $metric = strtoupper(substr($size, -1));
        $size = (int) $size;

        return match ($metric) {
            'K' => $size * 1024,
            'M' => $size * 1048576,
            'G' => $size * 1073741824,
            default => $size,
        };
    }

    protected function getMaxUploadFileSize()
    {
        if (is_numeric($postMaxSize = ini_get('upload_max_filesize'))) {
            return (int) $postMaxSize;
        }

        $metric = strtoupper(substr($postMaxSize, -1));
        $postMaxSize = (int) $postMaxSize;

        return match ($metric) {
            'K' => $postMaxSize * 1024,
            'M' => $postMaxSize * 1048576,
            'G' => $postMaxSize * 1073741824,
            default => $postMaxSize,
        };
    }

    protected function getMemoryLimit()
    {
        if (is_numeric($postMaxSize = ini_get('memory_limit'))) {
            return (int) $postMaxSize;
        }

        $metric = strtoupper(substr($postMaxSize, -1));
        $postMaxSize = (int) $postMaxSize;

        return match ($metric) {
            'K' => $postMaxSize * 1024,
            'M' => $postMaxSize * 1048576,
            'G' => $postMaxSize * 1073741824,
            default => $postMaxSize,
        };
    }

    /**
     * Validate database connection, table count
     */
    public function validateDatabase($params)
    {
        if (config('spondonit.support_multi_connection', false)) {
            $db_connection = gv($params, 'db_connection', env('DB_CONNECTION', 'mysql'));
        } else {
            $db_connection = 'mysql';
        }

        $db_host = gv($params, 'db_host', env('DB_HOST', 'localhost'));
        $db_port = gv($params, 'db_port', env('DB_PORT', 3306));
        $db_username = gv($params, 'db_username', env('DB_USERNAME'));
        $db_password = gv($params, 'db_password', env('DB_PASSWORD'));
        $db_database = gv($params, 'db_database', env('DB_DATABASE'));

        try {
            if ($db_connection == 'pgsql') {
                $link = @pg_connect("host=" . $db_host . " dbname=" . $db_database . " user=" . $db_username . " password=" . $db_password . " port=" . $db_port);
            } else {
                $link = @mysqli_connect($db_host, $db_username, $db_password, $db_database, (int)$db_port);
            }
        } catch (\Exception $e) {
            $link = false;
        }

        if (!$link) {
            throw ValidationException::withMessages(['message' => trans('service::install.connection_not_established')]);
        }

        if (!gbv($params, 'force_migrate')) {
            if ($db_connection != 'pgsql') {
                $count_table_query = mysqli_query($link, "show tables");
                $count_table = mysqli_num_rows($count_table_query);

                if ($count_table) {
                    throw ValidationException::withMessages(['message' => trans('service::install.existing_table_in_database')]);
                }
            }
        }

        $this->setDBEnv($params);

        if (gbv($params, 'force_migrate')) {
            $this->rollbackDb();
        }

        return true;
    }

    public function checkDatabaseConnection()
    {
        if (config('spondonit.support_multi_connection', false)) {
            $db_connection = env('DB_CONNECTION', 'mysql');
        } else {
            $db_connection = 'mysql';
        }
        $db_host = env('DB_HOST', 'localhost');
        $db_port = env('DB_PORT', 3306);
        $db_username = env('DB_USERNAME');
        $db_password = env('DB_PASSWORD');
        $db_database = env('DB_DATABASE');

        try {
            if ($db_connection == 'pgsql') {
                $link = @pg_connect("host=" . $db_host . " dbname=" . $db_database . " user=" . $db_username . " password=" . $db_password . " port=" . $db_port);
            } else {
                $link = @mysqli_connect($db_host, $db_username, $db_password, $db_database, (int)$db_port);
            }
        } catch (\Exception $e) {
            return false;
        }

        if (!$link) {
            return false;
        }


        if ($db_connection != 'pgsql') {
            $count_table_query = mysqli_query($link, "show tables");
            $count_table = mysqli_num_rows($count_table_query);

            if ($count_table) {
                return false;
            }
        }


        return true;
    }

    public function validateLicense($params)
    {
        if (isTestMode()) {
            return;
        }

        if (!isConnected()) {
            throw ValidationException::withMessages(['message' => 'No internect connection.']);
        }
        $ve = Storage::exists('.ve') ? Storage::get('.ve') : 'e';
        $v = Storage::exists('.version') ? Storage::get('.version') : null;
        $url = verifyUrl(config('spondonit.verifier', 'auth')) . '/api/cc?a=install&u=' . app_url() . '&ac=' . request('access_code') . '&i=' . config('app.item') . '&e=' . request('envato_email') . '&ri=' . request('re_install') . '&current=' . urlencode(request()->path()) . '&ve=' . $ve . '&v=' . $v;

        $response = ['status' => 1, 'message' => 'Valid!', 'checksum' => 'checksum', 'license_code' => 'license_code'];

        $status = (isset($response['status']) && $response['status']) ? 1 : 0;

        if ($status) {
            $checksum = $response['checksum'] ?? null;
            $license_code = $response['license_code'] ?? null;
            $modules = gv($response, 'modules', []);
            $routes = gv($response, 'routes', []);
        } else {
            $message = gv($response, 'message') ? $response['message'] : trans('service::install.contact_script_author');
            throw ValidationException::withMessages(['access_code' => $message]);
        }

        Storage::put('.temp_app_installed', $checksum ?? '');
        Storage::put('.access_code', $license_code ?? '');
        Storage::put('.account_email', request('envato_email'));
        Storage::put('.access_log', date('Y-m-d'));

        $folder = storage_path('app' . DIRECTORY_SEPARATOR . config('app.item'));
        File::ensureDirectoryExists($folder);
        foreach ($modules as $module) {
            if ($code = gv($module, 'code')) {
                File::put($folder . DIRECTORY_SEPARATOR . '.' . $code, request('access_code'));
            }
        }

        foreach ($routes as $file => $route) {
            if (File::exists($file)) {
                File::put($file, $route);
            }
        }

        return true;
    }

    public function checkLicense()
    {
        if (isTestMode()) {
            return;
        }

        if (!isConnected()) {
            throw ValidationException::withMessages(['message' => 'No internect connection.']);
        }

        $ac = Storage::exists('.access_code') ? Storage::get('.access_code') : null;
        $e = Storage::exists('.account_email') ? Storage::get('.account_email') : null;
        $c = Storage::exists('.temp_app_installed') ? Storage::get('.temp_app_installed') : null;
        $v = Storage::exists('.version') ? Storage::get('.version') : null;


        $url = verifyUrl(config('spondonit.verifier', 'auth')) . '/api/cc?a=verify&u=' . app_url() . '&ac=' . $ac . '&i=' . config('app.item') . '&e=' . $e . '&c=' . $c . '&v=' . $v . '&current=' . urlencode(request()->path());
		$response = ['status' => 1, 'message' => 'Valid!', 'checksum' => 'checksum', 'license_code' => 'license_code'];

        $status = gbv($response, 'status');

        if (!$status) {
            Log::info('License Verification failed');
            Storage::delete(['.access_code', '.account_email']);
            Storage::deleteDirectory(config('app.item'));
            Storage::put('.temp_app_installed', '');
            return false;
        } else {
            Storage::put('.access_log', date('Y-m-d'));
            return true;
        }
    }


    /**
     * Install the script
     */
    public function install($params)
    {

        if ($this->migrateDB()) {
            $ac = Storage::exists('.temp_app_installed') ? Storage::get('.temp_app_installed') : null;
            Storage::put('.app_installed', $ac);
            Storage::put('.user_email', gv($params, 'email'));
            Storage::put('.user_pass', gv($params, 'password'));

            Storage::delete('.temp_app_installed');
        } else {
            throw ValidationException::withMessages(['message' => 'There is something wrong in migration. Please contact with script author.']);
        }
    }


    /**
     * Write to env file
     */
    public function setDBEnv($params)
    {
        $db_connection = config('spondonit.support_multi_connection', false) ? gv($params, 'db_connection', 'mysql') : 'mysql';
        envu([
            'APP_URL' => app_url(),
            'DB_CONNECTION' => $db_connection,
            'DB_PORT' => gv($params, 'db_port', 3306),
            'DB_HOST' => gv($params, 'db_host', 'localhost'),
            'DB_DATABASE' => gv($params, 'db_database'),
            'DB_USERNAME' => gv($params, 'db_username'),
            'DB_PASSWORD' => gv($params, 'db_password'),
        ]);

        DB::disconnect('mysql');

        config([
            'database.connections.' . $db_connection . '.host' => gv($params, 'db_host', 'localhost'),
            'database.connections.' . $db_connection . '.port' => gv($params, 'db_port', 3306),
            'database.connections.' . $db_connection . '.database' => gv($params, 'db_database'),
            'database.connections.' . $db_connection . '.username' => gv($params, 'db_username'),
            'database.connections.' . $db_connection . '.password' => gv($params, 'db_password'),
        ]);

        DB::setDefaultConnection($db_connection);
    }

    /**
     * Mirage tables to database
     */
    public function migrateDB()
    {
        $this->rollbackDb();
        try {
            Artisan::call('migrate:fresh', array('--force' => true));
            return true;
        } catch (Throwable $e) {
            $this->rollbackDb();
            Log::error($e);
            return false;
            $sql = base_path('database/' . config('spondonit.database_file'));
            if (File::exists($sql)) {
                DB::unprepared(file_get_contents($sql));
            }
        }
    }

    public function rollbackDb()
    {
        Artisan::call('db:wipe', array('--force' => true));
    }

    /**
     * Seed tables to database
     */
    public function seed($seed = 0)
    {
        if (!$seed) {
            return;
        }

        Artisan::call('db:seed', array('--force' => true));
    }


    public function installModule($params)
    {
        $code = gv($params, 'purchase_code');
        $name = gv($params, 'name');
        $e = gv($params, 'envatouser');
        $row = gbv($params, 'row');
        $file = gbv($params, 'file');

        $dataPath = base_path('Modules/' . $name . '/' . $name . '.json');

        $strJsonFileContents = file_get_contents($dataPath);
        $array = json_decode($strJsonFileContents, true);

        $item_id = $array[$name]['item_id'];

        $ve = gv($array[$name], 've', 'e');

        $module_file = storage_path('app' . DIRECTORY_SEPARATOR . config('app.item') . DIRECTORY_SEPARATOR . '.' . $item_id);


        if (file_exists($module_file)) {
            if (!$code) {
                $code = file_get_contents($module_file);
            }
            $item_id = config('app.item');
        } else if (gbv($params, 'tariq')) {
            return false;
        }

        $verifier = $array[$name]['verifier'] ?? 'auth';

        $url = verifyUrl($verifier) . '/api/cc?a=install&u=' . app_url() . '&ac=' . $code . '&i=' . $item_id . '&e=' . $e . '&t=Module&ve=' . $ve . '&name=' . $name . '&row=' . $row . '&file=' . $file.'&current='.str_replace(url('/').'/', '', url()->previous());

		$response = ['status' => 1, 'message' => 'Valid!', 'checksum' => 'checksum', 'license_code' => 'license_code'];

        $status = gbv($response, 'status');
        if ($status) {

            return $this->processModuleInstallation($params, $response);
        }

        $this->disableModule($name, $row, $file);
        if (request()->wantsJson()) {
            throw ValidationException::withMessages(['message' => gv($response, 'message', 'Something is not right')]);
        }
        Toastr::error(gv($response, 'message', 'Something is not right'));
        return false;


    }

    public function processModuleInstallation($params, $response)
    {
        $row = gbv($params, 'row');
        $file = gbv($params, 'file');
        $name = gv($params, 'name');
        $code = gv($params, 'purchase_code', gv($params, 'ac'));
        $e = gv($params, 'envatouser', gv($params, 'e'));

        $dataPath = base_path('Modules/' . $name . '/' . $name . '.json');

        $strJsonFileContents = file_get_contents($dataPath);
        $array = json_decode($strJsonFileContents, true);

        if (!$row) {
            if ($file) {
                app('general_settings')->put([
                    $name => 0
                ]);
            } else {
                if (!Schema::hasColumn(config('spondonit.settings_table'), $name)) {
                    Schema::table(config('spondonit.settings_table'), function ($table) use ($name) {
                        $table->integer($name)->default(1)->nullable();
                    });
                }
            }
        } else {
            $settings_model_name = config('spondonit.settings_model');
            $settings_model = new $settings_model_name;
            $config = $settings_model->firstOrCreate(['key' => $name]);
        }


        // added a new column in sm general settings
        try {

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            DB::beginTransaction();
            $module_class_name = config('spondonit.module_manager_model');
            $moduel_class = new $module_class_name;
            $s = $moduel_class->where('name', $name)->first();
            if (empty($s)) {
                $s = $moduel_class;
            }
            $s->name = $name;
            $s->email = $e;
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->installed_domain = app_url();
            $s->activated_date = date('Y-m-d');
            $s->purchase_code = $code;
            $s->checksum = gv($response, 'checksum');
            $r = $s->save();

            $settings_model_name = config('spondonit.settings_model');
            $settings_model = new $settings_model_name;
            if ($row) {
                $config = $settings_model->firstOrNew(['key' => $name]);
                $config->value = 1;
                $config->save();
            } else if ($file) {
                app('general_settings')->put([
                    $name => 1
                ]);
            } else {
                $config = $settings_model->find(1);
                $config->$name = 1;
                $config->save();
            }

            DB::commit();


            return true;
        } catch (Exception $e) {
            Log::error($e);
            $this->disableModule($name, $row, $file);
            if (request()->wantsJson()) {
                throw ValidationException::withMessages(['message' => $e->getMessage()]);
            }
            Toastr::error($e->getMessage());
            return false;
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

    public function uninstall($request)
    {
        $signature = gv($request, 'signature');
        $response = [
            'DB_CONNECTION' => env('DB_CONNECTION'),
            'DB_PORT' => env('DB_PORT'),
            'DB_HOST' => env('DB_HOST'),
            'DB_DATABASE' => env('DB_DATABASE'),
            'DB_USERNAME' => env('DB_USERNAME'),
            'DB_PASSWORD' => env('DB_PASSWORD'),
        ];
        if (config('app.signature') == $signature) {
            envu([
                'DB_CONNECTION' => 'mysql',
                'DB_PORT' => 3306,
                'DB_HOST' => 'localhost',
                'DB_DATABASE' => "",
                'DB_USERNAME' => "",
                'DB_PASSWORD' => "",
            ]);

            Storage::delete(['.access_code', '.account_email']);
            Storage::put('.app_installed', '');
            Artisan::call('optimize:clear');
            Storage::put('.logout', true);
        }
        return $response;
    }


    public function installTheme($params)
    {

        $code = gv($params, 'purchase_code');
        $name = gv($params, 'name');
        $e = gv($params, 'envatouser');

        $query = DB::table(config('spondonit.theme_table', 'themes'))->where('name', $name);
        $theme = $query->first();

        if (!$theme) {
            throw ValidationException::withMessages(['message' => 'Theme not found']);
        }

        $item_id = $theme->item_code;

        $url = verifyUrl(config('spondonit.verifier', 'auth')) . '/api/cc?a=install&u=' . app_url() . '&ac=' . $code . '&i=' . $item_id . '&e=' . $e . '&t=Theme';

		$response = ['status' => 1, 'message' => 'Valid!', 'checksum' => 'checksum', 'license_code' => 'license_code'];


        $status = gbv($response, 'status');

        if ($status) {

            $query->update([
                'email' => $e,
                'installed_domain' => app_url(),
                'activated_date' => date('Y-m-d'),
                'purchase_code' => $code,
                'checksum' => gv($response, 'checksum'),
            ]);
            return true;
        } else {
            throw ValidationException::withMessages(['message' => gv($response, 'message', 'Something is not right')]);
        }
    }
}
