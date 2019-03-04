<?php 

/**
 * 
 */

require 'geoip-reader/vendor/autoload.php';
use GeoIp2\Database\Reader;
$ipreader = new Reader(BASEPATH.'../counter/GeoLite2-City/GeoLite2-City.mmdb');

class Visitorcounter
{
	

/*
*
*
*
*
*/
public function setcookie($value='')
{
	# code...

			$cookie_name = "user";
			$cookie_value = "John Doe";
			
	if(!isset($_COOKIE[$cookie_name])) {

			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
			return false;

		} else {
			return true;
		}

}
 public function run($value='')
        {
        	if($this->check_bots($this->userAgent())){
        		// do nothing
        	}else{
        		if ($this->setcookie()) {
        		// do nothing
        		}else{

		            $makeDirY = $this->makeDir(BASEPATH.'../counter/visit/'.date('Y'));
		            $makeDirM = $this->makeDir(BASEPATH.'../counter/visit/'.date('Y').'/'.date('m'));
		            $path = BASEPATH.'../counter/visit/'.date('Y').'/'.date('m');
		            $file = fopen($path.'/'.date('Y-m-d').'.txt', 'a') or die("Can't create file");
		            $ip = $this->getRealIpAddr();
		            $date = date('Y-m-d h:i a');
		            $country =  $this->getCountry($ip);
		            $countrycode =  $this->getCountrycode($ip);
		            $city =  $this->getCity($ip);

		            fwrite($file, "$ip~$date~$country~$countrycode~$city"."\n");
		            fclose($file);
        		}


        	}
            # code...
  }

  public function read($date='',$y=0,$m=0)
  {
  	# code...
  	if (isset($date) && $y > 0 && $m > 0) {
  		# code...

  		$path = BASEPATH.'../counter/visit/'.$y.'/'.$m;
  		$filename = $path.'/'.$date.'.txt';
  		if(file_exists($filename)){
  			$fileinfo = fopen($filename, 'r');
				$data = array();
				$i=0;
				while (!feof($fileinfo)) {
		        	$line = fgets($fileinfo);
		        	$data[$i] = $line;
		        	$i++;
		    		}
		    	fclose($fileinfo);
		    	return $data;

  		}
  		return false;


		exit();
  	}
  		

  	  	$path = BASEPATH.'../counter/visit/'.date('Y').'/'.date('m');
  		$filename = $path.'/'.date('Y-m-d').'.txt';
  		if(file_exists($filename)){
  			$fileinfo = fopen($filename, 'r');
				$data = array();
				$i=0;
				while (!feof($fileinfo)) {
		        	$line = fgets($fileinfo);
		        	$data[$i] = $line;
		        	$i++;
		    		}
		    	fclose($fileinfo);
		    	return $data;

  		}
  		return false;

  }

  public function getcurrentdata($date='',$y=0,$m=0)
  {
    # code...       
            if($data = $this->read($date,$y,$m)){
                $info = array();
                $i=0;
                $country  = '';
                $counter = 0;
                $ip = '';
                foreach ($data as $keys) {
                    # code...

                $data_array = explode('~', $keys);

                    if(count($data_array) > 1){
                       $ip = $data_array[0];
                       $date = $data_array[1];
                       $country = $data_array[2];
                       $countrycode = $data_array[3];

                        $count = $counter++;
                            $info[$i] = array('country'=>$countrycode,'counter'=>$count);
                           $i++;                                         

                    }


                }
                $newdata = array();
                $i=0;
                $j=0;
                asort($info);
                $country = '';
                foreach ($info as $key) {
                    # code...
                    if ($i == 0) {
                        # code...

                        $country = $key['country'];
                        $newdata[$j] = array('country'=>$country,'counter'=>1);
                        $i++;
                        $j++;

                    }else{

                        if ($country == $key['country']) {
                            # code...

                                foreach ($newdata as &$k) {
                                    # code...
                                    if($k['country'] == $country){
                                        
                                    $k['counter'] = $k['counter']+1;
                                    }
                                }
                            $i++;
                        }else{
                        $country = $key['country'];

                        $newdata[$j] = array('country'=>$country,'counter'=>1);
                            $i++;
                            $j++;
                        }
                    }

                }

              return $newdata;

            }else{
              return false;
            }
  }
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
	$ipreader = new Reader(BASEPATH.'../counter/GeoLite2-City/GeoLite2-City.mmdb');

 	$ip = !empty($ip) ? $ip : $this->getRealIpAddr();

	
	if($ip !== '127.0.0.1' && $ip !== "::1"){
	$record = $ipreader->city($ip);
	return $record->country->name; // 'United States'

 	}else{
 		
	return 'Invalid IP address: '.$ip;

 	}
 	
 }


 public function getCountrycode($ip='')
 {
 	# code...

	$ipreader = new Reader(BASEPATH.'../counter/GeoLite2-City/GeoLite2-City.mmdb');

 	$ip = !empty($ip) ? $ip : $this->getRealIpAddr();
	if($ip !== '127.0.0.1' && $ip !== "::1"){
	$record = $ipreader->city($ip);
	return $record->country->isoCode; // 'United States'

 	}else{
 		
	return 'Invalid IP address: '.$ip;

 	}
 }

 public function getCity($ip='')
 {
 	# code...

	$ipreader = new Reader(BASEPATH.'../counter/GeoLite2-City/GeoLite2-City.mmdb');
 	$ip = !empty($ip) ? $ip : $this->getRealIpAddr();
	if($ip !== '127.0.0.1' && $ip !== "::1"){
	$record = $ipreader->city($ip);
	return $record->city->name; // 'United States'

 	}else{
 		
	return 'Invalid IP address: '.$ip;

 	}
 }


public function userAgent($value='')
{
	# code...
	return $_SERVER['HTTP_USER_AGENT'];
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

	public function makeDir($path)
		{
		     return is_dir($path) || mkdir($path);
		}
}
