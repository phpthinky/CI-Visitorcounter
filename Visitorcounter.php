<?php 
/*
*  Name: Visitor Counter Class version 1.0  (Note: for codeigniter user: you can email me @ letswrite14@gmail.com or visit in my website.)
*  By: Harold Rita
*  Website: //www.coloftech.com
*  License: GNU General Public license
*/

date_default_timezone_set('ASIA/MANILA');
/*
*
* this line of code use to read/get visitor country, citys ad the like
* Temporary disable to run this code message me or download the geolite2-city.mmdb at github
*/
/*
require 'geoip-reader/vendor/autoload.php';
use GeoIp2\Database\Reader;
// This creates the Reader object, which should be reused across
// lookups.
$ipreader = new Reader($_SERVER['DOCUMENT_ROOT'].'/counter/GeoLite2-City/GeoLite2-City.mmdb');*/
/*
*
* End of reader
*
*/

class Visitorcounter extends Database
{
	
	private $domain  = 'myapp.ci/counter';
	private $cookieExist = false;


	private $cookie_prefix	= '';
	private $cookie_domain	= '';
	private $cookie_path		= '/';
	private $cookie_secure	= FALSE;
	private $cookie_httponly 	= FALSE;

	public function run_counter($visita='')
  {
		  	# code...


				$userip =$this->get_ip();
				$url =  $this->get_pageUrl();
				$agent = $this->get_agent();
				$machine =  $this->getOS($agent);
				$browser =  $this->getBrowser($agent);
				$page_id = $this->get_page_id($url);
				$date = date('Y-m-d');
				$time = time();


		if(!$this->check_bots($agent)){

			$newcookie = $this->setcookiedata($visita,'hello');

		  	if($newcookie === false){

		  		$url = $this->get_pageUrl();
		  		if($exist = $this->check_on_db($userip,$url)){
		  			//echo "Update today counter";
		  			if($this->last_update($userip,$url, $time)){
		  			$this->update_today_counter($userip,$url,$browser,$time);  

		  			//echo "Update today counter";				
		  			}

		  		}else{
		  			//echo "insert new visitor";
		  			$this->insert_new_visitor($url,$page_id,$date,$machine,$browser,$userip,$time);
		  		}
		  	}


		  		$this->cron_counter(); //update table page_visits every 6 hours; to use it in cron job, create new file and call this cron counter

		  }else{
		  	exit('Warning: robot detected');
		  }
  	}
  		public function setcookiedata($item='',$data='')
	{
		# code...


        	$data = $this->encrypt_md($this->get_pageUrl());


		if(!isset($_COOKIE[$item])){
			$cookies[] = $data;
			setcookie($item,json_encode($cookies), time() + 21600);
        	$this->cookieExist = true;
        	return false;
		}else{


        	$cookies = stripcslashes($_COOKIE[$item]);
        	$cookies = json_decode($cookies);
        	//var_dump($cookies);
        	//echo "<br>";

        	foreach ($cookies as $key=>$value) {
        		# code...
        		//echo "$key. $value<br>";
        		if($value === $data){
        			$this->cookieExist = true;
        		}
        		$array[] = $value;
        	}



        	if($this->cookieExist === false){

        	$cookies[] = $data;
        	//$this->deleteCookie($item);
        	unset($_COOKIE[$item]);
        	setcookie($item,json_encode($cookies), time() + 21600);
        	$this->cookieExist = true;
        	return false;



        	}else{
        		return true;
        	}


		}

	}



	function deleteCookie($name, $domain = '', $path = '/', $prefix = '')
	{
		$this->setnewcookie($name, '', '', $domain, $path, $prefix);
	}
	function setnewcookie($name, $value = '', $expire = '', $domain = '', $path = '/', $prefix = '', $secure = NULL, $httponly = NULL)
	{

		if (is_array($name))
		{
			// always leave 'name' in last place, as the loop will break otherwise, due to $$item
			foreach (array('value', 'expire', 'domain', 'path', 'prefix', 'secure', 'httponly', 'name') as $item)
			{
				if (isset($name[$item]))
				{
					$$item = $name[$item];
				}
			}
		}

		if ($prefix === '' && $this->cookie_prefix !== '')
		{
			$prefix = $this->cookie_prefix;
		}

		if ($domain == '' && $this->cookie_domain != '')
		{
			$domain = $this->cookie_domain;
		}

		if ($path === '/' && $this->cookie_path !== '/')
		{
			$path = $this->cookie_path;
		}

		$secure = ($secure === NULL && $this->cookie_secure !== NULL)
			? (bool) $this->cookie_secure
			: (bool) $secure;

		$httponly = ($httponly === NULL && $this->cookie_httponly !== NULL)
			? (bool) $this->cookie_httponly
			: (bool) $httponly;

		if ( ! is_numeric($expire))
		{
			$expire = time() - 86500;
		}
		else
		{
			$expire = ($expire > 0) ? time() + $expire : 0;
		}

		setcookie($prefix.$name, $value, $expire, $path, $domain, $secure, $httponly);
	}




	public function encrypt_md($value='')
	  {
	  	# code...
	  	$encrypted = md5($value);
	  	return $encrypted;
	}

  public function get_pageUrl()
  {
  	# code...
  	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
  	$session_page_url = $protocol.$this->domain.$_SERVER['PHP_SELF'];
  	return $session_page_url;

  }










  /*
  *
  * Get machine information of visitors
  *
  *
  */
   public function get_ip()
  {

  $user_ip=$_SERVER['REMOTE_ADDR'];
    return $user_ip;
  }

  public function get_agent()
  {
   $userAgent = $_SERVER['HTTP_USER_AGENT'];
   return $userAgent;
  }


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



/*
*
*
*
*
*/
 public function getCountry($ip='')
 {
 	# code...
 	global $ipreader;
 	$ip = !empty($ip) ? $ip : $this->get_ip();
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
 	$ip = !empty($ip) ? $ip : $this->get_ip();
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
 	$ip = !empty($ip) ? $ip : $this->get_ip();
	if($ip !== '127.0.0.1'){
	$record = $ipreader->city($ip);
	return $record->city->name; // 'United States'

 	}else{
 		
	return 'Invalid IP address: '.$ip;

 	}
 }






/*
*
*
*
*
*/
/*
*
*
* check if the visitors is robot or human before updating the counter

*
*
*
*/
  public function check_bots($agent='')
	{
		# code...
	if (preg_match('/bot|crawl|curl|dataprovider|search|get|spider|find|java|majesticsEO|google|yahoo|teoma|contaxe|yandex|libwww-perl|facebookexternalhit/i', $agent)) {
    // is bot
		return true;
	}else {return false;}
	}

















/*
*
*
*  Select, insert, update, delete from Database 
*
*
*
*/


  public function insert_new_visitor($url='',$page_id='',$date='',$machine='',$browser='',$userip='',$time = 0)
  {
  	# code...

		  	$now = date('Y-m-d');
		  	$year = date('Y');
		  	$day = date('d');
		  	$tday = date('D');
		  	$month = date('m');

  			  $data = array(
		        'userip' => $userip,
		        'page' => urlencode($url),
		        'page_id' => $page_id,
		        'counter' => 1,
		        'complete_date' => $now,
		        'machine'=>$machine,
		        'browser'=>$browser,
		        'year'=>$year,
		        'month'=>$month,
		        'day'=>$day,
		        'tday'=>$tday,
		        'timeUpdate'=>$time,
			);

		  		return $insert = $this->insert('pageview',$data);

  }


	public function update_today_counter($userip='',$url='',$browser='Unknown browser',$time = 0)
	{
		# code...


		$where = sprintf("page = '%s' AND userip = '%s' ",urlencode($url),$userip);

		$set = sprintf("counter = counter + 1,last_used_browser = browser,browser = '%s', timeUpdate = %d",$browser,$time);

		return $this->update('pageview',$set,$where);

	}
   	public function get_page_id($value='')
 	{
 		# code...
 		if(!empty($value)){
 		$value = $this->escape($value);
 		$value = urlencode($value);
 		$result = $this->query('SELECT page_id FROM pages WHERE page_url ="'.$value.'"');

 		if($rows = $this->result($result)){
			$this->db_close();
 			return $rows[0]->page_id;
 		}
			$this->db_close();

 		}
 		return 0;
 	}

  		public function check_on_db($userip='',$page='')
	{
		# code...

 		$page = $this->escape($page);
 		$userip = $this->escape($userip);

		$array = sprintf("SELECT * FROM pageview WHERE page = '%s' AND userip = '%s' ",urlencode($page),$userip);

 		$sql = $this->query($array);

 		$result = $this->result($sql);
			$this->db_close();

 		if(count($result) > 0){


 			return true;
 		}else{

 		//echo "False";
 		return false;
 		}

	}

	public function last_update($userip='',$url, $time=0)
	{
		# code...
		$array = sprintf("SELECT timeUpdate FROM pageview WHERE page = '%s' AND userip = '%s' ",urlencode($url),$userip);

 		$sql = $this->query($array);
 		$result = $this->result($sql); 	
			$this->db_close();	

 		if(count($result) > 0){

 			$lastupdatetime = $result->timeUpdate + 21600;

 			if($lastupdatetime <= $time){
 				return true;
 			}else{
 				return false;
 			}
 		}else{

 			return false;
 		}

	}


/*
 	*
 	*
 	*
 	*    Show visitors list
 	*
 	*
 	*/
 	public function visit_today($value='')
	{
		# code...
		$page = urlencode($value);
		$year = date('y');
		$month = date('m');
		$today = date('Y-m-d');
		$sql = sprintf("SELECT sum(count) as total from page_visits where page='%s' AND date_visited = '%s'  AND year(date_visited) = year(now())",$page,$today);
		// var_dump($sql);exit();
		$query = $this->query($sql);
		$result = $this->result($query);
			$this->db_close();
		return isset($result->total) ? $result->total : 0;
	}
	public function visit_thisweek($value='')
	{
		# code...

		$page = urlencode($value);
		$year = date('y');
		$month = date('m');
		$today = date('Y-m-d');
		$sql = sprintf("SELECT sum(count) as total from page_visits where page='%s' AND week(date_sub(date_visited, interval + 7 day)) <= week(now()) AND week(date_visited) >= week(now()) AND year(date_visited) = year(now()) ",$page,$today,$today);
		// var_dump($sql);exit();
		$query = $this->query($sql);
		$result = $this->result($query);
			$this->db_close();
		return isset($result->total) ? $result->total : 0;
	}
	public function visit_thismonth($value='')
	{
		# code...
		$page = urlencode($value);
		$year = date('y');
		$month = date('m');
		$sql = sprintf("SELECT sum(count) as total from page_visits where page='%s' AND month(date_visited) = month(now()) AND year(date_visited) = year(now()) ",$page);
		// var_dump($sql);exit();
		$query = $this->query($sql);
		$result = $this->result($query);
			$this->db_close();
		return isset($result->total) ? $result->total : 0;
	}
	public function visit_thisyear($value='')
	{
		# code...
		$page = urlencode($value);
		$year = date('y');
		$month = date('m');
		$sql = sprintf("SELECT sum(count) as total from page_visits where page='%s' AND year(date_visited) = year(now()) ",$page);
		// var_dump($sql);exit();
		$query = $this->query($sql);
		$result = $this->result($query);
			$this->db_close();
		return isset($result->total) ? $result->total : 0;
	}

	public function visit_total($page='')
	{
		# code...
		if($page !== ''){
		$page = urlencode($page);

		$year = date('y');
		$month = date('m');
		$sql = sprintf("SELECT sum(count) as total from page_visits where page='%s' group by page ",$page);
		// var_dump($sql);exit();
		$query = $this->query($sql);
		$result = $this->result($query);
			$this->db_close();
		return isset($result->total) ? $result->total : 0;

		}else{

		$year = date('y');
		$month = date('m');
		$sql = sprintf("SELECT sum(count) as total from page_visits ");
		// var_dump($sql);exit();
		$query = $this->query($sql);
		$result = $this->result($query);
			$this->db_close();
		return isset($result->total) ? $result->total : 0;
		}
	}





/*****
******
******
******
*******This line of code used to call in manual cron job*********
******
******/

	public function cron_counter()
	{ 
		

		$time = date("h");
		if($time > 10 && $time < 12){
			$this->run_cron_job();
		}elseif ($time > 5 && $time < 7) {
			# code...
			$this->run_cron_job();
		}

	}
	public function run_cron_job()
		{
			# code...
		$result = '';$query='';$sql='';
		$sql = sprintf("SELECT * from pageview");
		$query = $this->query($sql);
		while($key = $this->result($query)){

			
			$sql2 = sprintf("SELECT sum(counter) as total from pageview where page = '%s' and complete_date = '%s'",$key->page,$key->complete_date);
			$query2 = $this->query($sql2);
			$result2= $this->result($query2);

			$total = $result2->total;
			
			$this->update_pagevisit($key->page,$key->page_id,$total, $key->complete_date,'');

			$del = $this->del_on_pageview($key->page,$key->complete_date);
			var_dump($del);
		}



	}

	public function update_pagevisit($page='',$page_id=0,$counter = 0, $date = '',$country='')
	{
		# code...
		if($page != ''){

			$sql = sprintf("SELECT * from page_visits where page = '%s' and date_visited = '%s'",urlencode($page),$date);
			$query = $this->query($sql);
			if($result = $this->result($query))
			{


				$where = sprintf("page = '%s' AND date_visited = '%s' ",urlencode($url),$date);
				$set = sprintf("count = count + %d ",$counter);
				$this->update('page_visits',$set,$where);


			}else{
				$array = array(
					'page' =>$page,
					'page_id' =>$page_id,
					'count' =>$counter,
					'date_visited' =>$date,
					'country'=>$country );
				$this->insert('page_visits',$array);

		}
			$this->db_close();
		return;

	}
	}
	public function del_on_pageview($page='',$date='')
	{
		# code...
		if($page != ''){

			$sql = sprintf("DELETE FROM pageview WHERE page = '%s' AND complete_date = '%s' ",$page,$date);
			return $this->query($sql);
		}
		return;

	}



















}
