<?php

use Yohns\Core\Config;

$ds = DIRECTORY_SEPARATOR;

$domain = Config::get('domain');
$mailTemps = Config::get('Mailtemplates', 'directories');

return [
	'dir' 				=> $mailTemps.$ds,
	'default' 		=> $mailTemps.$ds.'email.template.html',
	'from'				=> 'no-reply@'.$domain,
	'replyTo'			=> 'no-reply@'.$domain,
	'btnLink'			=> 'https://'.$domain.'/login',
	'btnText'			=> 'Login',
	'domain'			=> $domain,
	'unsubEmail'	=> 'unsusbscribe@'.$domain,
];