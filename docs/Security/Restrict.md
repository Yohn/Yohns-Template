# Yohns\Security\Restrict  

Class Restrict

This class provides methods to check and restrict the usage of disposable email addresses.
Disposable email addresses are often used for temporary purposes and might pose security risks.
https://github.com/disposable-email-domains/disposable-email-domains  





## Methods

| Name | Description |
|------|-------------|
|[check](#restrictcheck)|Checks if the provided email address belongs to a disposable email domain.|
|[isDisposableEmail](#restrictisdisposableemail)|Determines if an email address is disposable based on a blocklist.|




### Restrict::check  

**Description**

```php
public static check (string $email)
```

Checks if the provided email address belongs to a disposable email domain. 

This method splits the email address into local and domain parts, then checks if the  
domain part is in the list of disposable email domains, which is sourced from  
a configuration file `disposable-emails.php`. 

**Parameters**

* `(string) $email`
: The email address to check for disposability.  

**Return Values**

`bool`

> Returns true if the email domain is disposable and should be blocked,  
otherwise returns false.


<hr />


### Restrict::isDisposableEmail  

**Description**

```php
public static isDisposableEmail (string $email, string|null $blocklist_path)
```

Determines if an email address is disposable based on a blocklist. 

This method retrieves disposable domains from a specified blocklist file or  
a default file if none is specified. It then checks if the domain of the given  
email address is within this list. 

**Parameters**

* `(string) $email`
: The email address to check for disposability.  
* `(string|null) $blocklist_path`
: Optional path to a custom blocklist file.  

**Return Values**

`bool`

> Returns true if the email domain is found in the blocklist,  
otherwise returns false.


<hr />

