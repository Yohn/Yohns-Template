# Yohns\Errors\Err  

Custom error handling class that extends PHP's built-in RuntimeException.

This class is designed to represent an error that can be thrown
during the execution of the program.

```php
try {
	throw new Err("This is a custom error message.");
} catch (Err $e) {
	echo $e->getDetailedMessage();
}
```  

## Implements:
Throwable, Stringable

## Extend:

Exception

## Methods

| Name | Description |
|------|-------------|
|[getDetailedMessage](#errgetdetailedmessage)|Get a detailed error message that includes the file name, line number, and the error message itself.|

## Inherited methods

| Name | Description |
|------|-------------|
| [__construct](https://secure.php.net/manual/en/exception.__construct.php) | Construct the exception |
| [__toString](https://secure.php.net/manual/en/exception.__tostring.php) | String representation of the exception |
| [__wakeup](https://secure.php.net/manual/en/exception.__wakeup.php) | - |
| [getCode](https://secure.php.net/manual/en/exception.getcode.php) | Gets the Exception code |
| [getFile](https://secure.php.net/manual/en/exception.getfile.php) | Gets the file in which the exception was created |
| [getLine](https://secure.php.net/manual/en/exception.getline.php) | Gets the line in which the exception was created |
| [getMessage](https://secure.php.net/manual/en/exception.getmessage.php) | Gets the Exception message |
| [getPrevious](https://secure.php.net/manual/en/exception.getprevious.php) | Returns previous Exception |
| [getTrace](https://secure.php.net/manual/en/exception.gettrace.php) | Gets the stack trace |
| [getTraceAsString](https://secure.php.net/manual/en/exception.gettraceasstring.php) | Gets the stack trace as a string |



### Err::getDetailedMessage  

**Description**

```php
public getDetailedMessage (void)
```

Get a detailed error message that includes the file name, line number, and the error message itself. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> A formatted string containing the error details.


<hr />

