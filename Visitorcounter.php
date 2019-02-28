<?php 

/**
 * 
 */

require 'geoip-reader/vendor/autoload.php';
use GeoIp2\Database\Reader;
$ipreader = new Reader($_SERVER['DOCUMENT_ROOT'].'/counter/GeoLite2-City/GeoLite2-City.mmdb');

class Visitorcounter
{
	

/*
*
*
*
*
*/
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

 public function getCountry($ip='')
 {
 	# code...
 	global $ipreader;
 	$ip = !empty($ip) ? $ip : $this->getRealIpAddr();
	if($ip !== '127.0.0.1'){
	$record = $ipreader->city($ip);
	return $record->country->name; // 'United States'

 	}else{
 		
	return 'Invalid IP address: '.$ip;

 	}
 }


 public function getCountrycode($ip='')
 {
 	# code...
 	global $ipreader;
 	$ip = !empty($ip) ? $ip : $this->getRealIpAddr();
	if($ip !== '127.0.0.1'){
	$record = $ipreader->city($ip);
	return $record->country->code; // 'United States'

 	}else{
 		
	return 'Invalid IP address: '.$ip;

 	}
 }

 public function getCity($ip='')
 {
 	# code...
 	global $ipreader;
 	$ip = !empty($ip) ? $ip : $this->getRealIpAddr();
	if($ip !== '127.0.0.1'){
	$record = $ipreader->city($ip);
	return $record->city->name; // 'United States'

 	}else{
 		
	return 'Invalid IP address: '.$ip;

 	}
 }

// Get user device information
function getOS($user_agent='') { 

   // global $user_agent;

    $os_platform    =   "Unknown OS Platform";

    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );

    foreach ($os_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }

    }   

    return $os_platform;

}

//Get browser info

function getBrowser($user_agent="") {

    //global $user_agent;

    $browser        =   "Unknown Browser";

    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/edge/i'       =>  'Edge',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );

    foreach ($browser_array as $regex => $value) { 

        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }

    }

    return $browser;

}



/* check if the visitors is robot or human before updating the counter */
  public function check_bots($agent='')
	{
		# code...
	if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $agent)) {
    // is bot
		return true;
	}else {return false;}
	}
}