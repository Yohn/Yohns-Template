<?php
/*
	Look, I want to put everything into plugins..
		to do this I need to activate and deactivate the plugins..
	I may need to do more research on this..
	$plugins = array(	'Events', 'News', 'Pictures');
	include('classes/Plugable.php');
	$Plugable = new Plugable;
	$Plugable->loadPlugins($Sets['website']['plugins'], $_SERVER['DOCUMENT_ROOT'].'/pluggable/plugins/');

	echo '<pre>';
	print_r($Plugable->events);
	echo '</pre>';
	$Plugable->doHook('startup');
*/

namespace Yohns\Utils;

use Yohns\Config;

/**
 * Class Plugable
 *
 * Handles loading, activating, and managing plugins and their corresponding hooks and filters.
 */
class Plugable {
	/**
	 * @var array Stores the registered hook events.
	 */
	public static $events;

	/**
	 * @var array Stores the registered filters.
	 */
	public static $filter;

	/**
	 * @var array Stores information about loaded plugins.
	 */
	public static $plugin;

	/**
	 * Loads plugins from the specified directory.
	 *
	 * @param array $plugins Array of plugin names to load.
	 * @return array Returns an associative array of loaded plugins with their configurations.
	 */
	public static function loadPlugins(array $plugins): array {
		$dir = Config::get('PluginDir');
		if (isset($plugins) && is_array($plugins)) {
			foreach ($plugins as $v) {
				if (is_file($dir . $v . '/config.json')) {
					self::$plugin[$v] = json_decode(file_get_contents($dir . $v . '/config.json'), 1);
				}
			}
		}
		return isset(self::$plugin) ? self::$plugin : '';
	}

	/**
	 * Adds a new hook event with a corresponding function.
	 *
	 * @param string $event Name of the event to hook.
	 * @param callable $func The function to be called when the event is triggered.
	 */
	public static function addHook(string $event,callable $func): void {
		self::$events[$event][] = $func;
	}

	/**
	 * Adds multiple hooks to their respective events.
	 *
	 * @param array $hooks Associative array of event names and their corresponding functions.
	 */
	public static function addHooks(array $hooks): void {
		if (is_array($hooks)) {
			foreach ($hooks as $ev => $func) {
				self::addHook($ev, $func);
			}
		}
	}

	/**
	 * Removes a function from an event hook.
	 *
	 * @param string $event Name of the event from which the function should be removed.
	 * @param callable $func The function to be removed from the event.
	 */
	public static function removeHook(string $event,callable $func): void {
		if (isset(self::$events[$event])) {
			if (in_array($func, self::$events[$event])) {
				$key = array_search($func, self::$events[$event]);
				if ($key !== false) {
					unset(self::$events[$event][$key]);
				}
			}
		}
	}

	/**
	 * Executes all functions attached to a specific event hook.
	 * this activates the hook..
	 * @return mixed Returns the result of the callback function execution or null if no hooks are present.
	 * @throws \Exception Throws an exception if a hooked function does not exist.
	 */
	public static function doHook(): mixed {
		//$num_args = func_num_args();
		$args = func_get_args();
		//if($num_args < 1)
		//	trigger_error("Insufficient arguments", E_USER_ERROR);
		//Hook name should always be first argument
		$hook_name = array_shift($args);
		// this does whatever hooks are attached to the $event
		if (isset(self::$events[$hook_name])) {
			foreach (self::$events[$hook_name] as $k => $v) {
				if (function_exists($v)) {
					//call_user_func($v);
					return $v($args);
				} else {
					throw new \Exception($v . ' function does not exist in plugable class for ' . $hook_name, 'plugable');
					//Error::e($v.' function does not exist in plugable class for '.$hook_name, 'plugable', true);
				}
			}
		} else {
			return null;
		}
	}

	/**
	 * Adds a filter for an event.
	 * this activates the filter..
	 *
	 * @param string $event Name of the event to filter.
	 * @param mixed $array The filter data to be associated with the event.
	 */
	public static function addFilter($event, $array): void {
		self::$filter[$event][] = $array;
	}

	/**
	 * Applies a filter to a specific event.
	 *
	 * @param string $event Name of the event to apply the filter on.
	 * @param callable $func The filter function that modifies the data.
	 * @return mixed Returns the result of the filter function, or an empty string if not found.
	 */
	public static function doFilter(string $event, callable $func): mixed {
		if (isset(self::$filter[$event]) && function_exists($func)) {
			return $func(self::$filter[$event]);
		} else {
			return '';
		}
	}
}