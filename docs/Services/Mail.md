# Yohns\Services\Mail  

Class Mail

This class is responsible for handling the composition and sending of emails.
It allows for setting various parameters such as the recipient, sender, reply-to address,
subject, message body, and more. The email can be sent in HTML format if specified.  





## Methods

| Name | Description |
|------|-------------|
|[__construct](#mail__construct)|Mail constructor.|
|[getBtnLink](#mailgetbtnlink)|Get the button link.|
|[getBtnText](#mailgetbtntext)|Get the button text.|
|[getDomain](#mailgetdomain)|Get the domain name.|
|[getFrom](#mailgetfrom)|Get the sender email address.|
|[getMsg](#mailgetmsg)|Get the message body of the email.|
|[getReplyTo](#mailgetreplyto)|Get the reply-to email address.|
|[getSubject](#mailgetsubject)|Get the subject of the email.|
|[getTemplate](#mailgettemplate)|Get the email template path.|
|[getTo](#mailgetto)|Get the recipient email address.|
|[getUnsubEmail](#mailgetunsubemail)|Get the unsubscribe email address.|
|[getUseHTML](#mailgetusehtml)|Get the flag indicating whether HTML is to be used.|
|[send](#mailsend)|Sends the email using the specified headers and template.|
|[setBtnLink](#mailsetbtnlink)|Set the button link.|
|[setBtnText](#mailsetbtntext)|Set the button text.|
|[setDomain](#mailsetdomain)|Set the domain name.|
|[setFrom](#mailsetfrom)|Set the sender email address.|
|[setMsg](#mailsetmsg)|Set the message body of the email.|
|[setReplyTo](#mailsetreplyto)|Set the reply-to email address.|
|[setSubject](#mailsetsubject)|Set the subject of the email.|
|[setTemplate](#mailsettemplate)|Set the email template path.|
|[setTo](#mailsetto)|Set the recipient email address.|
|[setUnsubEmail](#mailsetunsubemail)|Set the unsubscribe email address.|
|[setUseHTML](#mailsetusehtml)|Set the flag indicating whether to use HTML for the email body.|




### Mail::__construct  

**Description**

```php
public __construct (void)
```

Mail constructor. 

Initializes the Mail object and sets the template location based on the configuration. 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />


### Mail::getBtnLink  

**Description**

```php
public getBtnLink (void)
```

Get the button link. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The URL for the button link.


<hr />


### Mail::getBtnText  

**Description**

```php
public getBtnText (void)
```

Get the button text. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The text to display on the button.


<hr />


### Mail::getDomain  

**Description**

```php
public getDomain (void)
```

Get the domain name. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The domain name of the service.


<hr />


### Mail::getFrom  

**Description**

```php
public getFrom (void)
```

Get the sender email address. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The sender email address.


<hr />


### Mail::getMsg  

**Description**

```php
public getMsg (void)
```

Get the message body of the email. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The message body of the email.


<hr />


### Mail::getReplyTo  

**Description**

```php
public getReplyTo (void)
```

Get the reply-to email address. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The reply-to email address.


<hr />


### Mail::getSubject  

**Description**

```php
public getSubject (void)
```

Get the subject of the email. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The subject of the email.


<hr />


### Mail::getTemplate  

**Description**

```php
public getTemplate (void)
```

Get the email template path. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The path to the email template.


<hr />


### Mail::getTo  

**Description**

```php
public getTo (void)
```

Get the recipient email address. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The recipient email address.


<hr />


### Mail::getUnsubEmail  

**Description**

```php
public getUnsubEmail (void)
```

Get the unsubscribe email address. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`string`

> The unsubscribe email address.


<hr />


### Mail::getUseHTML  

**Description**

```php
public getUseHTML (void)
```

Get the flag indicating whether HTML is to be used. 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`

> True if HTML should be used, false otherwise.


<hr />


### Mail::send  

**Description**

```php
public send (void)
```

Sends the email using the specified headers and template. 

This method constructs the email headers based on the properties of this object.  
It reads the email template file, replaces placeholders with actual values,  
and sends the email using the mail() function. 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`

> Returns true on success, false on failure.


<hr />


### Mail::setBtnLink  

**Description**

```php
public setBtnLink (string $btnLink)
```

Set the button link. 

 

**Parameters**

* `(string) $btnLink`
: The URL for the button link.  

**Return Values**

`self`

> Returns the current Mail instance for method chaining.


<hr />


### Mail::setBtnText  

**Description**

```php
public setBtnText (string $btnText)
```

Set the button text. 

 

**Parameters**

* `(string) $btnText`
: The text to display on the button.  

**Return Values**

`self`

> Returns the current Mail instance for method chaining.


<hr />


### Mail::setDomain  

**Description**

```php
public setDomain (string $domain)
```

Set the domain name. 

 

**Parameters**

* `(string) $domain`
: The domain name of the service.  

**Return Values**

`self`

> Returns the current Mail instance for method chaining.


<hr />


### Mail::setFrom  

**Description**

```php
public setFrom (string $from)
```

Set the sender email address. 

 

**Parameters**

* `(string) $from`
: The sender email address.  
Mary <mary@example.com>  

**Return Values**

`self`

> Returns the current Mail instance for method chaining.


<hr />


### Mail::setMsg  

**Description**

```php
public setMsg (string $msg)
```

Set the message body of the email. 

 

**Parameters**

* `(string) $msg`
: The message body of the email.  

**Return Values**

`self`

> Returns the current Mail instance for method chaining.


<hr />


### Mail::setReplyTo  

**Description**

```php
public setReplyTo (string $replyTo)
```

Set the reply-to email address. 

 

**Parameters**

* `(string) $replyTo`
: The reply-to email address.  
Mary <mary@example.com>  

**Return Values**

`self`

> Returns the current Mail instance for method chaining.


<hr />


### Mail::setSubject  

**Description**

```php
public setSubject (string $subject)
```

Set the subject of the email. 

 

**Parameters**

* `(string) $subject`
: The subject of the email.  

**Return Values**

`self`

> Returns the current Mail instance for method chaining.


<hr />


### Mail::setTemplate  

**Description**

```php
public setTemplate (string $template)
```

Set the email template path. 

This method sets the path to the specified template file.  
If the template file does not exist, an exception is thrown. 

**Parameters**

* `(string) $template`
: The name of the template file without the extension.  

**Return Values**

`self`

> Returns the current Mail instance for method chaining.


**Throws Exceptions**


`\RuntimeException`
> if the specified template file is not found.

<hr />


### Mail::setTo  

**Description**

```php
public setTo (string $to)
```

Set the recipient email address. 

 

**Parameters**

* `(string) $to`
: The recipient email address.  

**Return Values**

`self`

> Returns the current Mail instance for method chaining.


<hr />


### Mail::setUnsubEmail  

**Description**

```php
public setUnsubEmail (string $unsubEmail)
```

Set the unsubscribe email address. 

 

**Parameters**

* `(string) $unsubEmail`
: The unsubscribe email address.  

**Return Values**

`self`

> Returns the current Mail instance for method chaining.


<hr />


### Mail::setUseHTML  

**Description**

```php
public setUseHTML (bool $useHTML)
```

Set the flag indicating whether to use HTML for the email body. 

 

**Parameters**

* `(bool) $useHTML`
: True to use HTML, false otherwise.  

**Return Values**

`self`

> Returns the current Mail instance for method chaining.


<hr />

