# Yohns\Services\E  

Class E
This class handles error logging, displaying, and exception handling for PHP applications.

It provides methods to configure logging options and define custom error and exception handlers.

```php
// Initialize error handling with configuration options
E::initiate([
	'log' => '/path/to/log/directory',  // Directory for error logs
	'file' => '/path/to/log/file.log',  // Optionally, specify a log file
	'store' => [
		'_POST' => true,  // Capture and log POST data
		'_FILES' => true,  // Capture and log FILES data
		'_GET' => true,    // Capture and log GET data
		'_COOKIE' => true, // Capture and log COOKIE data
		'_SESSION' => true // Capture and log SESSION data
	],
	'display' => true  // Display errors on screen
]);

// Set custom error handler
set_error_handler([E::class, 'errHandler']);

// Set custom exception handler
set_exception_handler([E::class, 'excHandler']);

// Example: Trigger an error
trigger_error("This is a test warning!", E_USER_WARNING);

// Example: Trigger an exception
throw new Exception("This is a test exception!");
```  





## Methods

| Name | Description |
|------|-------------|
|[display](#edisplay)|Displays an error message to the user.|
|[displayFilePath](#edisplayfilepath)|Formats and returns the file path for display.|
|[errHandler](#eerrhandler)|Custom error handler for logging errors.|
|[excHandler](#eexchandler)|Custom exception handler for logging exceptions.|
|[initiate](#einitiate)|Initializes the error logging options.|
|[log](#elog)|Logs error details to a file.|
|[mapErrorCode](#emaperrorcode)|Map an error code into an Error word, and log location.|




### E::display  

**Description**

```php
public static display (string $msg, string $type)
```

Displays an error message to the user. 

 

**Parameters**

* `(string) $msg`
: The message to display.  
* `(string) $type`
: The type of error (e.g., 'Fatal').  

**Return Values**

`void`




<hr />


### E::displayFilePath  

**Description**

```php
public static displayFilePath (string $path)
```

Formats and returns the file path for display. 

 

**Parameters**

* `(string) $path`
: The file path to format.  

**Return Values**

`string`

> The formatted file path.


<hr />


### E::errHandler  

**Description**

```php
public static errHandler (int $errno, string $errstr, string $errfile, int $errline)
```

Custom error handler for logging errors. 

 

**Parameters**

* `(int) $errno`
: The level of the error raised.  
* `(string) $errstr`
: The error message.  
* `(string) $errfile`
: The filename where the error occurred.  
* `(int) $errline`
: The line number where the error occurred.  

**Return Values**

`bool`

> Returns true to prevent the PHP internal error handler from being called.


<hr />


### E::excHandler  

**Description**

```php
public static excHandler (\Throwable $exception)
```

Custom exception handler for logging exceptions. 

 

**Parameters**

* `(\Throwable) $exception`
: The thrown exception to handle.  

**Return Values**

`bool`

> Return false to indicate the exception has been handled.


<hr />


### E::initiate  

**Description**

```php
public static initiate (array $over)
```

Initializes the error logging options. 

```php  
$opts = [  
'dir' => (string) $over['log'] ?? __DIR__.'/errors.log',  
'file' => (string|false) $over['file'] ?? false,  
'store' => (array) ['_POST', '_FILES', '_GET', '_COOKIE', '_SESSION'],  
'display' => (bool) true // default to display the errors  
]  
```` 

**Parameters**

* `(array) $over`
: Configuration options for error logging.  

**Return Values**

`void`


<hr />


### E::log  

**Description**

```php
public static log (string $notes, string $type)
```

Logs error details to a file. 

 

**Parameters**

* `(string) $notes`
: The notes to log.  
* `(string) $type`
: The type of error (default: 'basic').  

**Return Values**

`bool`

> Returns true if logging is successful.


<hr />


### E::mapErrorCode  

**Description**

```php
public static mapErrorCode (int $code)
```

Map an error code into an Error word, and log location. 

 

**Parameters**

* `(int) $code`
: Error code to map  

**Return Values**

`array`

> Array of error word, and log location.


<hr />

