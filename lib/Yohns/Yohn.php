<?php
namespace Yohns;

use Yohns\Security\FindingNemo\FindingNemo;
use Yohns\E;
use PDOChainer\{DBAL, PDOChainer};
use JW3B\core\{Config, Error, Plugable};
use JW3B\Helpful\Str;

/**
 * Class Yohn
 *
 * Main class for managing application resources and sessions.
 *  ```
 *  -------------------------------------------------------------
 *  !!   __   __             __                  ______         !
 *  !!  /\ \  \ \           /\ \                /\  ___\        !
 *  !!  \ \ \__\ \   ______ \ \ \  __    __  __ \ \ \_____      !
 *  !!   \ \__  __\ /\  __ \ \ \ \/  \  /\ \/  \ \ \_____ \     !
 *  !!    \/_/\ \_/ \ \ \_\ \ \ \  /\ \ \ \/ /\ \ '/,___/\ \    !
 *  !!       \ \ \   \ \_____\ \ \_\ \ \ \ \ \ \ \ /\_______\   !
 *  !!        \ \ \   \/_____/  \/_/  \/  \/_/ /_/ \/_______/   !
 *  !!         \ \ \________________    _____________________   !
 *  !!          \ \________________ \  / ____________________\  !
 *  !!           \/___\-\_\-\_\/.__\ \/ /__\=_/-\_/\/\ | \_ \/  !
 *  !!                              \__/                  !!/ \!!
 *  -------------------------------------------------------------
 *  ```
 */
class Yohn {
	public $DBAL;							// Database Access Layer instance
	public $Config;						// Configuration instance
	protected $Footer;				// Footer instance for rendering templates
	protected $Template;			// Template handler
	protected $config_dir;		// Directory for configuration files
	protected $PDOChainer;		// PDOChainer instance for handling database operations
	protected $config_file;		// Configuration file name
	protected $allowed_domains = [];	// Allowed domains for CORS
	private $data = [];						// Storage for registered classes and data
	private static $cls = [];			// Static storage for class instances
	private $ClassRegisters = [];	// Registered classes

	/**
	 * Yohn constructor.
	 * Initializes configuration, sessions, error handling, and registers essential classes.
	 */
	public function __construct() {
		$this->config_dir = __DIR__ . '/../../config';
		$this->Config = new Config($this->config_dir);
		$this->PDOChainer = new PDOChainer(include $this->config_dir . '/db.php');
		$this->DBAL = new DBAL($this->PDOChainer);

		$this->sessions();

		E::initiate();
		//self::$class = new \stdClass();
		set_error_handler('Yohns\E::errHandler');
		set_exception_handler('Yohns\E::excHandler');

		$this->register('JW3B\gui\Template');
		$this->register('JW3B\core\Plugable');

		$this->checkHeader();
	}

	/**
	 * Initializes session handling.
	 * Sets configurations such as session name and lifetime.
	 *
	 * @return bool Returns true on successful session initialization.
	 */
	private function sessions(): bool {
		session_name(Config::get('SessionName'));
		ini_set('session.gc_maxlifetime', Config::get('expireTime'));
		ini_set('session.cookie_domain', '.' . Config::get('domain'));
		session_set_cookie_params(Config::get('expireTime'), '/', '.' . Config::get('domain'), true);
		session_start();
		return true;
	}

	/**
	 * Checks the HTTP headers for allowed referrers
	 * and handles potential unauthorized requests.
	 *
	 * @return bool Returns true after checking the headers.
	 */
	public function checkHeader(): bool {
		if ((isset($_POST) && is_array($_POST) && count($_POST) > 0)
			|| (isset($_FILES) && is_array($_FILES) && count($_FILES) > 0)) {
			// load allowed domains config
			$this->allowed_domains = include $this->config_dir . '/allowedDomainCors.php';
			// maybe allow IP address's later..
			$http_ref = $_SERVER['HTTP_REFERER'] ?? '';
			$x_forwarded = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';
			if ($http_ref != '' && in_array($http_ref, $this->allowed_domains)) {
                // Referrer is allowed
			} else if ($x_forwarded != '' && in_array($x_forwarded, $this->allowed_domains)) {
                // X-Forwarded-For is allowed
			} else {
                // Handle unauthorized access
                // Track unauthorized access (optional)
				if (isset($_SESSION['Uid'])) {
					$add_to_msg = '<br> User is a logged in member.<br>
							' . $_SESSION['Uid'] . ' - ' . Str::clean($_SESSION['Uname']);
				}
				$FindingNemo = new FindingNemo($this->DBAL);
				//throw new \ErrorException('Yohns Yohn class had some fun
				//in the top dealing with form posting and referrals..');
				//Error::e('Invalid Domain Name Referrer.', 'security-possible-hack');
				//Header("Location: " . Config::$c['full_domain'] . '"error'");
			}
		}
		return true;
	}

	/**
	 * Registers a new class.
	 *
	 * @param mixed $name The name of the class to register.
	 * @param mixed $constructor Optional constructor parameters for the class.
	 * @return bool Returns true if registration is successful, false if already registered.
	 * @throws \Exception if the name does not correspond to a valid class.
	 */
	public function register($name, mixed $constructor = ''): bool {
		$short_name = $this->getShortName($name);
		if (array_key_exists($short_name, self::$cls)
			|| array_key_exists($short_name, $this->data)) {
			return false;
		} else if (class_exists($name)) {
			$this->data[$short_name] = new $name($constructor);
			//self::$short_name = $this->data[$short_name];
			$this->registered($short_name, $name);
			return true;
		} else {
			throw new \Exception('Register is only for classes to be registered.', E_USER_ERROR);
		}
	}

	/**
	 * Retrieves the short name from a fully qualified class name.
	 *
	 * @param string $name The fully qualified class name.
	 * @return string The short name of the class.
	 */
	private function getShortName($name): string {
		$p = explode('\\', $name);
		$t = count($p);
		$short_name = $p[$t - 1];
		return $short_name;
	}

	/**
	 * Registers a class name in the ClassRegisters array.
	 *
	 * @param string $name The name of the class.
	 * @param string $space The namespace of the class.
	 * @return self Returns the current instance for method chaining.
	 */
	private function registered($name, $space): self {
		$this->ClassRegisters[$name] = $space;
		return $this;
	}

	/**
	 * Handles method calls to registered classes dynamically.
	 *
	 * @param string $name The name of the method to call.
	 * @param array $args The arguments to pass to the method.
	 * @return mixed Returns the result of the method call.
	 * @throws \Error if the method is not found.
	 */
	public function __call($name, $args) {
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}
		throw new \Error('Let Yohn know if you saw this error..<br>'
			. '<big class="m-2 bg-danger text-black p-2">"Yohns\\Yohn->call->' . $name . '"</big> not set.<br> ' . print_r($args, 1), E_USER_WARNING);
	}

	/**
	 * Handles static method calls to registered classes dynamically.
	 *
	 * @param string $name The name of the static method to call.
	 * @param array $args The arguments to pass to the method.
	 * @throws \Error if the static method is not found.
	 */
	public static function __callStatic($name, $args) {
		throw new \Error('Let Yohn know if you saw this error.. '
			. '<big class="m-2 bg-danger text-black p-2">"Yohns\\Yohn->call ->static->' . $name . '"</big> ' . print_r($args, 1), E_USER_WARNING);
	}

	/**
	 * Magic setter method for properties.
	 *
	 * Registers the property as a class if it exists or sets it as a value.
	 *
	 * @param string $name The name of the property to set.
	 * @param mixed $value The value to set the property to.
	 * @return bool If the property is set successfully.
	 */
	public function __set($name, $value) {
		if (!array_key_exists($name, $this->data)) {
			if (class_exists($name)) {
				return $this->register($name, $value);
			} else {
				$this->data[$name] = $value;
				return true;
			}
		} else {
			return $this->data[$name];
		}
	}

	/**
	 * Magic getter method for properties.
	 *
	 * Retrieves the value of a property.
	 *
	 * @param string $name The name of the property.
	 * @return mixed|null The value of the property or null if not set.
	 */
	public function __get($name) {
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}
		$trace = debug_backtrace();
		trigger_error(
			'Undefined property via __get(): ' . $name .
			' in ' . $trace[0]['file'] .
			' on line ' . $trace[0]['line'],
			E_USER_NOTICE);
		return null;
	}

	/**
	 * Checks if a property is set.
	 *
	 * @param string $name The name of the property.
	 * @return bool Returns true if the property is set, false otherwise.
	 */
	public function __isset($name): bool {
		return isset($this->data[$name]) ?? false;
	}

	/**
	 * Unsets a property.
	 *
	 * @param string $name The name of the property to unset.
	 */
	public function __unset($name): void {
		if (isset($this->data[$name])) {
			unset($this->data[$name]);
			unset(self::$data[$name]);
		}
	}
}