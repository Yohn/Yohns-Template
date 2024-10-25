<?php
namespace Yohns\Security\FindingNemo;

use Yohns\Core\Config;

class NemosCookie {
	public static function check($cookie_names = []) {
		if (!isset($ch) || empty($ch)) {
			$ch = Config::get('allowedCookies', 'nemo');
		}
		// check all cookies
		foreach ($_COOKIE as $k => $v) {
			if (!in_array($k, $ch)) {
				setcookie($k, '', [
					'expires'  => '-1',
					'path'     => '/',
					'domain'   => '.' . Config::get('domain'),
					'secure'   => true,
					'httponly' => true,
					'samesite' => 'Strict'
				]);
			}
		}
	}
}