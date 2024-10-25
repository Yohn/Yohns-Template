<?php

namespace Yohns\Services;

use Yohns\Core\Config;
use JW3B\Helpful;

/**
 * Class E
 * This class handles error logging, displaying, and exception handling for PHP applications.
 * It provides methods to configure logging options and define custom error and exception handlers.
 *
 * ```php
 * // Initialize error handling with configuration options
 * E::initiate([
 * 	'log' => '/path/to/log/directory',  // Directory for error logs
 * 	'file' => '/path/to/log/file.log',  // Optionally, specify a log file
 * 	'store' => [
 * 		'_POST' => true,  // Capture and log POST data
 * 		'_FILES' => true,  // Capture and log FILES data
 * 		'_GET' => true,    // Capture and log GET data
 * 		'_COOKIE' => true, // Capture and log COOKIE data
 * 		'_SESSION' => true // Capture and log SESSION data
 * 	],
 * 	'display' => true  // Display errors on screen
 * ]);
 *
 * // Set custom error handler
 * set_error_handler([E::class, 'errHandler']);
 *
 * // Set custom exception handler
 * set_exception_handler([E::class, 'excHandler']);
 *
 * // Example: Trigger an error
 * trigger_error("This is a test warning!", E_USER_WARNING);
 *
 * // Example: Trigger an exception
 * throw new Exception("This is a test exception!");
 * ```
 */
class E {
	protected static $opened     = false;
	protected static $opts       = [];
	protected static $exceptions = [
		E_ERROR             => 'E_ERROR',							//1			Fatal
		E_WARNING           => 'E_WARNING',						//2			Run-time
		E_PARSE             => 'E_PARSE',							//4			Run-time
		E_NOTICE            => 'E_NOTICE',						//8			Run-time
		E_CORE_ERROR        => 'E_CORE_ERROR', 				//16		Fatal
		E_CORE_WARNING      => 'E_CORE_WARNING', 			//32		Warning
		E_COMPILE_ERROR     => 'E_COMPILE_ERROR', 		//64		Fatal
		E_COMPILE_WARNING   => 'E_COMPILE_WARNING', 	//128		Compile-time
		E_USER_ERROR        => 'E_USER_ERROR', 				//256		User-generated
		E_USER_WARNING      => 'E_USER_WARNING', 			//512		User-generated
		E_USER_NOTICE       => 'E_USER_NOTICE', 			//1024	User-generated
		E_STRICT            => 'E_STRICT', 						//2048	PHP tell us how to code
		E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',	//4096	Catchable
		E_DEPRECATED        => 'E_DEPRECATED', 				//8192	Run-time
		E_USER_DEPRECATED   => 'E_USER_DEPRECATED', 	//16384	User-generated
		E_ALL               => 'E_ALL' 								//3767
	];

	private function __construct() {
		// Prevent instantiation of the class.
	}

	/**
	 * Initializes the error logging options.
	 *
	 * ```php
	 * $opts = [
	 *	'dir' => (string) $over['log'] ?? __DIR__.'/errors.log',
	 *	'file' => (string|false) $over['file'] ?? false,
	 *	'store' => (array) ['_POST', '_FILES', '_GET', '_COOKIE', '_SESSION'],
	 *	'display' => (bool) true // default to display the errors
	 *	]
	 * ````
	 *
	 * @param array $over Configuration options for error logging.
	 */
	public static function initiate($over = []): void {
		//$over
		self::$opts = [
			'dir'     => $over['log'] ?? Config::get('error_dir', 'directories'), //, 'c'),
			'file'    => $over['file'] ?? false,
			'store'   => [
				'_POST'    => $over['store']['_POST'] ?? true,
				'_FILES'   => $over['store']['_FILES'] ?? true,
				'_GET'     => $over['store']['_GET'] ?? true,
				'_COOKIE'  => $over['store']['_COOKIE'] ?? false,
				'_SESSION' => $over['store']['_SESSION'] ?? false,
			],
			'display' => true
		];
		// Optionally set error log file if provided.
		// ini_set('error_log', self::$opts['file']);
	}

	/**
	 * Custom error handler for logging errors.
	 *
	 * @param int $errno The level of the error raised.
	 * @param string $errstr The error message.
	 * @param string $errfile The filename where the error occurred.
	 * @param int $errline The line number where the error occurred.
	 * @return bool Returns true to prevent the PHP internal error handler from being called.
	 */
	public static function errHandler(int $errno, string $errstr, string $errfile, int $errline): bool {
		//if (!error_reporting()) {
		$mixed = self::mapErrorCode($errno);
		$message = $mixed['type'] . ': ' . $errstr;

		$log = 'Yohns Error: ' . PHP_EOL
			. $message . PHP_EOL
			. 'File: ' . self::displayFilePath($errfile) . PHP_EOL
			. 'Line #:' . $errline;
		self::log($log, $mixed['type']);
		if (self::$opts['display'] == true) {
			self::display($log, $mixed['type']);
		}
		return true;
	}

	/**
	 * Custom exception handler for logging exceptions.
	 *
	 * @param \Throwable $exception The thrown exception to handle.
	 * @return bool Return false to indicate the exception has been handled.
	 */
	public static function excHandler(\Throwable $exception): bool {
		$log = 'Yohns Fatal Error: ' . PHP_EOL
			. $exception->getMessage() . PHP_EOL
			. 'File: ' . self::displayFilePath($exception->getFile()) . PHP_EOL
			. 'Line: ' . $exception->getLine(); // . PHP_EOL
		//. self::displayFilePath($exception->getTraceAsString());
		self::display($log, 'Fatal');
		self::log($log, 'Fatal');
		//echo 'Yohns Exception - ' . $log;
		//self::log('Yohns Error: ' . $errno . ' - ' . $errstr . ' - ' . $errfile . ' - ' . $errline, $message);

		return false;
	}

	/**
	 * Displays an error message to the user.
	 *
	 * @param string $msg The message to display.
	 * @param string $type The type of error (e.g., 'Fatal').
	 * @return void
	 */
	public static function display(string $msg,string $type): void {
		if ($type == 'Fatal' && self::$opened === false) {
			echo '<html data-bs-theme="dark"><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></head><body>';
			self::$opened = true;
		}
		echo '<pre class="alert alert-danger m-5 w-75 mx-auto">' . $msg . '</pre>';
	}

	/**
	 * Formats and returns the file path for display.
	 *
	 * @param string $path The file path to format.
	 * @return string The formatted file path.
	 */
	public static function displayFilePath(string $path): string {
		return str_replace($_SERVER['DOCUMENT_ROOT'], '', $path);
	}

	/**
	 * Logs error details to a file.
	 *
	 * @param string $notes The notes to log.
	 * @param string $type The type of error (default: 'basic').
	 * @return bool Returns true if logging is successful.
	 */
	public static function log(string $notes, string $type = 'basic'): bool {
		$parts = explode('|', $type);
		if (count($parts) > 1) {
			$type = $parts[0];
			$shifted = array_shift($parts);
			$name = is_array($shifted) ? implode('.', $shifted) : implode('.', $parts);
		} else {
			$name = $type;
		}
		$name .= '-' . date('Y-m-d') . '-at-' . date('g-i-sA');
		$dir = self::$opts['dir'] . '/' . $type . '/';
		if (!is_dir($dir))
			mkdir($dir, 0777, true);
		$file = $dir . Str::clean_url($name) . '.dat';
		$debug = print_r(debug_backtrace(), true);
		$lastError = print_r(error_get_last(), true);
		$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct input';
		$gg = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
		$rs = isset($_SERVER['REDIRECT_STATUS']) ? $_SERVER['REDIRECT_STATUS'] : '';
		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

		$P = self::$opts['store']['_POST'] == true ? '_POST = ' . print_r($_POST, 1) : '_POST off';
		$F = self::$opts['store']['_FILES'] == true ? '_FILES = ' . print_r($_FILES, 1) : '_FILES off';
		$G = self::$opts['store']['_GET'] == true ? '_GET = ' . print_r($_GET, 1) : '_GET off';
		$C = self::$opts['store']['_COOKIE'] == true ? '_COOKIE = ' . print_r($_COOKIE, 1) : '_COOKIE off';
		if (self::$opts['store']['_SESSION'] == true && isset($_SESSION)) {
			$S = '_SESSION = ' . print_r($_SESSION, 1);
		} else if (isset($_SESSION)) {
			$SU = $_SESSION['Uid'] ?? 'not signed in';
			$SN = $_SESSION['Uname'] ?? 'not signed in';
			$S = '_SESSION off =
					User ID = ' . $SU . '
 					Uname = ' . $SN;
		} else {
			$S = '';
		}
		$putIn = '[' . date('F j Y @ g:i:s A', time()) . ']
		' . $notes . '

		REQUEST_URI = ' . $_SERVER['REQUEST_URI'] . '
		SCRIPT_NAME = ' . $_SERVER['SCRIPT_NAME'] . '
		PHP_SELF = ' . $_SERVER['PHP_SELF'] . '
		REDIRECT_STATUS = ' . $rs . '
		IP = ' . $ip . '
		HTTP_USER_AGENT = ' . $_SERVER['HTTP_USER_AGENT'] . '
		HTTP_REFERER = ' . $ref . '
		QUERY_STRING = ' . $gg . '
		Last Error = ' . $lastError . '

		' . $P . '
		' . $F . '
		' . $G . '
		' . $C . '
		' . $S . '

		debug_backtrace = ' . $debug;

		if ($file != null && $file != '') {
			$gotten = is_file($file);
		} else {
			$gotten = ''; // file_get_contents($file);
		}
		//	$fp = fopen($file, 'w');
		$fp = fopen($file, 'a');
		flock($fp, LOCK_EX);
		fwrite($fp, $putIn . "\n" . $gotten);
		flock($fp, LOCK_UN);
		fclose($fp);
		return true;
	}


	/**
	 * Map an error code into an Error word, and log location.
	 *
	 * @param int $code Error code to map
	 * @return array Array of error word, and log location.
	 */
	public static function mapErrorCode(int $code): array {
		$error = null;
		switch ($code) {
			case E_PARSE:
			case E_ERROR:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_USER_ERROR:
				$error = 'Fatal';
				break;
			case E_WARNING:
			case E_USER_WARNING:
			case E_COMPILE_WARNING:
			case E_RECOVERABLE_ERROR:
				$error = 'Warning';
				break;
			case E_NOTICE:
			case E_USER_NOTICE:
				$error = 'Notice';
				break;
			case E_STRICT:
				$error = 'Strict';
				break;
			case E_DEPRECATED:
			case E_USER_DEPRECATED:
				$error = 'Deprecated';
				break;
			default:
				$error = 'Custom';
				break;
		}
		return ['error' => self::$exceptions[$code] ?? 'Custom', 'type' => $error];
	}
}