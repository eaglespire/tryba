<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Request;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   public  function AllowedCountries($variable)
   {
    $country = [
        'Andorra',
        'Argentina',
        'Bahamas',
        'Bahrain',
        'Bermuda',
        'Botswana',
        'Cayman Islands',
        'Chile',
        'China',
        'Colombia',
        'Costa Rica',
        'Croatia',
        'Dominican Republic',
        'Ecuador',
        'El Salvador',
        'Faroe Islands',
        'Georgia',
        'Greenland',
        'Guatemala',
        'Honduras',
        'Hong Kong SAR, China',
        'United Kingdom',
        'Iceland',
        'India',
        'Indonesia',
        'Israel',
        'Jamaica',
        'Japan',
        'Jordan',
        'Kazakhstan',
        'Kenya',
        'Kuwait',
        'Lesotho',
        'Malaysia',
        'Mauritius',
        'Mexico',
        'Moldova',
        'Monaco',
        'Morocco',
        'Mozambique',
        'Oman',
        'New Zealand',
        'Nicaragua',
        'Norway',
        'Panama',
        'Peru',
        'Philippines',
        'Qatar',
        'Saudi Arabia',
        'Senegal',
        'Serbia',
        'Singapore',
        'South Africa',
        'South Korea',
        'Taiwan',
        'Thailand',
        'United Arab Emirates',
        'Uruguay',
        'Venezuela',
        'Vietnam'
        ];

    if (in_array($variable, $country)) {
        return true;
    } else {
        return false;
    }
}

public function getuser(){
   return auth()->user();
}

public function email_verification($email){
    $api_key = "PCW2P-B32G7-8H9BN-ZY6LH";
    $url = "https://ws.postcoder.com/pcw/$api_key/email/". urlencode($email);
    $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $res = curl_exec($ch);
            $err = curl_errno($ch);
            curl_close($ch);
            if($err){
            echo "error".$err;
            }
        $data = json_decode($res);
         return $data;

}



}
