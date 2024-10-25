# Yohns\Utils\Plugable  

Class Plugable

Handles loading, activating, and managing plugins and their corresponding hooks and filters.  





## Methods

| Name | Description |
|------|-------------|
|[addFilter](#plugableaddfilter)|Adds a filter for an event.|
|[addHook](#plugableaddhook)|Adds a new hook event with a corresponding function.|
|[addHooks](#plugableaddhooks)|Adds multiple hooks to their respective events.|
|[doFilter](#plugabledofilter)|Applies a filter to a specific event.|
|[doHook](#plugabledohook)|Executes all functions attached to a specific event hook.|
|[loadPlugins](#plugableloadplugins)|Loads plugins from the specified directory.|
|[removeHook](#plugableremovehook)|Removes a function from an event hook.|




### Plugable::addFilter  

**Description**

```php
public static addFilter (string $event, mixed $array)
```

Adds a filter for an event. 

this activates the filter.. 

**Parameters**

* `(string) $event`
: Name of the event to filter.  
* `(mixed) $array`
: The filter data to be associated with the event.  

**Return Values**

`void`


<hr />


### Plugable::addHook  

**Description**

```php
public static addHook (string $event, callable $func)
```

Adds a new hook event with a corresponding function. 

 

**Parameters**

* `(string) $event`
: Name of the event to hook.  
* `(callable) $func`
: The function to be called when the event is triggered.  

**Return Values**

`void`


<hr />


### Plugable::addHooks  

**Description**

```php
public static addHooks (array $hooks)
```

Adds multiple hooks to their respective events. 

 

**Parameters**

* `(array) $hooks`
: Associative array of event names and their corresponding functions.  

**Return Values**

`void`


<hr />


### Plugable::doFilter  

**Description**

```php
public static doFilter (string $event, callable $func)
```

Applies a filter to a specific event. 

 

**Parameters**

* `(string) $event`
: Name of the event to apply the filter on.  
* `(callable) $func`
: The filter function that modifies the data.  

**Return Values**

`mixed`

> Returns the result of the filter function, or an empty string if not found.


<hr />


### Plugable::doHook  

**Description**

```php
public static doHook (void)
```

Executes all functions attached to a specific event hook. 

this activates the hook.. 

**Parameters**

`This function has no parameters.`

**Return Values**

`mixed`

> Returns the result of the callback function execution or null if no hooks are present.


**Throws Exceptions**


`\Exception`
> Throws an exception if a hooked function does not exist.

<hr />


### Plugable::loadPlugins  

**Description**

```php
public static loadPlugins (array $plugins)
```

Loads plugins from the specified directory. 

 

**Parameters**

* `(array) $plugins`
: Array of plugin names to load.  

**Return Values**

`array`

> Returns an associative array of loaded plugins with their configurations.


<hr />


### Plugable::removeHook  

**Description**

```php
public static removeHook (string $event, callable $func)
```

Removes a function from an event hook. 

 

**Parameters**

* `(string) $event`
: Name of the event from which the function should be removed.  
* `(callable) $func`
: The function to be removed from the event.  

**Return Values**

`void`


<hr />

