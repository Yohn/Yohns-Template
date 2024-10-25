# Yohns\Yohn  

Class Yohn

Main class for managing application resources and sessions.
```
-------------------------------------------------------------
!!   __   __             __                  ______         !
!!  /\ \  \ \           /\ \                /\  ___\        !
!!  \ \ \__\ \   ______ \ \ \  __    __  __ \ \ \_____      !
!!   \ \__  __\ /\  __ \ \ \ \/  \  /\ \/  \ \ \_____ \     !
!!    \/_/\ \_/ \ \ \_\ \ \ \  /\ \ \ \/ /\ \ '/,___/\ \    !
!!       \ \ \   \ \_____\ \ \_\ \ \ \ \ \ \ \ /\_______\   !
!!        \ \ \   \/_____/  \/_/  \/  \/_/ /_/ \/_______/   !
!!         \ \ \________________    _____________________   !
!!          \ \________________ \  / ____________________\  !
!!           \/___\-\_\-\_\/.__\ \/ /__\=_/-\_/\/\ | \_ \/  !
!!                              \__/                  !!/ \!!
-------------------------------------------------------------
```  





## Methods

| Name | Description |
|------|-------------|
|[__call](#yohn__call)|Handles method calls to registered classes dynamically.|
|[__callStatic](#yohn__callstatic)|Handles static method calls to registered classes dynamically.|
|[__construct](#yohn__construct)|Yohn constructor.|
|[__get](#yohn__get)|Magic getter method for properties.|
|[__isset](#yohn__isset)|Checks if a property is set.|
|[__set](#yohn__set)|Magic setter method for properties.|
|[__unset](#yohn__unset)|Unsets a property.|
|[checkHeader](#yohncheckheader)|Checks the HTTP headers for allowed referrers and handles potential unauthorized requests.|
|[register](#yohnregister)|Registers a new class.|




### Yohn::__call  

**Description**

```php
public __call (string $name, array $args)
```

Handles method calls to registered classes dynamically. 

 

**Parameters**

* `(string) $name`
: The name of the method to call.  
* `(array) $args`
: The arguments to pass to the method.  

**Return Values**

`mixed`

> Returns the result of the method call.


**Throws Exceptions**


`\Error`
> if the method is not found.

<hr />


### Yohn::__callStatic  

**Description**

```php
public static __callStatic (string $name, array $args)
```

Handles static method calls to registered classes dynamically. 

 

**Parameters**

* `(string) $name`
: The name of the static method to call.  
* `(array) $args`
: The arguments to pass to the method.  

**Return Values**

`void`


**Throws Exceptions**


`\Error`
> if the static method is not found.

<hr />


### Yohn::__construct  

**Description**

```php
public __construct (void)
```

Yohn constructor. 

Initializes configuration, sessions, error handling, and registers essential classes. 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### Yohn::__get  

**Description**

```php
public __get (string $name)
```

Magic getter method for properties. 

Retrieves the value of a property. 

**Parameters**

* `(string) $name`
: The name of the property.  

**Return Values**

`mixed|null`

> The value of the property or null if not set.


<hr />


### Yohn::__isset  

**Description**

```php
public __isset (string $name)
```

Checks if a property is set. 

 

**Parameters**

* `(string) $name`
: The name of the property.  

**Return Values**

`bool`

> Returns true if the property is set, false otherwise.


<hr />


### Yohn::__set  

**Description**

```php
public __set (string $name, mixed $value)
```

Magic setter method for properties. 

Registers the property as a class if it exists or sets it as a value. 

**Parameters**

* `(string) $name`
: The name of the property to set.  
* `(mixed) $value`
: The value to set the property to.  

**Return Values**

`bool`

> If the property is set successfully.


<hr />


### Yohn::__unset  

**Description**

```php
public __unset (string $name)
```

Unsets a property. 

 

**Parameters**

* `(string) $name`
: The name of the property to unset.  

**Return Values**

`void`


<hr />


### Yohn::checkHeader  

**Description**

```php
public checkHeader (void)
```

Checks the HTTP headers for allowed referrers and handles potential unauthorized requests. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`

> Returns true after checking the headers.


<hr />


### Yohn::register  

**Description**

```php
public register (mixed $name, mixed $constructor)
```

Registers a new class. 

 

**Parameters**

* `(mixed) $name`
: The name of the class to register.  
* `(mixed) $constructor`
: Optional constructor parameters for the class.  

**Return Values**

`bool`

> Returns true if registration is successful, false if already registered.


**Throws Exceptions**


`\Exception`
> if the name does not correspond to a valid class.

<hr />

