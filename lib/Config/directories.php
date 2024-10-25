<?php
$ds = DIRECTORY_SEPARATOR;
return [
	'errors' 		=> dirname(__DIR__).$ds.'Errors',
	'logs' 			=> dirname(__DIR__).$ds.'Logs',
	'temp' 			=> dirname(__DIR__).$ds.'Temp',
	'templates' => dirname(__DIR__).$ds.'Templates',
	'Mailtemplates' => dirname(__DIR__).$ds.'Templates'.$ds.'Mail',
];