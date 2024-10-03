<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CCAvenuePaymentController extends Controller
{
    
    public function index()
    {
        $whmcsUrl = "https://www.yourdomain.com/path/to/whmcs/";

        // For WHMCS 7.2 and later, we recommend using an API Authentication Credential pair.
        // Learn more at http://docs.whmcs.com/API_Authentication_Credentials
        // Prior to WHMCS 7.2, an admin username and md5 hash of the admin password may be used
        // with the 'username' and 'password' keys instead of 'identifier' and 'secret'.
        $api_identifier = "your_api_credential_identifier";
        $api_secret = "your_api_credential_secret";
        
        // Set post values
        $postfields = array(
            'identifier' => $api_identifier,
            'secret' => $api_secret,
            'action' => 'GetClients',
            'responsetype' => 'json',
        );
        
        // Call the API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $whmcsUrl . 'includes/api.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
        $response = curl_exec($ch);
        if (curl_error($ch)) {
            die('Unable to connect: ' . curl_errno($ch) . ' - ' . curl_error($ch));
        }
        curl_close($ch);
        
        // Decode response
        $jsonData = json_decode($response, true);
    }

   
}
