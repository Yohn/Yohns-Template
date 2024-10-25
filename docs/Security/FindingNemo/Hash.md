# Yohns\Security\FindingNemo\Hash  

Class Hash

This class is responsible for handling the generation of secure tokens
for form submissions, as well as managing their validation and session
storage.  





## Methods

| Name | Description |
|------|-------------|
|[form](#hashform)|Generate a secure form token for a given form ID and store it in the session.|
|[getsal](#hashgetsal)|Get the current salt value. If not set, it retrieves a default salt from configuration.|
|[gettoke](#hashgettoke)|Get the current session key.|
|[setsalt](#hashsetsalt)|Set the salt value used for token generation.|
|[settoke](#hashsettoke)|Set the session key used for storing tokens.|
|[valid](#hashvalid)|Validates a submitted token against stored tokens for a given form ID.|




### Hash::form  

**Description**

```php
public form (string $form_id)
```

Generate a secure form token for a given form ID and store it in the session. 

 

**Parameters**

* `(string) $form_id`
: The unique identifier for the form.  

**Return Values**

`string`

> The generated token for the form.


<hr />


### Hash::getsal  

**Description**

```php
public getsal (void)
```

Get the current salt value. If not set, it retrieves a default salt from configuration. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The current salt value.


<hr />


### Hash::gettoke  

**Description**

```php
public gettoke (void)
```

Get the current session key. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The current session key.


<hr />


### Hash::setsalt  

**Description**

```php
public setsalt (string $sa)
```

Set the salt value used for token generation. 

 

**Parameters**

* `(string) $sa`
: The salt value to set.  

**Return Values**

`self`

> Returns the current instance for method chaining.


<hr />


### Hash::settoke  

**Description**

```php
public settoke (string $sa)
```

Set the session key used for storing tokens. 

 

**Parameters**

* `(string) $sa`
: The session key to set.  

**Return Values**

`self`

> Returns the current instance for method chaining.


<hr />


### Hash::valid  

**Description**

```php
public valid (string $form_id, string $post)
```

Validates a submitted token against stored tokens for a given form ID. 

 

**Parameters**

* `(string) $form_id`
: The unique identifier for the form.  
* `(string) $post`
: The token submitted via the form.  

**Return Values**

`bool`

> Returns true if the token is valid; otherwise false.


<hr />

