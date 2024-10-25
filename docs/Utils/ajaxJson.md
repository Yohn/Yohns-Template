# Yohns\Utils\ajaxJson  







## Methods

| Name | Description |
|------|-------------|
|[bluidJson](#ajaxjsonbluidjson)|An easy way to echo out a response in json format compatible with the mf-valid forms|
|[getClass](#ajaxjsongetclass)||




### ajaxJson::bluidJson  

**Description**

```php
public static bluidJson (string $type, string $msg, string|bool $redirect, array $$add2Array)
```

An easy way to echo out a response in json format compatible with the mf-valid forms 

 

**Parameters**

* `(string) $type`
: = error || danger || success || ok  
* `(string) $msg`
: = string to be displayed  
* `(string|bool) $redirect`
: = url  
* `(array) $$add2Array`
: = [key=>val] in json response  

**Return Values**

`string`

> json_encode()


<hr />


### ajaxJson::getClass  

**Description**

```php
 getClass (void)
```

 

 

**Parameters**

`This function has no parameters.`

**Return Values**

`void`


<hr />

