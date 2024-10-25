# Yohns\Security\Honeypot  

Class Honeypot

This class implements a honeypot security measure that generates
random questions to distinguish between bots and human users.
The questions are designed to be simple and pose a challenge to
automated scripts. The responses are stored in the session for
validation purposes.  





## Methods

| Name | Description |
|------|-------------|
|[pick_pot](#honeypotpick_pot)|Randomly selects a type of question to ask from the available options.|




### Honeypot::pick_pot  

**Description**

```php
public pick_pot (void)
```

Randomly selects a type of question to ask from the available options. 

The options include mathematical operations and simple data prompts.  
This function invokes the selected question function and returns  
the result. 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`

> The randomly selected questions function within this is called.


<hr />

