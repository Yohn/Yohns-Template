<?php
namespace Yohns\Utils;

class ajaxJson {
	/**
	 * An easy way to echo out a response in json format compatible with the mf-valid forms
	 *
	 * @param string $type = error || danger || success || ok
	 * @param string $msg = string to be displayed
	 * @param string|bool $redirect = url
	 * @param array $$add2Array = [key=>val] in json response
	 * @return string json_encode()
	 */
	public static function bluidJson($type, $msg, $redirect = false, $add2Array = []): string {
		$json['class'] = self::getClass($type);
		if ($redirect != false) {
			$json['redirect'] = $redirect;
		}
		$json['msg'] = $msg;
		$json['status'] = $type;
		if (count($add2Array) > 0) {
			$json = $json + $add2Array;
		}
		return json_encode($json);
	}

	public static function getClass($type): string {
		if (in_array($type, ['danger', 'error', 'fail', 'failed'])) {
			return 'alert alert-danger';
		}
		if (in_array($type, ['ok', 'succes'])) {
			return 'alert alert-success';
		}
		return 'alert alert-dark';
	}
}