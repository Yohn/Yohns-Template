<?php

namespace Yohns\Security\FindingNemo;

use PDO;
use PDOChainer\DBAL;

class NemosGeoData_SQL {

	protected $db;
	private   $DBAL;

	public function __construct(DBAL $DBAL) {
		$this->db = '`usersgeodata`';
		$this->DBAL = $DBAL;
	}

	/**
	 * Adding Nemo to the table..
	 *
	 * @param [type] $user_id
	 * @param [type] $arrived
	 * @param [type] $http_host
	 * @param [type] $ip
	 * @param [type] $http_ref
	 * @param [type] $request_uri
	 * @param [type] $user_agent
	 * @param [type] $post_header
	 * @param [type] $get_header
	 * @param [type] $ipinfo_hostname
	 * @param [type] $ipinfo_city
	 * @param [type] $ipinfo_region
	 * @param [type] $ipinfo_country
	 * @param [type] $ipinfo_loc
	 * @param [type] $ipinfo_org
	 * @param [type] $ipinfo_postal
	 * @param [type] $ipinfo_timezone
	 * @param [type] $geoplugin_status
	 * @param [type] $geoplugin_delay
	 * @param [type] $geoplugin_credit
	 * @param [type] $geoplugin_city
	 * @param [type] $geoplugin_region
	 * @param [type] $geoplugin_regionCode
	 * @param [type] $geoplugin_regionName
	 * @param [type] $geoplugin_areaCode
	 * @param [type] $geoplugin_dmaCode
	 * @param [type] $geoplugin_countryCode
	 * @param [type] $geoplugin_countryName
	 * @param [type] $geoplugin_inEU
	 * @param [type] $geoplugin_euVATrate
	 * @param [type] $geoplugin_continentCode
	 * @param [type] $geoplugin_continentName
	 * @param [type] $geoplugin_latitude
	 * @param [type] $geoplugin_longitude
	 * @param [type] $geoplugin_locationAccuracyRadius
	 * @param [type] $geoplugin_timezone
	 * @param [type] $geoplugin_currencyCode
	 * @param [type] $geoplugin_currencySymbol
	 * @param [type] $geoplugin_currencySymbol_UTF8
	 * @param [type] $geoplugin_currencyConverter
	 * @return int
	 */
	public function add_row($user_id, $arrived, $http_host, $ip, $http_ref, $request_uri, $user_agent, $post_header, $get_header, $ipinfo_hostname, $ipinfo_city, $ipinfo_region, $ipinfo_country, $ipinfo_loc, $ipinfo_org, $ipinfo_postal, $ipinfo_timezone, $geoplugin_status, $geoplugin_delay, $geoplugin_credit, $geoplugin_city, $geoplugin_region, $geoplugin_regionCode, $geoplugin_regionName, $geoplugin_areaCode, $geoplugin_dmaCode, $geoplugin_countryCode, $geoplugin_countryName, $geoplugin_inEU, $geoplugin_euVATrate, $geoplugin_continentCode, $geoplugin_continentName, $geoplugin_latitude, $geoplugin_longitude, $geoplugin_locationAccuracyRadius, $geoplugin_timezone, $geoplugin_currencyCode, $geoplugin_currencySymbol, $geoplugin_currencySymbol_UTF8, $geoplugin_currencyConverter) {
		$new_id = $this->DBAL->insert($this->db, [
			['user_id', 				$user_id, 				PDO::PARAM_INT],
			['arrived', 				$arrived, 				PDO::PARAM_STR],
			['http_host', 			$http_host, 			PDO::PARAM_STR],
			['ip', 							$ip, 							PDO::PARAM_STR],
			['http_ref', 				$http_ref, 				PDO::PARAM_STR],
			['request_uri', 		$request_uri, 		PDO::PARAM_STR],
			['user_agent', 			$user_agent, 			PDO::PARAM_STR],
			['post_header', 		$post_header, 		PDO::PARAM_STR],
			['get_header', 			$get_header, 			PDO::PARAM_STR],
			['ipinfo_hostname', $ipinfo_hostname,	PDO::PARAM_STR],
			['ipinfo_city', 		$ipinfo_city, 		PDO::PARAM_STR],
			['ipinfo_region', 	$ipinfo_region, 	PDO::PARAM_STR],
			['ipinfo_country',	$ipinfo_country,	PDO::PARAM_STR],
			['ipinfo_loc', 			$ipinfo_loc, 			PDO::PARAM_STR],
			['ipinfo_org', 			$ipinfo_org, 			PDO::PARAM_STR],
			['ipinfo_postal', 	$ipinfo_postal, 	PDO::PARAM_INT],
			['ipinfo_timezone', 			$ipinfo_timezone, 					PDO::PARAM_STR],
			['geoplugin_status', 			$geoplugin_status, 					PDO::PARAM_INT],
			['geoplugin_delay', 			$geoplugin_delay, 					PDO::PARAM_STR],
			['geoplugin_credit', 			$geoplugin_credit, 					PDO::PARAM_STR],
			['geoplugin_city', 				$geoplugin_city, 						PDO::PARAM_STR],
			['geoplugin_region', 			$geoplugin_region, 					PDO::PARAM_STR],
			['geoplugin_regionCode', 	$geoplugin_regionCode, 			PDO::PARAM_STR],
			['geoplugin_regionName', 	$geoplugin_regionName, 			PDO::PARAM_STR],
			['geoplugin_areaCode', 		$geoplugin_areaCode, 				PDO::PARAM_STR],
			['geoplugin_dmaCode', 		$geoplugin_dmaCode, 				PDO::PARAM_INT],
			['geoplugin_countryCode', $geoplugin_countryCode, 		PDO::PARAM_STR],
			['geoplugin_countryName', $geoplugin_countryName, 		PDO::PARAM_STR],
			['geoplugin_inEU', 				$geoplugin_inEU, 						PDO::PARAM_STR],
			['geoplugin_euVATrate', 	$geoplugin_euVATrate, 			PDO::PARAM_STR],
			['geoplugin_continentCode', $geoplugin_continentCode, PDO::PARAM_STR],
			['geoplugin_continentName', $geoplugin_continentName, PDO::PARAM_STR],
			['geoplugin_latitude', 			$geoplugin_latitude, 			PDO::PARAM_STR],
			['geoplugin_longitude', 		$geoplugin_longitude, 		PDO::PARAM_STR],
			['geoplugin_locationAccuracyRadius', $geoplugin_locationAccuracyRadius, PDO::PARAM_STR],
			['geoplugin_timezone', 						$geoplugin_timezone, 									PDO::PARAM_STR],
			['geoplugin_currencyCode', 				$geoplugin_currencyCode, 							PDO::PARAM_STR],
			['geoplugin_currencySymbol', 			$geoplugin_currencySymbol, 						PDO::PARAM_STR],
			['geoplugin_currencySymbol_UTF8', $geoplugin_currencySymbol_UTF8, 			PDO::PARAM_STR],
			['geoplugin_currencyConverter', 	$geoplugin_currencyConverter, 				PDO::PARAM_STR],
		]);
		return $new_id;
	}

	public function update($updateAry, $whereAry, $limit = 1) {
		foreach ($updateAry as $k => $v) {
			$set[] = [$k, $v];
		}
		foreach ($whereAry as $k => $v) {
			$where[] = [$k, $v];
		}
		$updated = $this->DBAL->update($this->db, $set, $where);
		return $updated;
	}

	// we remove them by id / primary key whichever that is on the table.
	public function remove($id) {
		return $this->DBAL->delete($this->db, [
			['id', $id]
		]);
	}

	public function browse_all($order='', $whereAry=[]) {
		if (is_array($whereAry)) {
			foreach ($whereAry as $k => $v) {
				$where[] = '`' . $k . '` = :' . $k . '';
				$binds[] = [':$k', $v];
			}
			if (isset($where)) {
				$where = ' WHERE ' . implode(" AND ", $where);
			} else {
				$where = '';
			}
		} else {
			$binds = '';
			$where = '';
		}
		if ($order != '') {
			$order = ' ORDER BY ' . $order . '';
		}
		$go = $this->DBAL->select("SELECT `id`, `user_id`, `arrived`, `http_host`, `ip`, `http_ref`, `request_uri`, `user_agent`, `post_header`, `get_header`, `ipinfo_hostname`, `ipinfo_city`, `ipinfo_region`, `ipinfo_country`, `ipinfo_loc`, `ipinfo_org`, `ipinfo_postal`, `ipinfo_timezone`, `geoplugin_status`, `geoplugin_delay`, `geoplugin_credit`, `geoplugin_city`, `geoplugin_region`, `geoplugin_regionCode`, `geoplugin_regionName`, `geoplugin_areaCode`, `geoplugin_dmaCode`, `geoplugin_countryCode`, `geoplugin_countryName`, `geoplugin_inEU`, `geoplugin_euVATrate`, `geoplugin_continentCode`, `geoplugin_continentName`, `geoplugin_latitude`, `geoplugin_longitude`, `geoplugin_locationAccuracyRadius`, `geoplugin_timezone`, `geoplugin_currencyCode`, `geoplugin_currencySymbol`, `geoplugin_currencySymbol_UTF8`, `geoplugin_currencyConverter`, `ins_time`
			FROM " . $this->db . "
			" . $where . $order, 10, $binds);
		return $go;
	}

	public function browse($pg, $tpp, $whereAry=[], $order='') {
		$pg = $pg > 0 ? $pg : 1;
		$offset = ($pg - 1) * $tpp;
		if (is_array($whereAry) && count($whereAry) > 0) {
			foreach ($whereAry as $k => $v) {
				$where[] = '`' . $k . '` = :' . $k . '';
				$binds[] = [':$k', $v];
			}
			if (isset($where)) {
				$where = ' WHERE ' . implode(" AND ", $where);
			} else {
				$where = '';
			}
		} else {
			$binds = '';
			$where = '';
		}
		if ($order != '') {
			$order = ' ORDER BY ' . $order . '';
		}
		$go = $this->DBAL->select("SELECT `id`, `user_id`, `arrived`, `http_host`, `ip`, `http_ref`, `request_uri`, `user_agent`, `post_header`, `get_header`, `ipinfo_hostname`, `ipinfo_city`, `ipinfo_region`, `ipinfo_country`, `ipinfo_loc`, `ipinfo_org`, `ipinfo_postal`, `ipinfo_timezone`, `geoplugin_status`, `geoplugin_delay`, `geoplugin_credit`, `geoplugin_city`, `geoplugin_region`, `geoplugin_regionCode`, `geoplugin_regionName`, `geoplugin_areaCode`, `geoplugin_dmaCode`, `geoplugin_countryCode`, `geoplugin_countryName`, `geoplugin_inEU`, `geoplugin_euVATrate`, `geoplugin_continentCode`, `geoplugin_continentName`, `geoplugin_latitude`, `geoplugin_longitude`, `geoplugin_locationAccuracyRadius`, `geoplugin_timezone`, `geoplugin_currencyCode`, `geoplugin_currencySymbol`, `geoplugin_currencySymbol_UTF8`, `geoplugin_currencyConverter`, `ins_time`
			FROM " . $this->db . "
			" . $where . $order . "
			LIMIT " . $offset . ", " . $tpp, 10, $binds);
		return $go;
	}

	public function select_by_id($id) {
		$binds[] = [':id', $id, PDO::PARAM_INT];
		$go = $this->DBAL->select("SELECT `id`, `user_id`, `arrived`, `http_host`, `ip`, `http_ref`, `request_uri`, `user_agent`, `post_header`, `get_header`, `ipinfo_hostname`, `ipinfo_city`, `ipinfo_region`, `ipinfo_country`, `ipinfo_loc`, `ipinfo_org`, `ipinfo_postal`, `ipinfo_timezone`, `geoplugin_status`, `geoplugin_delay`, `geoplugin_credit`, `geoplugin_city`, `geoplugin_region`, `geoplugin_regionCode`, `geoplugin_regionName`, `geoplugin_areaCode`, `geoplugin_dmaCode`, `geoplugin_countryCode`, `geoplugin_countryName`, `geoplugin_inEU`, `geoplugin_euVATrate`, `geoplugin_continentCode`, `geoplugin_continentName`, `geoplugin_latitude`, `geoplugin_longitude`, `geoplugin_locationAccuracyRadius`, `geoplugin_timezone`, `geoplugin_currencyCode`, `geoplugin_currencySymbol`, `geoplugin_currencySymbol_UTF8`, `geoplugin_currencyConverter`, `ins_time` FROM ".$this->db."
			WHERE `id` = :id LIMIT 1", 1, $binds);
		return $go;
	}

	public function select_by_user_id($id) {
		$binds[] = [':user_id', $id, PDO::PARAM_INT];
		$go = $this->DBAL->select("SELECT `id`, `user_id`, `arrived`, `http_host`, `ip`, `http_ref`, `request_uri`, `user_agent`, `post_header`, `get_header`, `ipinfo_hostname`, `ipinfo_city`, `ipinfo_region`, `ipinfo_country`, `ipinfo_loc`, `ipinfo_org`, `ipinfo_postal`, `ipinfo_timezone`, `geoplugin_status`, `geoplugin_delay`, `geoplugin_credit`, `geoplugin_city`, `geoplugin_region`, `geoplugin_regionCode`, `geoplugin_regionName`, `geoplugin_areaCode`, `geoplugin_dmaCode`, `geoplugin_countryCode`, `geoplugin_countryName`, `geoplugin_inEU`, `geoplugin_euVATrate`, `geoplugin_continentCode`, `geoplugin_continentName`, `geoplugin_latitude`, `geoplugin_longitude`, `geoplugin_locationAccuracyRadius`, `geoplugin_timezone`, `geoplugin_currencyCode`, `geoplugin_currencySymbol`, `geoplugin_currencySymbol_UTF8`, `geoplugin_currencyConverter`, `ins_time` FROM ".$this->db."
			WHERE `user_id` = :user_id ORDER BY `id` DESC", 10, $binds);
		return $go;
	}
}