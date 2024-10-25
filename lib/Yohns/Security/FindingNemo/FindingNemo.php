<?php

namespace Yohns\Security\FindingNemo;
use PDOChainer\DBAL;
use Yohns\Security\UsersGeoData_SQL;
use Yohns\Core\Config;

/**
 * This product includes GeoLite data created by MaxMind, available from
 * http://www.maxmind.com and https://www.geoplugin.com/
 */

class FindingNemo {
	private $ipInfo;
	private $ipInfoUrl;
	private $geoPluginUrl; // they store our domain in their system
	public $nemo;

	public $DBAL;

	private $ip;
	private $status;
	private $delay;
	private $credit;
	private $city;
	private $region;
	private $regionCode;
	private $regionName;
	private $countryCode;
	private $countryName;
	private $inEU;
	private $euVATrate;
	private $continentCode;
	private $continentName;
	private $latitude;
	private $longitude;
	private $locationAccuracyRadius;
	private $timezone;
	private $currencyCode;
	private $currencySymbol;
	private $currencySymbol_UTF8;
	private $currencyConverter;


	public function __construct(DBAL $DBAL) {
		$this->DBAL = $DBAL;
		$this->ipInfo = Config::get('ipInfo', 'nemo');
		$this->nemo = [
			'arrived'      => time() ?? '',
			'http_host'    => $_SERVER['HTTP_HOST'] ?? '',
			'server_name'  => $_SERVER['SERVER_NAME'] ?? '',
			'ip'           => $_SERVER['REMOTE_ADDR'] ?? '',
			'remote_host'  => $_SERVER["REMOTE_HOST"] ?? '',
			'request_uri'  => $_SERVER['REQUEST_URI'] ?? '',
			'http_ref'     => $_SERVER['HTTP_REFERER'] ?? '',
			'query_string' => $_SERVER['QUERY_STRING'] ?? '',
			'client_ip'  	 => $_SERVER['HTTP_CLIENT_IP'] ?? '',
			'user_agent'   => $_SERVER['HTTP_USER_AGENT'] ?? '',
			'language' 		 => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '',
			'x_forwarded'  => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '',
			//'get_browser'	 => get_browser(), //! Will need to install a php module
			//'php-input'    => json_decode(file_get_contents('php://input'),1) ?? '',
			//'apache_head'  => apache_request_headers() ?? '',
			'POST'         => $_POST,
			'GET'          => $_GET,
			'FILES'        => $_FILES,
			'COOKIE'       => $_COOKIE,
		];
		$this->ipInfoUrl = 'http://ipinfo.io/' . $this->nemo['ip'] . '?token=' . $this->ipInfo;
		$this->geoPluginUrl = 'http://www.geoplugin.net/php.gp?ip=' . $this->nemo['ip'];
	}

	public function swimming() {
		$this->nemo['getIpInfo'] = $this->getIpInfo();
		$this->nemo['getGeoPlugin'] = $this->getGeoPlugin();
		$this->set_nemo()->check_nemo()->save_nemo();
		return $this->nemo;
	}

	private function check_nemo(){
		$t = count($_SESSION['Nemo']);
		// now lets compare, the last 10 clicks,
		// and see what they did, where they went, and what they doing..
		if($t > 0){
			$ip = 				array_flip(array_column($_SESSION['Nemo'], 'ip'));
			$user_agent = array_flip(array_column($_SESSION['Nemo'], 'user_agent'));
			$c_ip = count($ip);
			$c_user_agent = count($user_agent);
			if($c_ip != $c_user_agent){
				if($c_ip > $c_user_agent){
					$fail = $c_ip - $c_user_agent;
				} else {
					$fail = $c_user_agent - $c_ip;
				}
			}
			$arrived = array_column($_SESSION['Nemo'], 'arrived');
			//$c_arrived = count($arrived);
			foreach ($arrived as $index => $date) {
				$date = strtotime($date);
				if (!empty($arrived[$index+1])) {
					$nextDate = strtotime($arrived[$index+1]);
					$values[] = ($nextDate-$date);
				}
			}
			//for($i=0;$i<$t;$i++){
			//
			//}
			// lets start limiting these to maybe only the past 10 page loads..
			array_shift($_SESSION['Nemo']);
		} else {
			// we should do something to check if they accept cookies..
		}
	}

	private function save_nemo(){
		$Uid = (isset($_SESSION['Uid']) && $_SESSION['Uid'] > 0) ? $_SESSION['Uid'] : 0;
		$UsersGeoData_SQL = new NemosGeoData_SQL($this->DBAL);
		$row_id = $UsersGeoData_SQL->add_row(
			$Uid,
			$this->nemo['arrived'],
			$this->nemo['http_host'],
			$this->nemo['ip'],
			$this->nemo['http_ref'],
			$this->nemo['request_uri'],
			$this->nemo['user_agent'],
			$this->nemo['post_header'],
			$this->nemo['get_header'],
			$this->nemo['IpInfo']['ipinfo_hostname'],
			$this->nemo['IpInfo']['ipinfo_city'],
			$this->nemo['IpInfo']['ipinfo_region'],
			$this->nemo['IpInfo']['ipinfo_country'],
			$this->nemo['IpInfo']['ipinfo_loc'],
			$this->nemo['IpInfo']['ipinfo_org'],
			$this->nemo['IpInfo']['ipinfo_postal'],
			$this->nemo['IpInfo']['ipinfo_timezone'],
			$this->nemo['getGeoPlugin']['geoplugin_status'],
			$this->nemo['getGeoPlugin']['geoplugin_delay'],
			$this->nemo['getGeoPlugin']['geoplugin_credit'],
			$this->nemo['getGeoPlugin']['geoplugin_city'],
			$this->nemo['getGeoPlugin']['geoplugin_region'],
			$this->nemo['getGeoPlugin']['geoplugin_regionCode'],
			$this->nemo['getGeoPlugin']['geoplugin_regionName'],
			$this->nemo['getGeoPlugin']['geoplugin_areaCode'],
			$this->nemo['getGeoPlugin']['geoplugin_dmaCode'],
			$this->nemo['getGeoPlugin']['geoplugin_countryCode'],
			$this->nemo['getGeoPlugin']['geoplugin_countryName'],
			$this->nemo['getGeoPlugin']['geoplugin_inEU'],
			$this->nemo['getGeoPlugin']['geoplugin_euVATrate'],
			$this->nemo['getGeoPlugin']['geoplugin_continentCode'],
			$this->nemo['getGeoPlugin']['geoplugin_continentName'],
			$this->nemo['getGeoPlugin']['geoplugin_latitude'],
			$this->nemo['getGeoPlugin']['geoplugin_longitude'],
			$this->nemo['getGeoPlugin']['geoplugin_locationAccuracyRadius'],
			$this->nemo['getGeoPlugin']['geoplugin_timezone'],
			$this->nemo['getGeoPlugin']['geoplugin_currencyCode'],
			$this->nemo['getGeoPlugin']['geoplugin_currencySymbol'],
			$this->nemo['getGeoPlugin']['geoplugin_currencySymbol_UTF8'],
			$this->nemo['getGeoPlugin']['geoplugin_currencyConverter']
		);
		return $row_id;
	}
	private function set_nemo(){
		// figure out what I want to keep for reference..
		$_SESSION['Nemo'][] = [
			'arrived'				=> $this->nemo['arrived'],
			'http_host'			=> $this->nemo['http_host'],
				'ip'					=> $this->nemo['ip'],	//========\\  ! this is the default ip
				'client_ip'		=> $this->nemo['client_ip'],#==== They can all be the viewers IP
				'x_forwarded'	=> $this->nemo['x_forwarded'],#=//	! and this can be a proxy
			'http_ref'			=> $this->nemo['http_ref'],
			'request_uri'		=> $this->nemo['request_uri'],
			'user_agent'		=> $this->nemo['user_agent'],
		];
		//	'POST' 				=> json_encode($this->nemo['POST']),
			//	'GET' 				=> json_encode($this->nemo['GET']),
			//	'IpInfo' => [
			//		'hostname' 	=> $this->nemo['getIpInfo']['hostname'],											// => syn-076-036-023-039.res.spectrum.com
			//    'city' 			=> $this->nemo['getIpInfo']['city'], 													// => Charlotte
			//    'region' 		=> $this->nemo['getIpInfo']['region'], 												// => North Carolina
			//    'country' 	=> $this->nemo['getIpInfo']['country'], 											// => US
			//    'loc' 			=> $this->nemo['getIpInfo']['loc'], 													// => 35.3183,-80.7476
			//    'org' 			=> $this->nemo['getIpInfo']['org'], 													// => AS11426 Charter Communications Inc
			//    'postal' 		=> $this->nemo['getIpInfo']['postal'], 												// => 28262
			//    'timezone' 	=> $this->nemo['getIpInfo']['timezone'], 											// => America/New_York
			//	],
			//	'GeoPlugin'	=> [
			//		'request' 			=> $this->nemo['getGeoPlugin']['geoplugin_request'], 			// => 76.36.23.39
			//		'status' 				=> $this->nemo['getGeoPlugin']['geoplugin_status'],				// => 200
			//		'delay' 				=> $this->nemo['getGeoPlugin']['geoplugin_delay'], 				// => 1ms
			//		'credit' 				=> $this->nemo['getGeoPlugin']['geoplugin_credit'], 			// => Some of the returned data includes GeoLite2 data created by MaxMind, available from https://www.maxmind.com.
			//		'city' 					=> $this->nemo['getGeoPlugin']['geoplugin_city'], 				// => Charlotte
			//		'region' 				=> $this->nemo['getGeoPlugin']['geoplugin_region'], 			// => North Carolina
			//		'regionCode'		=> $this->nemo['getGeoPlugin']['geoplugin_regionCode'], 	// => NC
			//		'regionName'		=> $this->nemo['getGeoPlugin']['geoplugin_regionName'], 	// => North Carolina
			//		'areaCode' 			=> $this->nemo['getGeoPlugin']['geoplugin_areaCode'], 		// =>
			//		'dmaCode' 			=> $this->nemo['getGeoPlugin']['geoplugin_dmaCode'], 			// => 517
			//		'countryCode'		=> $this->nemo['getGeoPlugin']['geoplugin_countryCode'], 	// => US
			//		'countryName'		=> $this->nemo['getGeoPlugin']['geoplugin_countryName'], 	// => United States
			//		'inEU' 					=> $this->nemo['getGeoPlugin']['geoplugin_inEU'], 				// => 0
			//		'euVATrate' 		=> $this->nemo['getGeoPlugin']['geoplugin_euVATrate'], 		// =>
			//		'continentCode' => $this->nemo['getGeoPlugin']['geoplugin_continentCode'],// => NA
			//		'continentName' => $this->nemo['getGeoPlugin']['geoplugin_continentName'],// => North America
			//		'latitude' 			=> $this->nemo['getGeoPlugin']['geoplugin_latitude'], 		// => 35.2842
			//		'longitude' 		=> $this->nemo['getGeoPlugin']['geoplugin_longitude'], 		// => -80.8719
			//		'locationAccuracyRadius' => $this->nemo['getGeoPlugin']['geoplugin_locationAccuracyRadius'], // => 10
			//		'timezone' 						=> $this->nemo['getGeoPlugin']['geoplugin_timezone'], 						// => America/New_York
			//		'currencyCode' 				=> $this->nemo['getGeoPlugin']['geoplugin_currencyCode'], 				// => USD
			//		'currencySymbol' 			=> $this->nemo['getGeoPlugin']['geoplugin_currencySymbol'], 			// => $
			//		'currencySymbol_UTF8' => $this->nemo['getGeoPlugin']['geoplugin_currencySymbol_UTF8'], 	// => $
			//		'currencyConverter' 	=> $this->nemo['getGeoPlugin']['geoplugin_currencyConverter'], 		// => 0
			//	]
		return $this;
	}

	/*
	[getGeoPlugin] => Array
        (
            [geoplugin_request] => 76.36.23.39
            [geoplugin_status] => 200
            [geoplugin_delay] => 1ms
            [geoplugin_credit] => Some of the returned data includes GeoLite2 data created by MaxMind, available from https://www.maxmind.com.
            [geoplugin_city] => Charlotte
            [geoplugin_region] => North Carolina
            [geoplugin_regionCode] => NC
            [geoplugin_regionName] => North Carolina
            [geoplugin_areaCode] =>
            [geoplugin_dmaCode] => 517
            [geoplugin_countryCode] => US
            [geoplugin_countryName] => United States
            [geoplugin_inEU] => 0
            [geoplugin_euVATrate] =>
            [geoplugin_continentCode] => NA
            [geoplugin_continentName] => North America
            [geoplugin_latitude] => 35.2842
            [geoplugin_longitude] => -80.8719
            [geoplugin_locationAccuracyRadius] => 10
            [geoplugin_timezone] => America/New_York
            [geoplugin_currencyCode] => USD
            [geoplugin_currencySymbol] => $
            [geoplugin_currencySymbol_UTF8] => $
            [geoplugin_currencyConverter] => 0
        )
	*/
	private function getGeoPlugin() {
		return unserialize(file_get_contents($this->geoPluginUrl));
	}

	/*
	[getIpInfo] => Array
        (
            [ip] => 76.36.23.39
            [hostname] => syn-076-036-023-039.res.spectrum.com
            [city] => Charlotte
            [region] => North Carolina
            [country] => US
            [loc] => 35.3183,-80.7476
            [org] => AS11426 Charter Communications Inc
            [postal] => 28262
            [timezone] => America/New_York
        )
	*/
	private function getIpInfo() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->ipInfoUrl);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($response, true);
		return $result;
	}
}